
<!DOCTYPE html>
<html>
<body style="font-family: Arial; padding: 20px;">
    <div style="background: #198754; color: white; padding: 20px;">
        <h2>Purchase Order Approved</h2>
    </div>

    <div style="padding: 20px; background: #f8f9fa;">
        <p>Your purchase order has been approved.</p>
        <p><strong>Reference:</strong> {{ $purchaseOrder->reference }}</p>
        <p><strong>Supplier:</strong> {{ $purchaseOrder->supplier->company_name }}</p>
        <p><strong>Total:</strong> {{ number_format($purchaseOrder->total, 2) }}</p>
    </div>
</body>
</html>
