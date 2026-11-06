<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'contact_person',
        'email',
        'phone',
        'address',
        'payment_terms',
        'lead_time_days',
        'minimum_order_amount',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'lead_time_days' => 'integer',
        'minimum_order_amount' => 'decimal:2',
    ];

    // Relationships

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    // Query scopes

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithLeadTime($query, $days)
    {
        return $query->where('lead_time_days', '<=', $days);
    }

    // Full contact accessor

    public function getFullContactAttribute()
    {
        return trim(
            ($this->contact_person ?? 'No contact person')
            . ' | ' .
            ($this->email ?? 'No email')
            . ' | ' .
            ($this->phone ?? 'No phone')
        );
    }

    // Supplier performance accessor

    public function getPerformanceRatingAttribute()
    {
        $deliveredOrders = $this->purchaseOrders()
            ->whereNotNull('received_date')
            ->whereNotNull('expected_delivery_date');

        $total = $deliveredOrders->count();

        if ($total == 0) {
            return 0;
        }

        $onTime = $this->purchaseOrders()
            ->whereNotNull('received_date')
            ->whereNotNull('expected_delivery_date')
            ->whereColumn(
                'received_date',
                '<=',
                'expected_delivery_date'
            )
            ->count();

        return round(($onTime / $total) * 100, 2);
    }
}
