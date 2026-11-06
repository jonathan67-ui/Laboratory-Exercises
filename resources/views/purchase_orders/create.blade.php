@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Purchase Order</h1>

    <form action="{{ route('purchase-orders.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label>Supplier</label>
            <select name="supplier_id" class="form-control" required>
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">
                        {{ $supplier->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Order Date</label>
            <input type="date"
                   name="order_date"
                   class="form-control"
                   value="{{ date('Y-m-d') }}"
                   required>
        </div>

<h3>Products</h3>

@foreach($products as $product)
    <div class="form-group mb-3">
        <label>
            {{ $product->name }}
            (₱{{ number_format($product->unit_price, 2) }})
        </label>

        <input type="hidden"
               name="items[{{ $loop->index }}][product_id]"
               value="{{ $product->id }}">

        <input type="number"
               name="items[{{ $loop->index }}][quantity_ordered]"
               class="form-control"
               min="1"
               placeholder="Enter quantity">

        <input type="hidden"
               name="items[{{ $loop->index }}][unit_price]"
               value="{{ $product->unit_price }}">
    </div>
@endforeach

        <button type="submit" class="btn btn-primary">
            Create Purchase Order
        </button>

        <a href="{{ route('purchase-orders.index') }}"
           class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>
@endsection