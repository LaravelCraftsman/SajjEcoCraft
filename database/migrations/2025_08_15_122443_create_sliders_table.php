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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('SajjEcoCraft');           // Title of the slider
            $table->string('description')->default('SajjEcoCraft');     // Description of the slider
            $table->string('tag')->default('SajjEcoCraft');             // Tag for the slider
            $table->string('cta_label')->default('SajjEcoCraft');       // Call-to-action button label
            $table->string('cta_url')->default('https://www.google.com'); // URL for the CTA button
            $table->string('image')->nullable();                         // Path to the slider image (nullable)
            $table->enum('status', ['active', 'inactive'])->default('inactive');  // Status
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
        Schema::dropIfExists('sliders');
    }
};