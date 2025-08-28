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
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('coupon_id')
                ->nullable()
                ->constrained('coupons')
                ->onDelete('set null')
                ->after('id');

            $table->enum('coupon_type', ['fixed', 'percentage'])
                ->nullable()
                ->after('coupon_id');

            $table->decimal('coupon_value', 10, 2)
                ->nullable()
                ->after('coupon_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
            $table->dropColumn(['coupon_id', 'coupon_type', 'coupon_value']);
        });
    }
};
