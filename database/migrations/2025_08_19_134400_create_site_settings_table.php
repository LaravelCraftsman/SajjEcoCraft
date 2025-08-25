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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Sajj Eco Craft')->nullable();
            $table->string('tag_line')->nullable();
            $table->string('logo_light_image')->nullable();
            $table->string('logo_dark_image')->nullable();
            $table->string('favicon_image')->nullable();
            $table->string('phone_number')->default('(+91)-8347471711')->nullable();
            $table->string('email_address')->default('info@sajjecocraft.com')->nullable();
            $table->longText('address')->nullable();
            $table->longText('description')->nullable();
            $table->string('facebook')->nullable()->default('#');
            $table->string('youtube')->nullable()->default('#');
            $table->string('linkedin')->nullable()->default('#');
            $table->string('instagram')->nullable()->default('#');

            // Meta tags
            $table->string('meta_description')->nullable()->default('SajjEcoCraft');
            $table->string('meta_keywords')->nullable()->default('SajjEcoCraft');
            $table->string('meta_author')->nullable()->default('SajjEcoCraft');
            $table->string('canonical_url')->nullable()->default('SajjEcoCraft');
            $table->string('og_title')->nullable()->default('SajjEcoCraft');
            $table->string('og_description')->nullable()->default('SajjEcoCraft');
            $table->string('og_image')->nullable()->default('SajjEcoCraft');
            $table->string('og_url')->nullable()->default('SajjEcoCraft');
            $table->string('og_type')->nullable()->default('SajjEcoCraft');
            $table->string('og_site_name')->nullable()->default('SajjEcoCraft');
            $table->string('twitter_card')->nullable()->default('SajjEcoCraft');
            $table->string('twitter_title')->nullable()->default('SajjEcoCraft');
            $table->string('twitter_description')->nullable()->default('SajjEcoCraft');
            $table->string('twitter_image')->nullable()->default('SajjEcoCraft');
            $table->string('twitter_url')->nullable()->default('SajjEcoCraft');
            $table->string('twitter_site')->nullable()->default('SajjEcoCraft');
            $table->string('twitter_creator')->nullable()->default('SajjEcoCraft');

            // Location
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('map_link')->nullable();

            // Bank details
            $table->string('gst')->nullable()->default('SajJEcoCraft');
            $table->string('account_holder_name')->nullable()->default('SajJEcoCraft');
            $table->string('bank_name')->nullable()->default('SajJEcoCraft');
            $table->string('account_number')->nullable()->default('SajJEcoCraft');
            $table->string('ifsc_code')->nullable()->default('SajJEcoCraft');
            $table->string('bank_address')->nullable()->default('SajJEcoCraft');
            $table->string('account_type')->nullable()->default('SajJEcoCraft');
            $table->string('upi_id')->nullable()->default('SajJEcoCraft');
            $table->string('upi_number')->nullable()->default('SajJEcoCraft');
            $table->string('upi_qr_code_image')->nullable()->default('SajJEcoCraft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_settings');
    }
};
