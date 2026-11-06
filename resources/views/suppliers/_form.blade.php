
<div class="mb-3">
    <label class="form-label">Company Name *</label>
    <input type="text" name="company_name"
        class="form-control"
        value="{{ old('company_name', $supplier->company_name ?? '') }}"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Contact Person</label>
    <input type="text" name="contact_person"
        class="form-control"
        value="{{ old('contact_person', $supplier->contact_person ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email"
        class="form-control"
        value="{{ old('email', $supplier->email ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Phone Number</label>
    <input type="text" name="phone"
        class="form-control"
        value="{{ old('phone', $supplier->phone ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Physical Address</label>
    <textarea name="address" class="form-control">{{ old('address', $supplier->address ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Payment Terms *</label>
    <select name="payment_terms" class="form-select" required>
        @foreach(['COD', 'Net 15', 'Net 30', 'Net 60'] as $term)
            <option value="{{ $term }}"
                @selected(old('payment_terms', $supplier->payment_terms ?? 'COD') == $term)>
                {{ $term }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Lead Time (Days) *</label>
    <input type="number" name="lead_time_days"
        class="form-control"
        min="0"
        value="{{ old('lead_time_days', $supplier->lead_time_days ?? 7) }}"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Minimum Order Amount *</label>
    <input type="number" step="0.01" min="0"
        name="minimum_order_amount"
        class="form-control"
        value="{{ old('minimum_order_amount', $supplier->minimum_order_amount ?? 0) }}"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Status *</label>
    <select name="is_active" class="form-select" required>
        <option value="1" @selected(old('is_active', $supplier->is_active ?? 1) == 1)>
            Active
        </option>
        <option value="0" @selected(old('is_active', $supplier->is_active ?? 1) == 0)>
            Inactive
        </option>
    </select>
</div>
