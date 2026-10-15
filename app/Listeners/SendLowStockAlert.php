<?php

namespace App\Listeners;

use App\Events\InventoryRecorded;
use App\Models\User;
use App\Notifications\LowStockNotification;

class SendLowStockAlert
{
    public function handle(InventoryRecorded $event): void
    {
        $product = $event->transaction->product()->first();

        if (!$product) {
            return;
        }

        // If stock is above the reorder level,
        // remove existing low-stock notifications.
        if ($product->quantity > $product->reorder_level) {
            foreach (User::all() as $user) {
                $user->notifications()
                    ->where('type', LowStockNotification::class)
                    ->where('data->product_id', $product->id)
                    ->delete();
            }

            return;
        }

        // If stock is low, create a notification.
        foreach (User::all() as $user) {
            $user->notifyNow(
                new LowStockNotification($product)
            );
        }
    }
}