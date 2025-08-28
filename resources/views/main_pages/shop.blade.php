@extends('layouts.frontend')

@section('title', 'Shop')

@section('content')

    <main>
        <section class="full-width_padding">
            <div class="full-width_border border-2" style="border-color: #eeeeee;">
                <div class="shop-banner position-relative ">
                    <div class="background-img" style="background-color: #eeeeee;">
                        <img loading="lazy" src="{{ $banner->image }}" width="1759" height="420" alt="Pattern"
                            class="slideshow-bg__img object-fit-cover">
                    </div>

                    <div class="shop-banner__content container position-absolute start-50 top-50 translate-middle">
                        <h2 class="h1 text-uppercase fw-bold">Shop</h2>

                        <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                            <a href="{{ url('/') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                            <a href="{{ route('shop') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">The
                                Shop</a>
                        </div>
                    </div>
                </div><!-- /.shop-banner position-relative -->
            </div><!-- /.full-width_border -->
        </section><!-- /.full-width_padding-->

        <div class="mb-4 pb-lg-3"></div>

        <section class="shop-main container">

            <div class="products-grid row row-cols-2 row-cols-md-3 row-cols-lg-4" id="products-grid">
                @foreach ($products as $product)
                    <div class="product-card-wrapper">
                        <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                            <div class="pc__img-wrapper">
                                <div class="swiper-container background-img js-swiper-slider"
                                    data-settings='{"resizeObserver": true}'>
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <a href="{{ route('shop.details', $product->slug) }}"><img loading="lazy"
                                                    src="{{ $product->primary_image }}" width="330" height="400"
                                                    alt="Cropped Faux leather Jacket" class="pc__img"></a>
                                        </div><!-- /.pc__img-wrapper -->
                                    </div>
                                </div>
                                <button
                                    class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-add-cart js-open-aside"
                                    data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                            </div>

                            <div class="pc__info position-relative">
                                <p class="pc__category">{{ $product->category->name ?? '' }}</p>
                                <h6 class="pc__title mb-2"><a
                                        href="{{ route('shop.details', $product->slug) }}">{{ $product->name }}</a>
                                </h6>
                                <div class="product-card__price d-flex">
                                    @php
                                        $originalPrice = $product->purchase_price + $product->profit;
                                        $finalPrice = $originalPrice - $product->discount;
                                    @endphp

                                    @if ($product->discount > 0)
                                        <span class="money price price-old">₹
                                            {{ number_format($originalPrice, 2) }}</span>
                                        <span class="money price price-sale">₹
                                            {{ number_format($finalPrice, 2) }}</span>
                                    @else
                                        <span class="money price price-sale">₹
                                            {{ number_format($originalPrice, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div><!-- /.products-grid row -->

            {{ $products->links('partials.custom_pagination') }}

        </section><!-- /.shop-main container -->
    </main>
@endsection
