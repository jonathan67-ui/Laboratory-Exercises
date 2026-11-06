
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h5>Reorder Alerts</h5>

        @forelse($reorderProducts as $product)
            <p>
                {{ $product->name }}
                <span class="badge bg-danger">Low stock</span>
            </p>
        @empty
            <p>No products need reordering.</p>
        @endforelse
    </div>
</div>
