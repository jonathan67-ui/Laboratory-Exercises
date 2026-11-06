<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PurchaseOrder::class, 'purchase_order');
    }

    public function index(Request $request)
    {
        $query = PurchaseOrder::with(['supplier', 'createdBy']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('order_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('order_date', '<=', $request->date_to);
        }

        $orders = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $suppliers = Supplier::orderBy('company_name')->get();

        return view('purchase_orders.index', compact(
            'orders',
            'suppliers'
        ));
    }

    public function create()
    {
        $suppliers = Supplier::active()
            ->orderBy('company_name')
            ->get();

        $products = Product::orderBy('name')->get();

        return view('purchase_orders.create', compact(
            'suppliers',
            'products'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => [
                'required',
                Rule::exists('suppliers', 'id')
                    ->where('is_active', true),
            ],
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'tax' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => [
                'required',
                'distinct',
                'exists:products,id',
            ],
'items.*.quantity_ordered' => 'nullable|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $order = DB::transaction(function () use ($validated) {
            $order = PurchaseOrder::create([
                'reference' => PurchaseOrder::generateReferenceNumber(),
                'supplier_id' => $validated['supplier_id'],
                'status' => 'draft',
                'order_date' => $validated['order_date'],
                'expected_delivery_date' =>
                    $validated['expected_delivery_date'] ?? null,
                'tax' => $validated['tax'] ?? 0,
                'notes' => $validated['notes'] ?? null,
                'terms' => $validated['terms'] ?? null,
                'created_by' => auth()->id(),
            ]);

          $selectedItems = collect($validated['items'])
    ->filter(function ($item) {
        return !empty($item['quantity_ordered'])
            && $item['quantity_ordered'] > 0;
    });

if ($selectedItems->isEmpty()) {
    throw \Illuminate\Validation\ValidationException::withMessages([
        'items' => 'Please enter a quantity for at least one product.',
    ]);
}

foreach ($selectedItems as $item) {
    $order->items()->create([
        'product_id' => $item['product_id'],
        'quantity_ordered' => $item['quantity_ordered'],
        'quantity_received' => 0,
        'unit_price' => $item['unit_price'],
    ]);
}
            $order->calculateTotal();

            return $order;
        });

        return redirect()
            ->route('purchase-orders.show', $order)
            ->with('success', 'Purchase order created successfully.');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load([
            'supplier',
            'createdBy',
            'approvedBy',
            'items.product',
        ]);

        return view('purchase_orders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        abort_unless($purchaseOrder->status === 'draft', 403);

        $suppliers = Supplier::active()->get();
        $products = Product::orderBy('name')->get();

        $purchaseOrder->load('items.product');

        return view('purchase_orders.edit', compact(
            'purchaseOrder',
            'suppliers',
            'products'
        ));
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        abort_unless($purchaseOrder->status === 'draft', 403);

        $validated = $request->validate([
            'supplier_id' => [
                'required',
                Rule::exists('suppliers', 'id')
                    ->where('is_active', true),
            ],
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'tax' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => [
                'required',
                'distinct',
                'exists:products,id',
            ],
            'items.*.quantity_ordered' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $purchaseOrder) {
            $purchaseOrder->update([
                'supplier_id' => $validated['supplier_id'],
                'order_date' => $validated['order_date'],
                'expected_delivery_date' =>
                    $validated['expected_delivery_date'] ?? null,
                'tax' => $validated['tax'] ?? 0,
                'notes' => $validated['notes'] ?? null,
                'terms' => $validated['terms'] ?? null,
            ]);

            $purchaseOrder->items()->delete();

            foreach ($validated['items'] as $item) {
                $purchaseOrder->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity_ordered' => $item['quantity_ordered'],
                    'quantity_received' => 0,
                    'unit_price' => $item['unit_price'],
                ]);
            }

            $purchaseOrder->calculateTotal();
        });

        return redirect()
            ->route('purchase-orders.show', $purchaseOrder)
            ->with('success', 'Purchase order updated successfully.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'draft') {
            return back()->with(
                'error',
                'Only draft purchase orders can be deleted.'
            );
        }

        $purchaseOrder->delete();

        return redirect()
            ->route('purchase-orders.index')
            ->with('success', 'Purchase order deleted successfully.');
    }

    public function approve(PurchaseOrder $purchaseOrder)
    {
        $this->authorize('approve', $purchaseOrder);

        if (!$purchaseOrder->canBeApproved()) {
            return back()->with('error', 'This order cannot be approved.');
        }

        $purchaseOrder->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Purchase order approved.');
    }

    public function reject(Request $request, PurchaseOrder $purchaseOrder)
    {
        $this->authorize('approve', $purchaseOrder);

        $request->validate([
            'rejection_reason' => 'required|string|max:2000',
        ]);

        if (!$purchaseOrder->canBeApproved()) {
            return back()->with('error', 'This order cannot be rejected.');
        }

        $purchaseOrder->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Purchase order rejected.');
    }

    public function send(PurchaseOrder $purchaseOrder)
    {
       $this->authorize('send', $purchaseOrder);

        if ($purchaseOrder->status !== 'approved') {
            return back()->with(
                'error',
                'Only approved orders can be sent.'
            );
        }

        $purchaseOrder->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        // Supplier email notification will be added in Part 4.

        return back()->with('success', 'Purchase order marked as sent.');
    }

    public function receive(Request $request, PurchaseOrder $purchaseOrder)
    {
        $this->authorize('receive', $purchaseOrder);

        if (!$purchaseOrder->canBeReceived()) {
            return back()->with(
                'error',
                'This purchase order cannot receive items.'
            );
        }

        $request->validate([
            'items' => 'required|array',
            'items.*.quantity_received' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request, $purchaseOrder) {
            $purchaseOrder->load('items');

            foreach ($purchaseOrder->items as $item) {
                $newQuantity = (int) (
                    $request->input(
                        'items.' . $item->id . '.quantity_received',
                        0
                    )
                );

                if ($newQuantity > $item->outstanding_quantity) {
                    throw new \RuntimeException(
                        'Received quantity cannot exceed outstanding quantity.'
                    );
                }

                $item->increment('quantity_received', $newQuantity);
            }

            $purchaseOrder->load('items');

            $allReceived = $purchaseOrder->items->every(
                fn ($item) => $item->quantity_received >= $item->quantity_ordered
            );

            if ($allReceived) {
                $purchaseOrder->update([
                    'status' => 'received',
                    'received_date' => now()->toDateString(),
                ]);
            }
        });

        return back()->with(
            'success',
            'Received quantities recorded. Inventory transaction integration is the next step.'
        );
    }
}
