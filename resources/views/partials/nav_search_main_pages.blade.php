   {{-- Search Menu --}}
   <form action="./" method="GET" class="header-search search-field d-none d-xxl-flex">
       <button class="btn header-search__btn" type="submit">
           <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
               xmlns="http://www.w3.org/2000/svg">
               <use href="#icon_search" />
           </svg>
       </button>
       <input class="header-search__input w-100" type="text" name="search-keyword" placeholder="Search products...">
       <div class="hover-container position-relative">
           <div class="js-hover__open">
               <input class="header-search__category search-field__actor border-0 bg-white w-100" type="text"
                   name="search-category" placeholder="All Category" readonly>
           </div>
           <div class="header-search__category-list js-hidden-content mt-2">
               <ul class="search-suggestion list-unstyled">
                   <li class="search-suggestion__item js-search-select">All Category</li>
                   <li class="search-suggestion__item js-search-select">Men</li>
                   <li class="search-suggestion__item js-search-select">Women</li>
                   <li class="search-suggestion__item js-search-select">Kids</li>
               </ul>
           </div>
       </div>
   </form><!-- /.header-search -->
