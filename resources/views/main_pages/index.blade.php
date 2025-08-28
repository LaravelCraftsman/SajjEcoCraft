@extends('layouts.frontend')

@section('title', 'Home')


@section('content')
    <main>
        @include('main_pages.home.sliders')


        <section class="products-carousel container">
            <h2 class="section-title text-center fw-normal text-uppercase mb-1 mb-md-3 pb-xl-3">Best Selling Products
            </h2>

            {{-- <ul class="nav nav-tabs mb-3 pb-3 mb-xl-4 text-uppercase justify-content-center" id="collections-tab"
                role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore active" id="collections-tab-1-trigger" data-bs-toggle="tab"
                        href="#collections-tab-1" role="tab" aria-controls="collections-tab-1"
                        aria-selected="true">All</a>
                </li>
                @foreach ($categoriesWithProducts as $category)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="{{ $category->name }}-trigger" data-bs-toggle="tab"
                            href="#{{ $category->name }}" role="tab" aria-controls="{{ $category->name }}"
                            aria-selected="true">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul> --}}

            <div class="tab-content pt-2" id="collections-tab-content">
                <div class="tab-pane fade show active" id="collections-tab-1" role="tabpanel"
                    aria-labelledby="collections-tab-1-trigger">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="{{ route('shop.details', $product->slug) }}">
                                    <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                                        <div class="pc__img-wrapper">
                                            <div class="swiper-container background-img js-swiper-slider"
                                                data-settings='{"resizeObserver": true}'>
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slide">
                                                        <img loading="lazy" src="{{ $product->primary_image }}"
                                                            width="330" height="400" alt="{{ $product->name }}"
                                                            class="pc__img">
                                                    </div>
                                                </div>
                                            </div>
                                            <button
                                                class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-add-cart js-open-aside"
                                                data-aside="cartDrawer" title="Add To Cart">
                                                <svg class="d-inline-block align-middle mx-2" width="14" height="14"
                                                    viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_cart" />
                                                </svg>
                                                <span class="d-inline-block align-middle">Add To Cart</span>
                                            </button>
                                        </div>

                                        <div class="pc__info position-relative">
                                            <p class="pc__category">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                            <h6 class="pc__title mb-2">
                                                <a
                                                    href="{{ route('shop.details', $product->slug) }}">{{ $product->name }}</a>
                                            </h6>
                                            <div class="product-card__price d-flex">
                                                @php
                                                    $originalPrice = $product->purchase_price + $product->profit;
                                                    $finalPrice = $originalPrice - $product->discount;
                                                @endphp

                                                @if ($product->discount > 0)
                                                    <span
                                                        class="money price price-old">₹{{ number_format($originalPrice, 2) }}</span>
                                                    <span
                                                        class="money price price-sale">₹{{ number_format($finalPrice, 2) }}</span>
                                                @else
                                                    <span
                                                        class="money price price-sale">₹{{ number_format($originalPrice, 2) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-2">
                        <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="./shop1.html">See
                            All Products</a>
                    </div>
                </div>
            </div>

        </section><!-- /.products-grid -->

        <div class="mb-5 pb-4"></div>


        @include('main_pages.home.blogs')

    </main>

@endsection
