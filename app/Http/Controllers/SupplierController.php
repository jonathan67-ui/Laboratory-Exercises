<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'LIKE', "%$search%")
                  ->orWhere('contact_person', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        // Active status filter
        if ($request->filled('status')) {
            $query->where(
                'is_active',
                $request->status === 'active'
            );
        }

        // Sorting
        $allowedSorts = [
            'company_name',
            'lead_time_days',
            'created_at'
        ];

        $sort = in_array($request->sort, $allowedSorts)
            ? $request->sort
            : 'company_name';

        $suppliers = $query
            ->withCount('purchaseOrders')
            ->orderBy($sort)
            ->paginate(10)
            ->withQueryString();

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email',
            'phone' => [
                'nullable',
                'regex:/^[0-9+\-\s()]{7,30}$/'
            ],
            'address' => 'nullable|string',
            'payment_terms' => 'required|string|max:100',
            'lead_time_days' => 'required|integer|min:0',
            'minimum_order_amount' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        Supplier::create($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier added successfully!');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load([
            'purchaseOrders' => function ($query) {
                $query->latest()->take(10);
            },
            'products'
        ]);

        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => [
                'nullable',
                'email',
                Rule::unique('suppliers', 'email')
                    ->ignore($supplier->id)
            ],
            'phone' => [
                'nullable',
                'regex:/^[0-9+\-\s()]{7,30}$/'
            ],
            'address' => 'nullable|string',
            'payment_terms' => 'required|string|max:100',
            'lead_time_days' => 'required|integer|min:0',
            'minimum_order_amount' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $supplier->update($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier updated successfully!');
    }

    public function destroy(Supplier $supplier)
    {
        $hasPendingOrders = $supplier->purchaseOrders()
            ->whereIn('status', [
                'pending',
                'approved',
                'sent',
                'partially_received'
            ])
            ->exists();

        if ($hasPendingOrders) {
            return back()->with(
                'error',
                'Cannot delete supplier with active purchase orders.'
            );
        }

        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier archived successfully!');
    }
}
