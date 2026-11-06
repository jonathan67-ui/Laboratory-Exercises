
@extends('layouts.app')

@section('content')
<div class="container">

    <h2>Supplier Details</h2>

    <div class="card mb-4">
        <div class="card-body">

            <h4>{{ $supplier->company_name }}</h4>

            <p><strong>Contact:</strong>
                {{ $supplier->contact_person }}</p>

            <p><strong>Email:</strong>
                {{ $supplier->email }}</p>

            <p><strong>Phone:</strong>
                {{ $supplier->phone }}</p>

            <p><strong>Address:</strong>
                {{ $supplier->address }}</p>

            <p><strong>Payment Terms:</strong>
                {{ $supplier->payment_terms }}</p>

            <p><strong>Lead Time:</strong>
                {{ $supplier->lead_time_days }} days</p>

            <p><strong>Minimum Order:</strong>
                ₱{{ number_format($supplier->minimum_order_amount, 2) }}</p>

            <p><strong>Performance Rating:</strong>
                {{ $supplier->performance_rating }}%</p>

            <p>
                <strong>Status:</strong>
                {{ $supplier->is_active ? 'Active' : 'Inactive' }}
            </p>

            <a href="{{ route('suppliers.edit', $supplier->id) }}"
               class="btn btn-warning">Edit Supplier</a>

            <a href="{{ route('suppliers.index') }}"
               class="btn btn-secondary">Back</a>

        </div>
    </div>

    <h4>Recent Purchase Orders</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @forelse($supplier->purchaseOrders as $order)
                <tr>
                    <td>{{ $order->reference }}</td>
                    <td>{{ $order->order_date }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>₱{{ number_format($order->total, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No purchase orders yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4>Products Supplied</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>SKU</th>
            </tr>
        </thead>

        <tbody>
            @forelse($supplier->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No products assigned.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
