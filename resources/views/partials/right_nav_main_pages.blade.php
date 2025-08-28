<div class="header-tools d-flex align-items-center">
    <div class="header-tools__item hover-container d-block d-xxl-none">
        <div class="js-hover__open position-relative">
            <a class="js-search-popup search-field__actor" href="#">
                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_search" />
                </svg>
                <i class="btn-icon btn-close-lg"></i>
            </a>
        </div>

        <div class="search-popup js-hidden-content">
            <form action="./search_result.html" method="GET" class="search-field container">
                <p class="text-uppercase text-secondary fw-medium mb-4">What are you looking for?</p>
                <div class="position-relative">
                    <input class="search-field__input search-popup__input w-100 fw-medium" type="text"
                        name="search-keyword" placeholder="Search products">
                    <button class="btn-icon search-popup__submit" type="submit">
                        <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_search" />
                        </svg>
                    </button>
                    <button class="btn-icon btn-close-lg search-popup__reset" type="reset"></button>
                </div>

                <div class="search-popup__results">
                    <div class="sub-menu search-suggestion">
                        <h6 class="sub-menu__title fs-base">Quicklinks</h6>
                        <ul class="sub-menu__list list-unstyled">
                            @foreach ($categoriesWithProducts as $category)
                                <li class="sub-menu__item"><a href="./shop2.html"
                                        class="menu-link menu-link_us-s">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="search-result row row-cols-5"></div>
                </div>
            </form><!-- /.header-search -->
        </div><!-- /.search-popup -->
    </div><!-- /.header-tools__item hover-container -->

    <div class="header-tools__item hover-container">
        <a class="header-tools__item js-open-aside" href="#" data-aside="customerForms">
            <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_user" />
            </svg>
        </a>
    </div>


    <a href="#" class="header-tools__item header-tools__cart js-open-aside" data-aside="cartDrawer">
        <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_cart" />
        </svg>
        <span class="cart-amount d-block position-absolute js-cart-items-count">3</span>
    </a>
</div><!-- /.header__tools -->
