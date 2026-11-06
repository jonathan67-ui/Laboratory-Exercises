
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Advanced Search</h2>

    <form method="GET" action="{{ route('search.index') }}"
          class="card card-body mb-4">

        <div class="row">
            <div class="col-md-4">
                <label>Search Reference or Product</label>
                <input type="text" name="search"
                    value="{{ request('search') }}"
                    class="form-control">
            </div>

            <div class="col-md-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="">All statuses</option>
                    @foreach(['draft','pending','approved','sent','received','cancelled','rejected'] as $status)
                        <option value="{{ $status }}"
                            @selected(request('status') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label>From</label>
                <input type="date" name="from"
                    value="{{ request('from') }}"
                    class="form-control">
            </div>

            <div class="col-md-2">
                <label>To</label>
                <input type="date" name="to"
                    value="{{ request('to') }}"
                    class="form-control">
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <h4>Products</h4>
    @foreach($products as $product)
        <p>{{ $product->name }} - {{ $product->sku }}</p>
    @endforeach
    {{ $products->links() }}

    <h4>Purchase Orders</h4>
    @foreach($orders as $order)
        <p>{{ $order->reference }} - {{ $order->status }}</p>
    @endforeach
    {{ $orders->links() }}

    <h4>Inventory Transactions</h4>
    @foreach($transactions as $transaction)
        <p>Transaction #{{ $transaction->id }}</p>
    @endforeach
    {{ $transactions->links() }}
</div>
@endsection
