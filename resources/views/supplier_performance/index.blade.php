@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Supplier Performance Report</h2>
            <p class="text-muted">
                Overview of supplier purchase order activity
            </p>
        </div>

        <button onclick="window.print()" class="btn btn-primary">
            Print Report
        </button>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">

        <div class="col-md-4 col-lg mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Suppliers</h6>
                    <h3>{{ $totalSuppliers }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Orders</h6>
                    <h3>{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Completed Orders</h6>
                    <h3 class="text-success">{{ $completedOrders }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Pending Orders</h6>
                    <h3 class="text-warning">{{ $pendingOrders }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Purchase Amount</h6>
                    <h3>₱{{ number_format($totalAmount, 2) }}</h3>
                </div>
            </div>
        </div>

    </div>

    {{-- Supplier Performance Table --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Supplier Performance Details</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Supplier</th>
                            <th>Contact Person</th>
                            <th>Total Orders</th>
                            <th>Completed</th>
                            <th>Pending</th>
                            <th>Total Purchase Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($suppliers as $supplier)
                            @php
                                $orders = $supplier->purchaseOrders;

                                $completed = $orders
                                    ->where('status', 'received')
                                    ->count();

                                $pending = $orders
                                    ->whereIn('status', [
                                        'draft',
                                        'pending',
                                        'approved',
                                        'sent'
                                    ])
                                    ->count();

                                $amount = $orders->sum('total');
                            @endphp

                            <tr>
                                <td>{{ $supplier->company_name }}</td>
                                <td>{{ $supplier->contact_person ?? 'N/A' }}</td>
                                <td>{{ $orders->count() }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $completed }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        {{ $pending }}
                                    </span>
                                </td>
                                <td>
                                    ₱{{ number_format($amount, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    No supplier records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<a class="nav-link"
   href="{{ route('suppliers.performance') }}">
    📊 &nbsp; Supplier Performance Report
</a>
@endsection