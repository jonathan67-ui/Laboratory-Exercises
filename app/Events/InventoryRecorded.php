<?php

namespace App\Events;

use App\Models\InventoryTransaction;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InventoryRecorded
{
    use Dispatchable, SerializesModels;

    public $transaction;

    public function __construct(InventoryTransaction $transaction)
    {
        $this->transaction = $transaction;
    }
}