
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Supplier</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('suppliers.update', $supplier->id) }}"
          method="POST">
        @csrf
        @method('PUT')

        @include('suppliers._form')

        <button class="btn btn-primary">Update Supplier</button>

        <a href="{{ route('suppliers.index') }}"
           class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
