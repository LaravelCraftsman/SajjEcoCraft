 <section class="swiper-container js-swiper-slider slideshow full-width_padding-20 slideshow-md"
     data-settings='{
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": 1,
        "effect": "fade",
        "loop": true,
        "pagination": {
          "el": ".slideshow-pagination",
          "type": "bullets",
          "clickable": true
        }
      }'>
     <div class="swiper-wrapper">
         @foreach ($sliders as $slider)
             <div class="swiper-slide">
                 <div class="overflow-hidden position-relative h-100">
                     <div class="slideshow-bg">
                         <img loading="lazy" src="{{ $slider->image }}" width="1863" height="700" alt=""
                             class="slideshow-bg__img object-fit-cover object-position-right">
                     </div>
                     <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                         <h6
                             class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                             {{ $slider->tag }}</h6>
                         <h2 class="text-uppercase h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">
                             {{ $slider->title }}</h2>
                         <p class="animate animate_fade animate_btt animate_delay-6">
                             {{ $slider->description }}
                         </p>
                         <a href="{{ $slider->cta_url }}" target="_blank"
                             class="btn-link btn-link_sm default-underline text-uppercase fw-medium animate animate_fade animate_btt animate_delay-7">
                             {{ $slider->cta_label }}
                         </a>
                     </div>
                 </div>
             </div>
         @endforeach
     </div><!-- /.slideshow-wrapper js-swiper-slider -->

     <div class="slideshow-pagination position-left-center"></div>
     <!-- /.products-pagination -->
 </section><!-- /.slideshow -->

 <div class="mb-3 pb-1"></div>
