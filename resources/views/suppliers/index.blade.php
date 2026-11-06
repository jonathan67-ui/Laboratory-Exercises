
@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-4">
        <h2>Supplier Management</h2>

        <a href="{{ route('suppliers.create') }}"
           class="btn btn-primary">
            + Add Supplier
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="GET" class="row mb-3">

        <div class="col-md-5">
            <input type="text" name="search"
                   class="form-control"
                   placeholder="Search supplier..."
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Suppliers</option>
                <option value="active" @selected(request('status') == 'active')>
                    Active
                </option>
                <option value="inactive" @selected(request('status') == 'inactive')>
                    Inactive
                </option>
            </select>
        </div>

        <div class="col-md-2">
            <select name="sort" class="form-select">
                <option value="company_name">Name</option>
                <option value="lead_time_days">Lead Time</option>
                <option value="created_at">Date Added</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-dark w-100">Search</button>
        </div>

    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">

            <thead class="table-dark">
                <tr>
                    <th>Company</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Lead Time</th>
                    <th>Orders</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->company_name }}</td>
                        <td>{{ $supplier->contact_person }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td>{{ $supplier->phone }}</td>
                        <td>{{ $supplier->lead_time_days }} days</td>
                        <td>{{ $supplier->purchase_orders_count }}</td>

                        <td>
                            @if($supplier->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('suppliers.show', $supplier->id) }}"
                               class="btn btn-info btn-sm">View</a>

                            <a href="{{ route('suppliers.edit', $supplier->id) }}"
                               class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('suppliers.destroy', $supplier->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Archive this supplier?')">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            No suppliers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{ $suppliers->links() }}

</div>
@endsection
