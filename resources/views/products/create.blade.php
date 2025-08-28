@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header  py-3">
                        <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Create New Product</h5>
                    </div>

                    <div class="card-body p-4">
                        @include('partials.alerts')

                        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data"
                            id="productForm">
                            @csrf

                            <div class="row">
                                <!-- Left Column - Basic Info & Pricing -->
                                <div class="col-lg-8">
                                    <!-- Basic Information -->
                                    <div class="card mb-4">
                                        <div
                                            class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0"><i class="fas fa-info-circle me-1 text-primary"></i> Basic
                                                Information</h6>
                                            <span class="badge bg-danger">Required</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="name" class="form-label">Product Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        id="name" name="name" value="{{ old('name') }}" required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="slug" class="form-label">Slug</label>
                                                    <input type="text"
                                                        class="form-control @error('slug') is-invalid @enderror"
                                                        id="slug" name="slug" value="{{ old('slug') }}">
                                                    <div class="form-text">Leave empty to auto-generate</div>
                                                    @error('slug')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="unique_id" class="form-label">Unique Id</label>
                                                    <input type="text"
                                                        class="form-control @error('unique_id') is-invalid @enderror"
                                                        id="unique_id" name="unique_id" value="{{ old('unique_id') }}"
                                                        required>
                                                    @error('unique_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="size" class="form-label">Size</label>
                                                    <textarea class="form-control @error('size') is-invalid @enderror" id="size" name="size" rows="3">{{ old('size') }}</textarea>

                                                    @error('size')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="mb-3">
                                                <label for="short_description" class="form-label">Short Description</label>
                                                <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                                                    name="short_description" rows="2">{{ old('short_description') }}</textarea>
                                                @error('short_description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                                    rows="4">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pricing & Inventory -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0"><i class="fas fa-tag me-1 text-primary"></i> Pricing &
                                                Inventory</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="vendor_id" class="form-label">Vendor</label>
                                                <select id="vendor_id"
                                                    class="form-select @error('vendor_id') is-invalid @enderror"
                                                    name="vendor_id">
                                                    <option value="">Select Vendor</option>
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}"
                                                            data-parking="{{ $vendor->parking_charges ?? 0 }}"
                                                            data-operational="{{ $vendor->operational_charges ?? 0 }}"
                                                            data-transport="{{ $vendor->transport ?? 0 }}"
                                                            data-deadstock="{{ $vendor->dead_stock ?? 0 }}"
                                                            data-branding="{{ $vendor->branding ?? 0 }}"
                                                            data-damage="{{ $vendor->damage_and_shrinkege ?? 0 }}"
                                                            data-profit="{{ $vendor->profit ?? 0 }}"
                                                            {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                                            {{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('vendor_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Vendor Charges Breakdown (Hidden by default) -->
                                            <div class="row" id="vendor_charges_breakdown" style="display: none;">
                                                <div class="col-12">
                                                    <div class="card bg-light border-0 mt-3">
                                                        <div class="card-header bg-transparent py-2">
                                                            <h6 class="mb-0 text-muted">
                                                                <i class="fas fa-calculator me-1"></i>
                                                                Vendor Charges Breakdown
                                                            </h6>
                                                        </div>
                                                        <div class="card-body py-2">
                                                            <div class="row g-2 text-sm">
                                                                <div class="col-md-2">
                                                                    <small class="text-muted">Parking:</small>
                                                                    <div class="fw-bold" id="parking_display">₹0</div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <small class="text-muted">Operational:</small>
                                                                    <div class="fw-bold" id="operational_display">₹0
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <small class="text-muted">Transport:</small>
                                                                    <div class="fw-bold" id="transport_display">₹0
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <small class="text-muted">Dead Stock:</small>
                                                                    <div class="fw-bold" id="deadstock_display">₹0
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <small class="text-muted">Branding:</small>
                                                                    <div class="fw-bold" id="branding_display">₹0
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <small class="text-muted">Damage:</small>
                                                                    <div class="fw-bold" id="damage_display">₹0</div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <small class="text-muted">Profit:</small>
                                                                    <div class="fw-bold" id="profit_display">₹0</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <small class="text-muted">Total Vendor
                                                                        Charges:</small>
                                                                    <div class="fw-bold text-primary"
                                                                        id="total_vendor_charges_display">₹0</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <br>
                                            <!-- Hidden field to store vendor charges -->
                                            <input type="hidden" id="vendor_charges" name="vendor_charges"
                                                value="0">

                                            <div class="row">
                                                <div class="col-md-4 mb-4">
                                                    <label for="purchase_price" class="form-label">Purchase Price
                                                        (₹) <span class="text-danger">*</span></label>
                                                    <input type="number" step="0.01"
                                                        class="form-control @error('purchase_price') is-invalid @enderror"
                                                        id="purchase_price" name="purchase_price"
                                                        value="{{ old('purchase_price', 0) }}" min="0"
                                                        oninput="calculateFinalPrice()" required>
                                                    @error('purchase_price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-4 mb-4">
                                                    <label for="profit_amount" class="form-label">Profit (₹)</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        id="profit_amount" name="profit_amount" value="0"
                                                        oninput="calculateFinalPrice()">
                                                    <div class="form-text">Additional profit amount</div>
                                                </div>

                                                <div class="col-md-4 mb-4">
                                                    <label for="discount_amount" class="form-label">Discount
                                                        (₹)</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        id="discount_amount" name="discount_amount" value="0"
                                                        oninput="calculateFinalPrice()">
                                                    <div class="form-text">Discount amount</div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 mb-12">
                                                    <label for="selling_price" class="form-label">Final Selling Price
                                                        (₹)
                                                        <span class="text-danger">*</span></label>
                                                    <input type="number" step="0.01"
                                                        class="form-control @error('selling_price') is-invalid @enderror"
                                                        id="selling_price" name="selling_price"
                                                        value="{{ old('selling_price', 0) }}" min="0" readonly
                                                        style="background-color: #e3f2fd; font-weight: bold;" required>
                                                    <div class="form-text">Auto-calculated: Purchase Price +
                                                        Vendor Charges + Profit - Discount</div>
                                                    @error('selling_price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="sku" class="form-label">SKU <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('sku') is-invalid @enderror"
                                                        id="sku" name="sku" value="{{ old('sku') }}"
                                                        required>
                                                    @error('sku')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="stock" class="form-label">Stock Quantity</label>
                                                    <input type="number"
                                                        class="form-control @error('stock') is-invalid @enderror"
                                                        id="stock" name="stock" value="{{ old('stock') }}"
                                                        min="0">
                                                    @error('stock')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Enhanced Media Section -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0"><i class="fas fa-images me-1 text-primary"></i> Media
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Main Image Section -->
                                                <div class="col-md-12 mb-4">
                                                    <label for="main_image" class="form-label">Main Image</label>
                                                    <input class="form-control @error('main_image') is-invalid @enderror"
                                                        type="file" id="main_image" name="main_image"
                                                        accept="image/*">
                                                    <div class="form-text">Featured image for your product</div>
                                                    @error('main_image')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                    <div class="mt-3 border rounded p-2 text-center" id="mainImagePreview"
                                                        style="display: none;">
                                                        <img src="" alt="Preview" class="img-fluid rounded"
                                                            style="max-height: 150px;">
                                                    </div>
                                                </div>

                                                <!-- Enhanced Gallery Images Section -->
                                                <div class="col-md-12">
                                                    <label for="images" class="form-label">Gallery Images</label>

                                                    <!-- File Input -->
                                                    <div class="mb-3">
                                                        <input class="form-control @error('images') is-invalid @enderror"
                                                            type="file" id="images" name="images[]" multiple
                                                            accept="image/*">
                                                        <div class="form-text">Select multiple images (You can drag and
                                                            drop to reorder them below)</div>
                                                        @error('images')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Gallery Preview Container -->
                                                    <div class="gallery-upload-container">
                                                        <!-- Drop Zone -->
                                                        <div class="gallery-drop-zone" id="galleryDropZone">
                                                            <div class="drop-zone-content text-center py-4">
                                                                <i
                                                                    class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                                                <h5 class="text-muted">Drop images here or click to
                                                                    browse
                                                                </h5>
                                                                <p class="text-muted mb-0">Supports: JPG, PNG, GIF,
                                                                    WebP
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Gallery Grid -->
                                                        <div class="gallery-grid" id="galleryGrid"
                                                            style="display: none;">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-3">
                                                                <h6 class="mb-0">Gallery Images <span
                                                                        class="badge bg-primary" id="imageCount">0</span>
                                                                </h6>
                                                                <div class="btn-group btn-group-sm">
                                                                    <button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        id="selectAllImages">
                                                                        <i class="fas fa-check-square"></i> Select All
                                                                    </button>
                                                                    <button type="button" class="btn btn-outline-danger"
                                                                        id="deleteSelectedImages">
                                                                        <i class="fas fa-trash"></i> Delete Selected
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div class="row g-3" id="sortableGallery"></div>

                                                            <div class="mt-3 text-center">
                                                                <button type="button"
                                                                    class="btn btn-outline-primary btn-sm"
                                                                    id="addMoreImages">
                                                                    <i class="fas fa-plus"></i> Add More Images
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Meta & Actions -->
                                <div class="col-lg-4">
                                    <!-- Status & Categories -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0"><i class="fas fa-cog me-1 text-primary"></i> Settings
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status" name="status">
                                                    <option value="inactive"
                                                        {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                                    </option>
                                                    <option value="active"
                                                        {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                                    </option>
                                                    <option value="draft"
                                                        {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select id="category_id"
                                                    class="form-select @error('category_id') is-invalid @enderror"
                                                    name="category_id">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="pinned" class="form-label">Pinned</label>
                                                <select id="pinned"
                                                    class="form-select @error('pinned') is-invalid @enderror"
                                                    name="pinned">
                                                    <option value="0" {{ old('pinned') == '0' ? 'selected' : '' }}>
                                                        Inactive</option>
                                                    <option value="1" {{ old('pinned') == '1' ? 'selected' : '' }}>
                                                        Active</option>
                                                </select>
                                                @error('pinned')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>

                                    <!-- SEO -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0"><i class="fas fa-search me-1 text-primary"></i> SEO
                                                Settings</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="meta_description" class="form-label">Meta
                                                    Description</label>
                                                <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description"
                                                    name="meta_description" rows="2">{{ old('meta_description') }}</textarea>
                                                @error('meta_description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                                <input type="text"
                                                    class="form-control @error('meta_keywords') is-invalid @enderror"
                                                    id="meta_keywords" name="meta_keywords"
                                                    value="{{ old('meta_keywords') }}">
                                                <div class="form-text">Comma-separated keywords</div>
                                                @error('meta_keywords')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Social Media -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0"><i class="fas fa-share-alt me-1 text-primary"></i>
                                                Social
                                                Media</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="nav nav-pills mb-3" id="socialTabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="og-tab" data-bs-toggle="pill"
                                                        data-bs-target="#og" type="button" role="tab">Open
                                                        Graph</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="twitter-tab" data-bs-toggle="pill"
                                                        data-bs-target="#twitter" type="button"
                                                        role="tab">Twitter</button>
                                                </li>
                                            </ul>

                                            <div class="tab-content" id="socialTabsContent">
                                                <div class="tab-pane fade show active" id="og" role="tabpanel">
                                                    <div class="mb-2">
                                                        <label for="og_title" class="form-label">OG Title</label>
                                                        <input type="text"
                                                            class="form-control @error('og_title') is-invalid @enderror"
                                                            id="og_title" name="og_title"
                                                            value="{{ old('og_title') }}">
                                                        @error('og_title')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="og_description" class="form-label">OG
                                                            Description</label>
                                                        <textarea class="form-control @error('og_description') is-invalid @enderror" id="og_description"
                                                            name="og_description" rows="2">{{ old('og_description') }}</textarea>
                                                        @error('og_description')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="og_image" class="form-label">OG Image</label>
                                                        <input
                                                            class="form-control @error('og_image') is-invalid @enderror"
                                                            type="file" id="og_image" name="og_image"
                                                            accept="image/*">
                                                        @error('og_image')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="twitter" role="tabpanel">
                                                    <div class="mb-2">
                                                        <label for="twitter_title" class="form-label">Twitter
                                                            Title</label>
                                                        <input type="text"
                                                            class="form-control @error('twitter_title') is-invalid @enderror"
                                                            id="twitter_title" name="twitter_title"
                                                            value="{{ old('twitter_title') }}">
                                                        @error('twitter_title')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="twitter_description" class="form-label">Twitter
                                                            Description</label>
                                                        <textarea class="form-control @error('twitter_description') is-invalid @enderror" id="twitter_description"
                                                            name="twitter_description" rows="2">{{ old('twitter_description') }}</textarea>
                                                        @error('twitter_description')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="twitter_image" class="form-label">Twitter
                                                            Image</label>
                                                        <input
                                                            class="form-control @error('twitter_image') is-invalid @enderror"
                                                            type="file" id="twitter_image" name="twitter_image"
                                                            accept="image/*">
                                                        @error('twitter_image')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-success btn-lg">
                                                    <i class="fas fa-check-circle me-1"></i> Create Product
                                                </button>
                                                <a href="{{ route('products.index') }}"
                                                    class="btn btn-outline-secondary">
                                                    <i class="fas fa-times me-1"></i> Cancel
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Original Styles */
        .card {
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            background: linear-gradient(to right, #f8f9fa, #fff);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .nav-pills .nav-link {
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 0.85rem;
            color: #495057;
        }

        .nav-pills .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }

        #mainImagePreview img,
        #galleryPreviews img {
            transition: transform 0.3s ease;
        }

        #mainImagePreview img:hover,
        #galleryPreviews img:hover {
            transform: scale(1.05);
        }

        .btn {
            border-radius: 6px;
            font-weight: 500;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        /* Enhanced Gallery Styles */
        .gallery-upload-container {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            min-height: 200px;
            transition: all 0.3s ease;
            background: #fafbfc;
            position: relative;
        }

        .gallery-upload-container.dragover {
            border-color: #198754;
            background-color: rgba(25, 135, 84, 0.05);
            border-style: solid;
        }

        .gallery-drop-zone {
            padding: 2rem;
            cursor: pointer;
            display: block !important;
            min-height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .drop-zone-content {
            text-align: center;
            pointer-events: none;
        }

        .drop-zone-content i {
            color: #6c757d;
        }

        .drop-zone-content h5 {
            color: #6c757d;
            font-weight: 500;
        }

        .drop-zone-content p {
            color: #adb5bd;
            font-size: 0.9rem;
        }

        .gallery-grid {
            padding: 1rem;
        }

        .gallery-item {
            position: relative;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: move;
            background: white;
        }

        .gallery-item:hover {
            border-color: #0d6efd;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .gallery-item.selected {
            border-color: #198754;
            box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.2);
        }

        .gallery-item.sortable-chosen {
            opacity: 0.8;
            transform: rotate(2deg) scale(1.05);
            z-index: 1000;
        }

        .gallery-item.sortable-ghost {
            opacity: 0.3;
        }

        .gallery-item-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .gallery-item-image {
            transform: scale(1.05);
        }

        .gallery-item-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover .gallery-item-overlay {
            opacity: 1;
        }

        .gallery-item-controls {
            position: absolute;
            top: 5px;
            right: 5px;
            display: flex;
            gap: 5px;
        }

        .gallery-item-controls .btn {
            width: 30px;
            height: 30px;
            padding: 0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-item-order {
            position: absolute;
            top: 5px;
            left: 5px;
            background: rgba(13, 110, 253, 0.9);
            color: white;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        .gallery-item-select {
            position: absolute;
            bottom: 5px;
            left: 5px;
        }

        .gallery-item-select input[type="checkbox"] {
            transform: scale(1.2);
        }

        .drag-handle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 1.5rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover .drag-handle {
            opacity: 1;
        }

        /* File input styling */
        .form-control[type="file"]::-webkit-file-upload-button {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            margin-right: 1rem;
            cursor: pointer;
        }

        /* Price calculation styling */
        .price-calculation-row {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }

        .vendor-charges-breakdown {
            font-size: 0.85rem;
        }

        .vendor-charges-breakdown .fw-bold {
            color: #495057;
        }
    </style>
@endpush

@section('scripts')

    <script>
        const timestamp = Date.now(); // e.g., 1693456789012
        const lastSixDigits = String(timestamp).slice(-6); // Get last 6 digits as a string
        document.getElementById('sku').value = 'SEC' + lastSixDigits;
        const timestamp2 = Date.now(); // e.g., 1693456789012
        const lastSixDigits2 = String(timestamp2).slice(-6); // Get last 6 digits as a string
        document.getElementById('unique_id').value = lastSixDigits2;
    </script>

    <script>
        function parseMoney(value) {
            const n = parseFloat(value);
            return isNaN(n) ? 0 : n;
        }

        function calculateFinalPrice() {
            const purchasePrice = parseMoney(document.getElementById('purchase_price').value);
            const profitAmount = parseMoney(document.getElementById('profit_amount').value);
            const discountAmount = parseMoney(document.getElementById('discount_amount').value);

            const finalPrice = purchasePrice + profitAmount - discountAmount;
            document.getElementById('selling_price').value = finalPrice >= 0 ? finalPrice.toFixed(2) : '0.00';
        }

        // Attach 'input' event listeners to trigger calculation on each input change
        ['purchase_price', 'profit_amount', 'discount_amount'].forEach(id => {
            document.getElementById(id).addEventListener('input', calculateFinalPrice);
        });

        // Optionally, calculate initial value on page load
        calculateFinalPrice();
    </script>

    <script>
        document.getElementById('vendor_id').addEventListener('change', function() {
            const vendorId = this.value;

            fetch(`/api/vendor-prices/${vendorId}`)
                .then(response => response.json())
                .then(res => {
                    if (res.success && res.data) {
                        const data = res.data;

                        // Populate fields
                        document.getElementById('parking_display').innerText = `₹${data.parking_charges}`;
                        document.getElementById('operational_display').innerText =
                            `₹${data.operational_charges}`;
                        document.getElementById('transport_display').innerText = `₹${data.transport}`;
                        document.getElementById('deadstock_display').innerText = `₹${data.dead_stock}`;
                        document.getElementById('branding_display').innerText = `₹${data.branding}`;
                        document.getElementById('damage_display').innerText = `₹${data.damage_and_shrinkege}`;
                        document.getElementById('profit_display').innerText = `₹${data.profit}`;
                        document.getElementById('total_vendor_charges_display').innerText =
                            `₹${data.total_charges}`;
                        document.getElementById('purchase_price').value = data.total_charges;

                        const profitAmount = parseMoney(document.getElementById('profit_amount').value);
                        const discountAmount = parseMoney(document.getElementById('discount_amount').value);
                        const vendorCharges = parseMoney(data.total_charges);

                        const finalPrice = vendorCharges + profitAmount - discountAmount;

                        // Ensure non-negative and format to 2 decimal places
                        document.getElementById('selling_price').value = finalPrice >= 0 ? finalPrice.toFixed(
                            2) : '0.00';

                        // Show the breakdown section
                        document.getElementById('vendor_charges_breakdown').style.display = 'block';
                    } else {
                        // Hide the breakdown section
                        document.getElementById('vendor_charges_breakdown').style.display = 'none';

                        // Show error alert
                        alert('Unable to fetch vendor charges. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('API Error:', error);

                    // Hide the breakdown section
                    document.getElementById('vendor_charges_breakdown').style.display = 'none';

                    // Show error alert
                    alert('An error occurred while fetching vendor data.');
                });
        });
    </script>



@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let galleryImages = [];
            let imageCounter = 0;

            const galleryDropZone = document.getElementById('galleryDropZone');
            const galleryGrid = document.getElementById('galleryGrid');
            const sortableGallery = document.getElementById('sortableGallery');
            const imageCount = document.getElementById('imageCount');
            const imagesInput = document.getElementById('images');
            const addMoreImagesBtn = document.getElementById('addMoreImages');
            const selectAllBtn = document.getElementById('selectAllImages');
            const deleteSelectedBtn = document.getElementById('deleteSelectedImages');

            // Initialize Sortable
            const sortable = new Sortable(sortableGallery, {
                animation: 200,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                onEnd: function(evt) {
                    updateImageOrder();
                }
            });

            // Initialize - Show drop zone by default
            updateDisplay();

            // Handle file input change
            imagesInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    handleFiles(e.target.files);
                }
            });

            // Handle drop zone click
            galleryDropZone.addEventListener('click', function(e) {
                e.preventDefault();
                imagesInput.click();
            });

            // Handle drag and drop on the entire container
            const galleryContainer = document.querySelector('.gallery-upload-container');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                galleryContainer.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                galleryContainer.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                galleryContainer.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                galleryContainer.classList.add('dragover');
            }

            function unhighlight(e) {
                galleryContainer.classList.remove('dragover');
            }

            galleryContainer.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const files = e.dataTransfer.files;
                handleFiles(files);
            }

            // Handle files
            function handleFiles(files) {
                const fileArray = Array.from(files).filter(file => file.type.startsWith('image/'));

                fileArray.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        addImageToGallery(e.target.result, file);
                    };
                    reader.readAsDataURL(file);
                });

                updateFileInput();
            }

            // Add image to gallery
            function addImageToGallery(src, file) {
                const imageId = 'gallery-img-' + (++imageCounter);
                galleryImages.push({
                    id: imageId,
                    src: src,
                    file: file
                });

                const col = document.createElement('div');
                col.className = 'col-lg-3 col-md-4 col-sm-6';
                col.innerHTML = `
                    <div class="gallery-item" data-image-id="${imageId}">
                        <img src="${src}" alt="Gallery Image" class="gallery-item-image">
                        <div class="gallery-item-order">${galleryImages.length}</div>
                        <div class="gallery-item-controls">
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeImage('${imageId}')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="gallery-item-select">
                            <input type="checkbox" class="form-check-input image-select" data-image-id="${imageId}">
                        </div>
                        <div class="gallery-item-overlay">
                            <div class="drag-handle">
                                <i class="fas fa-arrows-alt"></i>
                            </div>
                        </div>
                    </div>
                `;

                sortableGallery.appendChild(col);
                updateDisplay();
            }

            // Remove image
            window.removeImage = function(imageId) {
                galleryImages = galleryImages.filter(img => img.id !== imageId);
                const item = document.querySelector(`[data-image-id="${imageId}"]`).closest('.col-lg-3');
                item.remove();
                updateDisplay();
                updateFileInput();
                updateImageOrder();
            };

            // Update display
            function updateDisplay() {
                imageCount.textContent = galleryImages.length;

                if (galleryImages.length > 0) {
                    galleryDropZone.style.display = 'none';
                    galleryGrid.style.display = 'block';
                } else {
                    galleryDropZone.style.display = 'flex';
                    galleryGrid.style.display = 'none';
                }
            }

            // Update image order
            function updateImageOrder() {
                const items = sortableGallery.querySelectorAll('.gallery-item');
                const newOrder = [];

                items.forEach((item, index) => {
                    const imageId = item.getAttribute('data-image-id');
                    const orderElement = item.querySelector('.gallery-item-order');
                    orderElement.textContent = index + 1;

                    const imageData = galleryImages.find(img => img.id === imageId);
                    if (imageData) {
                        newOrder.push(imageData);
                    }
                });

                galleryImages = newOrder;
                updateFileInput();
            }

            // Update file input with current images
            function updateFileInput() {
                const dt = new DataTransfer();
                galleryImages.forEach(img => {
                    if (img.file) {
                        dt.items.add(img.file);
                    }
                });
                imagesInput.files = dt.files;
            }

            // Add more images button
            addMoreImagesBtn.addEventListener('click', function() {
                imagesInput.click();
            });

            // Select all images
            selectAllBtn.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.image-select');
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);

                checkboxes.forEach(cb => {
                    cb.checked = !allChecked;
                    const galleryItem = cb.closest('.gallery-item');
                    if (cb.checked) {
                        galleryItem.classList.add('selected');
                    } else {
                        galleryItem.classList.remove('selected');
                    }
                });

                selectAllBtn.innerHTML = allChecked ?
                    '<i class="fas fa-check-square"></i> Select All' :
                    '<i class="fas fa-square"></i> Deselect All';
            });

            // Delete selected images
            deleteSelectedBtn.addEventListener('click', function() {
                const selectedCheckboxes = document.querySelectorAll('.image-select:checked');

                if (selectedCheckboxes.length === 0) {
                    alert('Please select images to delete.');
                    return;
                }

                if (confirm(
                        `Are you sure you want to delete ${selectedCheckboxes.length} selected image(s)?`
                    )) {
                    selectedCheckboxes.forEach(checkbox => {
                        const imageId = checkbox.getAttribute('data-image-id');
                        removeImage(imageId);
                    });
                }
            });

            // Handle checkbox changes
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('image-select')) {
                    const galleryItem = e.target.closest('.gallery-item');
                    if (e.target.checked) {
                        galleryItem.classList.add('selected');
                    } else {
                        galleryItem.classList.remove('selected');
                    }
                }
            });

            // Main image preview
            document.getElementById('main_image').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('mainImagePreview');
                        preview.style.display = 'block';
                        preview.querySelector('img').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Auto-generate slug from name
            document.getElementById('name').addEventListener('blur', function() {
                if (document.getElementById('slug').value === '') {
                    const name = this.value;
                    const slug = name.toLowerCase()
                        .trim()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/[\s_-]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                    document.getElementById('slug').value = slug;
                }
            });
        });
    </script>
@endpush
