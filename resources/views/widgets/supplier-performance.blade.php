
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h5>Suppliers</h5>

        @forelse($topSuppliers as $supplier)
            <p>
                {{ $supplier->company_name }}
                <span class="badge bg-primary">
                    {{ $supplier->purchase_orders_count }} orders
                </span>
            </p>
        @empty
            <p>No suppliers found.</p>
        @endforelse
    </div>
</div>
