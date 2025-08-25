@extends('layouts.app')

@section('title', 'Site Settings')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Site Settings</div>

                    <div class="card-body">
                        @include('partials.alerts')

                        <form action="{{ route('site_settings.update', 1) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Basic Site Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-dark border-bottom pb-2">Basic Site Information</h5>
                                </div>

                                <!-- Title -->
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title" id="title"
                                        value="{{ old('title', $site_settings->title) }}"
                                        class="form-control @error('title') is-invalid @enderror">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tagline -->
                                <div class="col-md-6 mb-3">
                                    <label for="tag_line" class="form-label">Tagline</label>
                                    <input type="text" name="tag_line" id="tag_line"
                                        value="{{ old('tag_line', $site_settings->tag_line) }}"
                                        class="form-control @error('tag_line') is-invalid @enderror">
                                    @error('tag_line')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                        rows="4">{{ old('description', $site_settings->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Logo and Images -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-dark border-bottom pb-2">Logo and Images</h5>
                                </div>

                                <!-- Light Logo -->
                                <div class="col-md-6 mb-3">
                                    <label for="logo_light_image" class="form-label">Light Logo</label>
                                    <input type="file" name="logo_light_image" id="logo_light_image"
                                        class="form-control @error('logo_light_image') is-invalid @enderror">
                                    @error('logo_light_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($site_settings->logo_light_image)
                                        <div class="mt-2">
                                            <a href="{{ $site_settings->logo_light_image }}" target="_blank">
                                                <img style="background-color: #d2d2d2;padding:10px;border:1px solid black"
                                                    src="{{ $site_settings->logo_light_image }}" alt="Light Logo"
                                                    width="150">
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Dark Logo -->
                                <div class="col-md-6 mb-3">
                                    <label for="logo_dark_image" class="form-label">Dark Logo</label>
                                    <input type="file" name="logo_dark_image" id="logo_dark_image"
                                        class="form-control @error('logo_dark_image') is-invalid @enderror">
                                    @error('logo_dark_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($site_settings->logo_dark_image)
                                        <div class="mt-2">
                                            <a href="{{ $site_settings->logo_dark_image }}" target="_blank">
                                                <img style="background-color: #d2d2d2;padding:10px;border:1px solid black"
                                                    src="{{ $site_settings->logo_dark_image }}" alt="Dark Logo"
                                                    width="150">
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Favicon -->
                                <div class="col-md-6 mb-3">
                                    <label for="favicon_image" class="form-label">Favicon</label>
                                    <input type="file" name="favicon_image" id="favicon_image"
                                        class="form-control @error('favicon_image') is-invalid @enderror">
                                    @error('favicon_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($site_settings->favicon_image)
                                        <div class="mt-2">
                                            <a href="{{ $site_settings->favicon_image }}" target="_blank">
                                                <img style="background-color: #d2d2d2;padding:10px;border:1px solid black"
                                                    src="{{ $site_settings->favicon_image }}" alt="Favicon"
                                                    width="50">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-dark border-bottom pb-2">Contact Information</h5>
                                </div>

                                <!-- Phone Number -->
                                <div class="col-md-6 mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number" id="phone_number"
                                        value="{{ old('phone_number', $site_settings->phone_number) }}"
                                        class="form-control @error('phone_number') is-invalid @enderror">
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email Address -->
                                <div class="col-md-6 mb-3">
                                    <label for="email_address" class="form-label">Email Address</label>
                                    <input type="email" name="email_address" id="email_address"
                                        value="{{ old('email_address', $site_settings->email_address) }}"
                                        class="form-control @error('email_address') is-invalid @enderror">
                                    @error('email_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="col-md-12 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="4">{{ old('address', $site_settings->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Location Details -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2">Location Details</h5>
                                </div>

                                <!-- Latitude -->
                                <div class="col-md-4 mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" name="latitude" id="latitude"
                                        value="{{ old('latitude', $site_settings->latitude) }}"
                                        class="form-control @error('latitude') is-invalid @enderror">
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Longitude -->
                                <div class="col-md-4 mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" name="longitude" id="longitude"
                                        value="{{ old('longitude', $site_settings->longitude) }}"
                                        class="form-control @error('longitude') is-invalid @enderror">
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Map Link -->
                                <div class="col-md-4 mb-3">
                                    <label for="map_link" class="form-label">Map Link</label>
                                    <input type="text" name="map_link" id="map_link"
                                        value="{{ old('map_link', $site_settings->map_link) }}"
                                        class="form-control @error('map_link') is-invalid @enderror">
                                    @error('map_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Social Links -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-dark border-bottom pb-2">Social Media Links</h5>
                                </div>

                                <!-- Facebook -->
                                <div class="col-md-6 mb-3">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="text" name="facebook" id="facebook"
                                        value="{{ old('facebook', $site_settings->facebook) }}"
                                        class="form-control @error('facebook') is-invalid @enderror">
                                    @error('facebook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- YouTube -->
                                <div class="col-md-6 mb-3">
                                    <label for="youtube" class="form-label">YouTube</label>
                                    <input type="text" name="youtube" id="youtube"
                                        value="{{ old('youtube', $site_settings->youtube) }}"
                                        class="form-control @error('youtube') is-invalid @enderror">
                                    @error('youtube')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- LinkedIn -->
                                <div class="col-md-6 mb-3">
                                    <label for="linkedin" class="form-label">LinkedIn</label>
                                    <input type="text" name="linkedin" id="linkedin"
                                        value="{{ old('linkedin', $site_settings->linkedin) }}"
                                        class="form-control @error('linkedin') is-invalid @enderror">
                                    @error('linkedin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Instagram -->
                                <div class="col-md-6 mb-3">
                                    <label for="instagram" class="form-label">Instagram</label>
                                    <input type="text" name="instagram" id="instagram"
                                        value="{{ old('instagram', $site_settings->instagram) }}"
                                        class="form-control @error('instagram') is-invalid @enderror">
                                    @error('instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- SEO Meta Tags -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-dark border-bottom pb-2">SEO Meta Tags</h5>
                                </div>

                                <!-- Meta Description -->
                                <div class="col-md-6 mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <input type="text" name="meta_description" id="meta_description"
                                        value="{{ old('meta_description', $site_settings->meta_description) }}"
                                        class="form-control @error('meta_description') is-invalid @enderror">
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Meta Keywords -->
                                <div class="col-md-6 mb-3">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <input type="text" name="meta_keywords" id="meta_keywords"
                                        value="{{ old('meta_keywords', $site_settings->meta_keywords) }}"
                                        class="form-control @error('meta_keywords') is-invalid @enderror">
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Meta Author -->
                                <div class="col-md-6 mb-3">
                                    <label for="meta_author" class="form-label">Meta Author</label>
                                    <input type="text" name="meta_author" id="meta_author"
                                        value="{{ old('meta_author', $site_settings->meta_author) }}"
                                        class="form-control @error('meta_author') is-invalid @enderror">
                                    @error('meta_author')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Canonical URL -->
                                <div class="col-md-6 mb-3">
                                    <label for="canonical_url" class="form-label">Canonical URL</label>
                                    <input type="text" name="canonical_url" id="canonical_url"
                                        value="{{ old('canonical_url', $site_settings->canonical_url) }}"
                                        class="form-control @error('canonical_url') is-invalid @enderror">
                                    @error('canonical_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Open Graph Tags -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-dark border-bottom pb-2">Open Graph Tags</h5>
                                </div>

                                <!-- OG Title -->
                                <div class="col-md-6 mb-3">
                                    <label for="og_title" class="form-label">OG Title</label>
                                    <input type="text" name="og_title" id="og_title"
                                        value="{{ old('og_title', $site_settings->og_title) }}"
                                        class="form-control @error('og_title') is-invalid @enderror">
                                    @error('og_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- OG Description -->
                                <div class="col-md-6 mb-3">
                                    <label for="og_description" class="form-label">OG Description</label>
                                    <input type="text" name="og_description" id="og_description"
                                        value="{{ old('og_description', $site_settings->og_description) }}"
                                        class="form-control @error('og_description') is-invalid @enderror">
                                    @error('og_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- OG Image -->
                                <div class="col-md-6 mb-3">
                                    <label for="og_image" class="form-label">OG Image</label>
                                    <input type="file" name="og_image" id="og_image"
                                        class="form-control @error('og_image') is-invalid @enderror">
                                    @error('og_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($site_settings->og_image)
                                        <div class="mt-2">
                                            <a href="{{ $site_settings->og_image }}" target="_blank">
                                                <img style="background-color: #d2d2d2;padding:10px;border:1px solid black"
                                                    src="{{ $site_settings->og_image }}" alt="OG Image" width="150">
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- OG URL -->
                                <div class="col-md-6 mb-3">
                                    <label for="og_url" class="form-label">OG URL</label>
                                    <input type="text" name="og_url" id="og_url"
                                        value="{{ old('og_url', $site_settings->og_url) }}"
                                        class="form-control @error('og_url') is-invalid @enderror">
                                    @error('og_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- OG Type -->
                                <div class="col-md-6 mb-3">
                                    <label for="og_type" class="form-label">OG Type</label>
                                    <input type="text" name="og_type" id="og_type"
                                        value="{{ old('og_type', $site_settings->og_type) }}"
                                        class="form-control @error('og_type') is-invalid @enderror">
                                    @error('og_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- OG Site Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="og_site_name" class="form-label">OG Site Name</label>
                                    <input type="text" name="og_site_name" id="og_site_name"
                                        value="{{ old('og_site_name', $site_settings->og_site_name) }}"
                                        class="form-control @error('og_site_name') is-invalid @enderror">
                                    @error('og_site_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Twitter Tags -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-dark border-bottom pb-2">Twitter Tags</h5>
                                </div>

                                <!-- Twitter Card -->
                                <div class="col-md-6 mb-3">
                                    <label for="twitter_card" class="form-label">Twitter Card</label>
                                    <input type="text" name="twitter_card" id="twitter_card"
                                        value="{{ old('twitter_card', $site_settings->twitter_card) }}"
                                        class="form-control @error('twitter_card') is-invalid @enderror">
                                    @error('twitter_card')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Twitter Title -->
                                <div class="col-md-6 mb-3">
                                    <label for="twitter_title" class="form-label">Twitter Title</label>
                                    <input type="text" name="twitter_title" id="twitter_title"
                                        value="{{ old('twitter_title', $site_settings->twitter_title) }}"
                                        class="form-control @error('twitter_title') is-invalid @enderror">
                                    @error('twitter_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Twitter Description -->
                                <div class="col-md-6 mb-3">
                                    <label for="twitter_description" class="form-label">Twitter Description</label>
                                    <input type="text" name="twitter_description" id="twitter_description"
                                        value="{{ old('twitter_description', $site_settings->twitter_description) }}"
                                        class="form-control @error('twitter_description') is-invalid @enderror">
                                    @error('twitter_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Twitter Image -->
                                <div class="col-md-6 mb-3">
                                    <label for="twitter_image" class="form-label">Twitter Image</label>
                                    <input type="file" name="twitter_image" id="twitter_image"
                                        class="form-control @error('twitter_image') is-invalid @enderror">
                                    @error('twitter_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($site_settings->twitter_image)
                                        <div class="mt-2">
                                            <a href="{{ $site_settings->twitter_image }}" target="_blank">
                                                <img style="background-color: #d2d2d2;padding:10px;border:1px solid black"
                                                    src="{{ $site_settings->twitter_image }}" alt="Twitter Image"
                                                    width="150">
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Twitter URL -->
                                <div class="col-md-6 mb-3">
                                    <label for="twitter_url" class="form-label">Twitter URL</label>
                                    <input type="text" name="twitter_url" id="twitter_url"
                                        value="{{ old('twitter_url', $site_settings->twitter_url) }}"
                                        class="form-control @error('twitter_url') is-invalid @enderror">
                                    @error('twitter_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Twitter Site -->
                                <div class="col-md-6 mb-3">
                                    <label for="twitter_site" class="form-label">Twitter Site</label>
                                    <input type="text" name="twitter_site" id="twitter_site"
                                        value="{{ old('twitter_site', $site_settings->twitter_site) }}"
                                        class="form-control @error('twitter_site') is-invalid @enderror">
                                    @error('twitter_site')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Twitter Creator -->
                                <div class="col-md-6 mb-3">
                                    <label for="twitter_creator" class="form-label">Twitter Creator</label>
                                    <input type="text" name="twitter_creator" id="twitter_creator"
                                        value="{{ old('twitter_creator', $site_settings->twitter_creator) }}"
                                        class="form-control @error('twitter_creator') is-invalid @enderror">
                                    @error('twitter_creator')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bank Details -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-dark border-bottom pb-2">Bank Details</h5>
                                </div>

                                <!-- GST -->
                                <div class="col-md-6 mb-3">
                                    <label for="gst" class="form-label">GST Number</label>
                                    <input type="text" name="gst" id="gst"
                                        value="{{ old('gst', $site_settings->gst) }}"
                                        class="form-control @error('gst') is-invalid @enderror">
                                    @error('gst')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Account Holder Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="account_holder_name" class="form-label">Account Holder Name</label>
                                    <input type="text" name="account_holder_name" id="account_holder_name"
                                        value="{{ old('account_holder_name', $site_settings->account_holder_name) }}"
                                        class="form-control @error('account_holder_name') is-invalid @enderror">
                                    @error('account_holder_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Bank Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="bank_name" class="form-label">Bank Name</label>
                                    <input type="text" name="bank_name" id="bank_name"
                                        value="{{ old('bank_name', $site_settings->bank_name) }}"
                                        class="form-control @error('bank_name') is-invalid @enderror">
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Account Number -->
                                <div class="col-md-6 mb-3">
                                    <label for="account_number" class="form-label">Account Number</label>
                                    <input type="text" name="account_number" id="account_number"
                                        value="{{ old('account_number', $site_settings->account_number) }}"
                                        class="form-control @error('account_number') is-invalid @enderror">
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- IFSC Code -->
                                <div class="col-md-6 mb-3">
                                    <label for="ifsc_code" class="form-label">IFSC Code</label>
                                    <input type="text" name="ifsc_code" id="ifsc_code"
                                        value="{{ old('ifsc_code', $site_settings->ifsc_code) }}"
                                        class="form-control @error('ifsc_code') is-invalid @enderror">
                                    @error('ifsc_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Account Type -->
                                <div class="col-md-6 mb-3">
                                    <label for="account_type" class="form-label">Account Type</label>
                                    <input type="text" name="account_type" id="account_type"
                                        value="{{ old('account_type', $site_settings->account_type) }}"
                                        class="form-control @error('account_type') is-invalid @enderror">
                                    @error('account_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Bank Address -->
                                <div class="col-md-12 mb-3">
                                    <label for="bank_address" class="form-label">Bank Address</label>
                                    <textarea name="bank_address" id="bank_address" class="form-control @error('bank_address') is-invalid @enderror"
                                        rows="3">{{ old('bank_address', $site_settings->bank_address) }}</textarea>
                                    @error('bank_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- UPI ID -->
                                <div class="col-md-6 mb-3">
                                    <label for="upi_id" class="form-label">UPI ID</label>
                                    <input type="text" name="upi_id" id="upi_id"
                                        value="{{ old('upi_id', $site_settings->upi_id) }}"
                                        class="form-control @error('upi_id') is-invalid @enderror">
                                    @error('upi_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- UPI Number -->
                                <div class="col-md-6 mb-3">
                                    <label for="upi_number" class="form-label">UPI Number</label>
                                    <input type="text" name="upi_number" id="upi_number"
                                        value="{{ old('upi_number', $site_settings->upi_number) }}"
                                        class="form-control @error('upi_number') is-invalid @enderror">
                                    @error('upi_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- UPI QR Code -->
                                <div class="col-md-12 mb-3">
                                    <label for="upi_qr_code_image" class="form-label">UPI QR Code Image</label>
                                    <input type="file" name="upi_qr_code_image" id="upi_qr_code_image"
                                        class="form-control @error('upi_qr_code_image') is-invalid @enderror">
                                    @error('upi_qr_code_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($site_settings->upi_qr_code_image)
                                        <div class="mt-2">
                                            <a href="{{ $site_settings->upi_qr_code_image }}" target="_blank">
                                                <img style="background-color: #d2d2d2;padding:10px;border:1px solid black"
                                                    src="{{ $site_settings->upi_qr_code_image }}" alt="UPI QR Code"
                                                    width="150">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-md-12 text-center mt-4">
                                    <button type="submit" class="btn btn-success" style="width:100%;">Save
                                        Settings</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
