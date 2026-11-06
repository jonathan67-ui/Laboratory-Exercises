<?php

namespace App\Observers;

use App\Models\PurchaseOrder;
use App\Mail\PurchaseOrderCreated;
use App\Mail\PurchaseOrderApproved;
use App\Mail\PurchaseOrderSent;
use Illuminate\Support\Facades\Mail;

class PurchaseOrderObserver
{
    public function created(PurchaseOrder $purchaseOrder)
    {
        $email = config('mail.admin_address');

        if ($email) {
            $purchaseOrder->load('supplier');

            Mail::to($email)->send(
                new PurchaseOrderCreated($purchaseOrder)
            );
        }
    }

    public function updated(PurchaseOrder $purchaseOrder)
    {
        if (!$purchaseOrder->wasChanged('status')) {
            return;
        }

        $email = config('mail.admin_address');

        if (!$email) {
            return;
        }

        $purchaseOrder->load('supplier');

        if ($purchaseOrder->status === 'approved') {
            Mail::to($email)->send(
                new PurchaseOrderApproved($purchaseOrder)
            );
        }

        if ($purchaseOrder->status === 'sent') {
            Mail::to($email)->send(
                new PurchaseOrderSent($purchaseOrder)
            );
        }
    }
}
