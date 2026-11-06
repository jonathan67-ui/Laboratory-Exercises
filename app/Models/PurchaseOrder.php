<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference',
        'supplier_id',
        'status',
        'order_date',
        'expected_delivery_date',
        'received_date',
        'subtotal',
        'tax',
        'total',
        'notes',
        'terms',
        'created_by',
        'approved_by',
        'approved_at',
        'sent_at',
        'rejection_reason',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
        'received_date' => 'date',
        'approved_at' => 'datetime',
        'sent_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // Relationships

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [
            'received',
            'cancelled',
            'rejected',
        ]);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Calculate subtotal and total

    public function calculateTotal()
    {
        $subtotal = $this->items()
            ->get()
            ->sum(function ($item) {
                return $item->quantity_ordered * $item->unit_price;
            });

        $this->subtotal = $subtotal;
        $this->total = $subtotal + (float) $this->tax;

        $this->save();

        return $this->total;
    }

    // State checks

   public function canBeApproved()
{
    return $this->status === 'draft';
}

    public function canBeReceived()
    {
        return in_array($this->status, ['approved', 'sent']);
    }

    // Unique reference number

    public static function generateReferenceNumber()
    {
        do {
            $reference = 'PO-' . now()->format('Ymd') . '-'
                . strtoupper(Str::random(6));
        } while (self::where('reference', $reference)->exists());

        return $reference;
    }
}
