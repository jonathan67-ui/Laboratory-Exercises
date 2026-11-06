<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class CheckLowStock extends Command
{
    protected $signature = 'inventory:check-low-stock';

    protected $description = 'Check products that need replenishment';

    public function handle()
    {
        $this->info('Starting inventory reorder check...');

        $products = Product::whereColumn(
            'quantity',
            '<=',
            'reorder_level'
        )->get();

        $this->info('Checking low-stock products...');

        $this->info(
            'Found ' . $products->count() .
            ' products that need replenishment.'
        );

        foreach ($products as $product) {
            $this->line(
                $product->name .
                ' - Current Stock: ' . $product->quantity .
                ' - Reorder Level: ' . $product->reorder_level
            );
        }

        $this->info('Reorder check completed successfully.');

        return Command::SUCCESS;
    }
}