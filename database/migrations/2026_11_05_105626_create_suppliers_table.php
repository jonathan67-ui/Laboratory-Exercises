
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();

            // Supplier information
            $table->string('company_name');
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone', 30)->nullable();
            $table->text('address')->nullable();

            // Business information
            $table->string('payment_terms')->default('COD');
            $table->unsignedInteger('lead_time_days')->default(7);
            $table->decimal('minimum_order_amount', 12, 2)
                  ->default(0);

            // Supplier status
            $table->boolean('is_active')->default(true);

            // Indexes
            $table->index('company_name');
            $table->index('is_active');
            $table->index('lead_time_days');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
};
