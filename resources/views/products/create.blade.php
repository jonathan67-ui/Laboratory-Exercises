@extends('layouts.app')

@section('content')

<h1 class="mb-4">Add Product</h1>

<div class="card p-4">
    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        @include('products.form')

        <button type="submit" class="btn btn-green">
            Save Product
        </button>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>

@endsection