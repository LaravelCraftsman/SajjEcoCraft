<?php

namespace App\Http\Controllers;

use App\Models\SiteSettings;
use Illuminate\Http\Request;
use App\Helpers\ImageUploadHelper;

class SiteSettingsController extends Controller {
    public function index() {
        $site_settings = SiteSettings::firstOrCreate(
            [ 'id' => 1 ], // Conditions ( where clause to find the record )
            [
                'title' => 'Sajj Eco Craft',
                'tag_line' => 'Hello World',
                'phone_number' => '(+91)-8347471711',
                'email_address' => 'info@sajjecocraft.com',
                'facebook' => '#',
                'youtube' => '#',
                'linkedin' => '#',
                'instagram' => '#',
                'meta_description' => 'SajjEcoCraft',
                'meta_keywords' => 'SajjEcoCraft',
                'meta_author' => 'SajjEcoCraft',
                'latitude' => '',
                'longitude' => '',
                'map_link' => '',
                'gst' => 'SajJEcoCraft',
                'account_holder_name' => 'SajJEcoCraft',
                'bank_name' => 'SajJEcoCraft',
                'account_number' => 'SajJEcoCraft',
                'ifsc_code' => 'SajJEcoCraft',
                'bank_address' => 'SajJEcoCraft',
                'account_type' => 'SajJEcoCraft',
                'upi_id' => 'SajJEcoCraft',
                'upi_number' => 'SajJEcoCraft',
                'upi_qr_code_image' => 'SajJEcoCraft',
            ]
        );
        return view( 'site_settings.index', compact( 'site_settings' ) );
    }

    // Update method for site settings

    public function update( Request $request, $id ) {
        // Validate the request data
        $validated = $request->validate( [
            'title' => 'nullable|string|max:255',
            'tag_line' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email_address' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'facebook' => 'nullable|url',
            'youtube' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_author' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:255',
            'og_url' => 'nullable|url',
            'og_type' => 'nullable|string|max:255',
            'og_site_name' => 'nullable|string|max:255',
            'twitter_card' => 'nullable|string|max:255',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:255',
            'twitter_url' => 'nullable|url',
            'twitter_site' => 'nullable|string|max:255',
            'twitter_creator' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'map_link' => 'nullable|url',
            'gst' => 'nullable|string|max:255',
            'account_holder_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'bank_address' => 'nullable|string|max:255',
            'account_type' => 'nullable|string|max:255',
            'upi_id' => 'nullable|string|max:255',
            'upi_number' => 'nullable|string|max:255',
            // Image validation
            'logo_light_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'logo_dark_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'favicon_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'og_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'twitter_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'upi_qr_code_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ] );

        $settings = SiteSettings::findOrFail( $id );

        // Assign text and non-file fields manually
        $settings->title = $request->input( 'title', 'Sajj Eco Craft' );
        $settings->tag_line = $request->input( 'tag_line' );
        $settings->phone_number = $request->input( 'phone_number', '(+91)-8347471711' );
        $settings->email_address = $request->input( 'email_address', 'info@sajjecocraft.com' );
        $settings->address = $request->input( 'address' );
        $settings->description = $request->input( 'description' );

        // Social links
        $settings->facebook = $request->input( 'facebook', '#' );
        $settings->youtube = $request->input( 'youtube', '#' );
        $settings->linkedin = $request->input( 'linkedin', '#' );
        $settings->instagram = $request->input( 'instagram', '#' );

        // Meta tags
        $settings->meta_description = $request->input( 'meta_description', 'SajjEcoCraft' );
        $settings->meta_keywords = $request->input( 'meta_keywords', 'SajjEcoCraft' );
        $settings->meta_author = $request->input( 'meta_author', 'SajjEcoCraft' );
        $settings->canonical_url = $request->input( 'canonical_url', 'SajjEcoCraft' );
        $settings->og_title = $request->input( 'og_title', 'SajjEcoCraft' );
        $settings->og_description = $request->input( 'og_description', 'SajjEcoCraft' );
        $settings->og_url = $request->input( 'og_url', 'SajjEcoCraft' );
        $settings->og_type = $request->input( 'og_type', 'SajjEcoCraft' );
        $settings->og_site_name = $request->input( 'og_site_name', 'SajjEcoCraft' );
        $settings->twitter_card = $request->input( 'twitter_card', 'SajjEcoCraft' );
        $settings->twitter_title = $request->input( 'twitter_title', 'SajjEcoCraft' );
        $settings->twitter_description = $request->input( 'twitter_description', 'SajjEcoCraft' );
        $settings->twitter_url = $request->input( 'twitter_url', 'SajjEcoCraft' );
        $settings->twitter_site = $request->input( 'twitter_site', 'SajjEcoCraft' );
        $settings->twitter_creator = $request->input( 'twitter_creator', 'SajjEcoCraft' );

        // Location
        $settings->latitude = $request->input( 'latitude' );
        $settings->longitude = $request->input( 'longitude' );
        $settings->map_link = $request->input( 'map_link' );

        // Bank details
        $settings->gst = $request->input( 'gst', 'SajJEcoCraft' );
        $settings->account_holder_name = $request->input( 'account_holder_name', 'SajJEcoCraft' );
        $settings->bank_name = $request->input( 'bank_name', 'SajJEcoCraft' );
        $settings->account_number = $request->input( 'account_number', 'SajJEcoCraft' );
        $settings->ifsc_code = $request->input( 'ifsc_code', 'SajJEcoCraft' );
        $settings->bank_address = $request->input( 'bank_address', 'SajJEcoCraft' );
        $settings->account_type = $request->input( 'account_type', 'SajJEcoCraft' );
        $settings->upi_id = $request->input( 'upi_id', 'SajJEcoCraft' );
        $settings->upi_number = $request->input( 'upi_number', 'SajJEcoCraft' );

        // Handle image uploads using ImageUploadHelper
        try {
            if ( $request->hasFile( 'logo_light_image' ) ) {
                $settings->logo_light_image = ImageUploadHelper::upload( $request->file( 'logo_light_image' ), 'site_settings' );
            }

            if ( $request->hasFile( 'logo_dark_image' ) ) {
                $settings->logo_dark_image = ImageUploadHelper::upload( $request->file( 'logo_dark_image' ), 'site_settings' );
            }

            if ( $request->hasFile( 'favicon_image' ) ) {
                $settings->favicon_image = ImageUploadHelper::upload( $request->file( 'favicon_image' ), 'site_settings' );
            }

            if ( $request->hasFile( 'og_image' ) ) {
                $settings->og_image = ImageUploadHelper::upload( $request->file( 'og_image' ), 'site_settings' );
            }

            if ( $request->hasFile( 'twitter_image' ) ) {
                $settings->twitter_image = ImageUploadHelper::upload( $request->file( 'twitter_image' ), 'site_settings' );
            }

            if ( $request->hasFile( 'upi_qr_code_image' ) ) {
                $settings->upi_qr_code_image = ImageUploadHelper::upload( $request->file( 'upi_qr_code_image' ), 'site_settings' );
            }
        } catch ( \Exception $e ) {
            return redirect()->back()->withErrors( [ 'image_upload' => $e->getMessage() ] );
        }

        $settings->save();

        return redirect()->back()->with( 'success', 'Site settings updated successfully.' );
    }
}
