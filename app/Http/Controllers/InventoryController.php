<?php

namespace App\Http\Controllers;

use App\Events\InventoryRecorded;
use App\Models\InventoryTransaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();

        $transactions = InventoryTransaction::with([
            'product',
            'user',
        ])->latest()->take(10)->get();

        return view('inventory.index', compact(
            'products',
            'transactions'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],
            'type' => [
                'required',
                Rule::in([
                    'stock_in',
                    'stock_out',
                    'return',
                    'damaged',
                ]),
            ],
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $transaction = DB::transaction(function () use (
                $validated,
                $request
            ) {
                Product::whereKey($validated['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                return InventoryTransaction::create([
                    'product_id' => $validated['product_id'],
                    'user_id' => $request->user()->id,
                    'type' => $validated['type'],
                    'quantity' => $validated['quantity'],
                    'notes' => $validated['notes'] ?? null,
                ]);
            });

            InventoryRecorded::dispatch($transaction);

            return redirect()
                ->route('inventory.index')
                ->with(
                    'success',
                    'Inventory transaction recorded!'
                );
        } catch (\Illuminate\Database\QueryException $e) {
            report($e);

            return back()
                ->withInput()
                ->withErrors([
                    'quantity' => 'The transaction could not be saved. Check the database and available stock.',
                ]);
        }
    }

    public function summary()
    {
        $products = Product::orderBy('name')->get();

        $totalProducts = $products->count();

        $lowStockCount = $products->filter(function ($product) {
            return $product->quantity <= $product->reorder_level;
        })->count();

        return view('inventory.summary', [
            'products' => $products,
            'total_products' => $totalProducts,
            'low_stock_count' => $lowStockCount,
        ]);
    }

    public function apiTransactions()
    {
        return response()->json([
            'transactions' => InventoryTransaction::with([
                'product:id,name,sku',
                'user:id,name',
            ])->latest()->take(50)->get(),
        ]);
    }

    public function dashboardStats()
    {
        return response()->json([
            'total_products' => Product::count(),

            'low_stock_count' => Product::whereColumn(
                'quantity',
                '<=',
                'reorder_level'
            )->count(),

            'out_of_stock_count' => Product::where(
                'quantity',
                '<=',
                0
            )->count(),

            'total_transactions' => InventoryTransaction::count(),
        ]);
    }

    public function lowStockProducts()
    {
        return response()->json([
            'products' => Product::whereColumn(
                'quantity',
                '<=',
                'reorder_level'
            )->orderBy('name')->get(),
        ]);
    }

    public function recentTransactions()
    {
        return response()->json([
            'transactions' => InventoryTransaction::with([
                'product:id,name,sku',
                'user:id,name',
            ])->latest()->take(10)->get(),
        ]);
    }
}