
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();

            $table->string('reference')->unique();

            $table->foreignId('supplier_id')
                ->constrained()
                ->restrictOnDelete();

            $table->enum('status', [
                'draft',
                'pending',
                'approved',
                'sent',
                'received',
                'cancelled',
                'rejected',
            ])->default('draft')->index();

            $table->date('order_date');
            $table->date('expected_delivery_date')->nullable();
            $table->date('received_date')->nullable();

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            $table->text('notes')->nullable();
            $table->text('terms')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('sent_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['supplier_id', 'status']);
            $table->index(['order_date', 'expected_delivery_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
};
