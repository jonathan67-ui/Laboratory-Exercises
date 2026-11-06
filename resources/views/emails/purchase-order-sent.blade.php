
<!DOCTYPE html>
<html>
<body style="font-family: Arial; padding: 20px;">
    <div style="background: #0d6efd; color: white; padding: 20px;">
        <h2>Purchase Order Sent</h2>
    </div>

    <div style="padding: 20px; background: #f8f9fa;">
        <p>The purchase order has been sent to the supplier.</p>
        <p><strong>Reference:</strong> {{ $purchaseOrder->reference }}</p>
        <p><strong>Supplier:</strong> {{ $purchaseOrder->supplier->company_name }}</p>
    </div>
</body>
</html>
