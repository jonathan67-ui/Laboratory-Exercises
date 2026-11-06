@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Purchase Order Details</h1>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('purchase-orders.index') }}"
           class="btn btn-secondary">
            ← Back to Purchase Orders
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <h3>Order Information</h3>

            <p><strong>Reference:</strong>
                {{ $purchaseOrder->reference }}
            </p>

            <p><strong>Supplier:</strong>
                {{ $purchaseOrder->supplier->company_name ?? 'N/A' }}
            </p>

            <p><strong>Order Date:</strong>
                {{ $purchaseOrder->order_date }}
            </p>

            <p><strong>Expected Delivery:</strong>
                {{ $purchaseOrder->expected_delivery_date ?? 'Not specified' }}
            </p>

            <p><strong>Status:</strong>
                {{ ucfirst($purchaseOrder->status) }}
            </p>

            <p><strong>Notes:</strong>
                {{ $purchaseOrder->notes ?? 'None' }}
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3>Ordered Products</h3>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity Ordered</th>
                        <th>Quantity Received</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($purchaseOrder->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'N/A' }}</td>
                            <td>{{ $item->quantity_ordered }}</td>
                            <td>{{ $item->quantity_received }}</td>
                            <td>₱{{ number_format($item->unit_price, 2) }}</td>
                            <td>
                                ₱{{ number_format($item->quantity_ordered * $item->unit_price, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h4 style="text-align: right;">
                Tax: ₱{{ number_format($purchaseOrder->tax ?? 0, 2) }}
            </h4>
        </div>
    </div>

</div>
@if($purchaseOrder->status === 'draft')
    @can('approve', $purchaseOrder)
        <form action="{{ route('purchase-orders.approve', $purchaseOrder->id) }}"
              method="POST"
              style="margin-bottom: 20px;">
            @csrf

            <button type="submit"
                    class="btn btn-primary"
                    onclick="return confirm('Are you sure you want to approve this purchase order?')">
                ✓ Approve Purchase Order
            </button>
        </form>
    @endcan
@endif
@endsection