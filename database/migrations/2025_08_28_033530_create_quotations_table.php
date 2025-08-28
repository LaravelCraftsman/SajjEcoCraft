<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
          $table->id();
            $table->foreignId('customer_id')->constrained('users');
            $table->string('quotation_number')->unique();
            $table->date('quotation_date');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->enum('status', ['draft', 'sent', 'paid', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();
            $table->foreignId('coupon_id')
                ->nullable()
                ->constrained('coupons')
                ->onDelete('set null');

            $table->enum('coupon_type', ['fixed', 'percentage'])
                ->nullable();

            $table->decimal('coupon_value', 10, 2)
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotations');
    }
};
