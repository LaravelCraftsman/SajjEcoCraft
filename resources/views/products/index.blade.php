@extends('layouts.app')

@section('title', 'Products')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Products') }}</span>
                        <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">Add New Product</a>
                    </div>

                    <div class="card-body">
                        @include('partials.alerts')

                        @if ($products->count())
                            <table class="table table-bordered table-striped">
                                <colgroup>
                                    <col style="width: 5%;"> <!-- Sr. No -->
                                    <col style="width: 10%;"> <!-- Image -->
                                    <col style="width: 15%;"> <!-- Name -->
                                    <col style="width: 10%;"> <!-- SKU -->
                                    <col style="width: 10%;"> <!-- Category -->
                                    <col style="width: 10%;"> <!-- Vendor -->
                                    <col style="width: 10%;"> <!-- Status -->
                                    <col style="width: 10%;"> <!-- Stock -->
                                    <col style="width: 10%;"> <!-- Selling Price -->
                                    <col style="width: 10%;"> <!-- Actions -->
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>SKU</th>
                                        <th>Category</th>
                                        <th>Vendor</th>
                                        <th>Status</th>
                                        <th>Stock</th>
                                        <th>Selling Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}
                                            </td>
                                            <td>
                                                @if ($product->primary_image)
                                                    <a href="{{ $product->primary_image }}" target="_blank"> <img
                                                            src="{{ $product->primary_image }}" alt="{{ $product->name }}"
                                                            width="auto" height="50" style="object-fit: cover;" /></a>
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ $product->category ? $product->category->name : '-' }}</td>
                                            <td>{{ $product->vendor ? $product->vendor->name : '-' }}</td>
                                            <td>{{ ucfirst($product->status) }}</td>
                                            <td>{{ $product->stock ?? '-' }}</td>
                                            <td>{{ number_format($product->selling_price, 2) }}</td>
                                            <td>
                                                <x-table-actions route="products" :id="$product->id" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $products->links() }}
                        @else
                            <p>No products found.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
