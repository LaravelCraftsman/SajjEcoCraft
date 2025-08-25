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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('address');
            $table->string('company_name');
            $table->string('company_website')->unique()->nullable();
            $table->string('gst')->unique()->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('account_type')->nullable()->default('current');
            $table->string('parking_charges')->nullable();
            $table->string('operational_charges')->nullable();
            $table->string('transport')->nullable();
            $table->string('dead_stock')->nullable();
            $table->string('branding')->nullable();
            $table->string('damage_and_shrinkege')->nullable(); // Consider correcting spelling: "shrinkage"
            $table->string('profit')->nullable();
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
};
