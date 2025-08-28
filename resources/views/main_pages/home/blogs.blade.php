<div class="pt-1 pb-5 mt-4 mt-xl-5"></div>

<section class="blog-carousel container">
    <h2 class="section-title fw-normal text-center text-uppercase mb-3 pb-xl-3 mb-xl-3">Our Blogs</h2>

    <div class="position-relative">
        <div class="swiper-container js-swiper-slider"
            data-settings='{
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": 3,
            "slidesPerGroup": 3,
            "effect": "none",
            "loop": true,
            "breakpoints": {
              "320": {
                "slidesPerView": 1,
                "slidesPerGroup": 1,
                "spaceBetween": 14
              },
              "768": {
                "slidesPerView": 2,
                "slidesPerGroup": 2,
                "spaceBetween": 24
              },
              "992": {
                "slidesPerView": 3,
                "slidesPerGroup": 1,
                "spaceBetween": 30
              }
            }
          }'>
            <div class="swiper-wrapper blog-grid row-cols-xl-3">
                @foreach ($blogs as $blog)
                    <div class="swiper-slide blog-grid__item mb-4 position-relative">
                        <a href="{{ route('blog.details', $blog->slug) }}" class="stretched-link"></a>
                        <div class="blog-grid__item-image">
                            <img loading="lazy" class="h-auto" src="{{ url($blog->main_image) }}" width="450"
                                height="300" alt="{{ $blog->title }}">
                        </div>
                        <div class="blog-grid__item-detail">
                            <div class="blog-grid__item-title mb-0">
                                {{ $blog->title }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-2">
                <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="#"><u>See
                        All Blogs</u></a>
            </div>
        </div><!-- /.swiper-container js-swiper-slider -->
    </div><!-- /.position-relative -->
</section>

<div class="mb-5 pb-4 pb-xl-5 mb-xl-5"></div>
