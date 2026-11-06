
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Purchase Orders</h1>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('purchase-orders.create') }}"
           class="btn btn-primary">
            + Create Purchase Order
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>PO Number</th>
                <th>Supplier</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->po_number }}</td>
                    <td>{{ $order->supplier->company_name ?? 'N/A' }}</td>
                    <td>{{ $order->order_date }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>₱{{ number_format($order->total_amount ?? 0, 2) }}</td>
                    <td>
                        <a href="{{ route('purchase-orders.show', $order->id) }}">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">
                        No purchase orders found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection
