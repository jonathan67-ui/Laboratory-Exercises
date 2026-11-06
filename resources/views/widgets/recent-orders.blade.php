
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h5>Recent Purchase Orders</h5>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Supplier</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td>{{ $order->reference }}</td>
                        <td>{{ $order->supplier->company_name ?? 'N/A' }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
