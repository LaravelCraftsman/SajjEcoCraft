<li class="nav-item">
    <a class="nav-link" href="#">Dashboard</a>
</li>
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" v-pre>
        Content Management
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('sliders.index') }}">Sliders</a>
        <a class="dropdown-item" href="{{ route('branches.index') }}">Branches</a>
        <a class="dropdown-item" href="{{ route('blogs.index') }}">Blogs</a>
        <a class="dropdown-item" href="{{ route('faqs.index') }}">FAQ</a>
        <a class="dropdown-item" href="{{ route('banners') }}">Banners</a>
        <a class="dropdown-item" href="{{ route('about_us') }}">About Us</a>
        <a class="dropdown-item" href="{{ route('coupons.index') }}">Coupons</a>
        <a class="dropdown-item" href="{{ route('contactRequests.index') }}">Contact
            Request</a>
        <a class="dropdown-item" href="#">Site Settings</a>
    </div>
</li>
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" v-pre>
        User Management
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="#">Customers</a>
        <a class="dropdown-item" href="{{ route('staff.index') }}">Staff</a>
    </div>
</li>
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" v-pre>
        Products Management
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        {{-- <a class="dropdown-item" href="{{route('brands.index')}}">Brands</a> --}}
        <a class="dropdown-item" href="#">Vendors</a>
        <a class="dropdown-item" href="#">Category</a>
        {{-- <a class="dropdown-item" href="{{route('subcategory.index')}}">Subcategory</a> --}}
        <a class="dropdown-item" href="#">Products</a>
    </div>
</li>
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" v-pre>
        Sales
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="#">Invoice</a>
        <a class="dropdown-item" href="#">Quotation</a>
    </div>
</li>
