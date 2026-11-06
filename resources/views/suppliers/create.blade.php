
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Supplier</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf

        @include('suppliers._form')

        <button class="btn btn-primary">Save Supplier</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>
@endsection
