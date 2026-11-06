
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('purchase_order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained()
                ->restrictOnDelete();

            $table->unsignedInteger('quantity_ordered');
            $table->unsignedInteger('quantity_received')->default(0);

            $table->decimal('unit_price', 12, 2);

            $table->timestamps();

            $table->unique(
                ['purchase_order_id', 'product_id'],
                'purchase_order_product_unique'
            );
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
