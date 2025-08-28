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
        <a class="dropdown-item" href="{{ route('admin.about_us') }}">About Us</a>
        <a class="dropdown-item" href="{{ route('coupons.index') }}">Coupons</a>
        <a class="dropdown-item" href="{{ route('contactRequests.index') }}">Contact
            Request</a>
        <a class="dropdown-item" href="{{ route('site_settings.index') }}">Site Settings</a>
    </div>
</li>
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" v-pre>
        User Management
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('customers.index') }}">Customers</a>
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
        <a class="dropdown-item" href="{{ route('vendors.index') }}">Vendors</a>
        <a class="dropdown-item" href="{{ route('categories.index') }}">Category</a>
        {{-- <a class="dropdown-item" href="{{route('subcategory.index')}}">Subcategory</a> --}}
        <a class="dropdown-item" href="{{ route('products.index') }}">Products</a>
    </div>
</li>
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" v-pre>
        Sales
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('invoices.index') }}">Invoice</a>
        <a class="dropdown-item" href="{{ route('quotations.index') }}">Quotation</a>
    </div>
</li>
