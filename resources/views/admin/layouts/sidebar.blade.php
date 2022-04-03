<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin') }}">
        {{--        <div class="sidebar-brand-icon rotate-n-15">--}}
        {{--            <i class="fas fa-laugh-wink"></i>--}}
        {{--        </div>--}}
        <div class="sidebar-brand-text mx-3">
            {{ config('app.name') }}


            @switch(auth()->user()->role)
                @case(ucfirst("admin"))
                <span class="badge bg-gradient-dark">{{ auth()->user()->role }}</span>
                @break
                @default
                <span class="badge badge-pill badge-danger">{{ auth()->user()->role }}</span>
            @endswitch

        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'admin')) active @endif">
        <a class="nav-link" href="{{ route('admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

{{--    <!-- Divider -->--}}
{{--    <hr class="sidebar-divider">--}}

<!-- Nav Item - Tables -->
    @if (auth()->check() && auth()->user()->hasRole('Admin'))
        <li class="nav-item @if(\Illuminate\Support\Str::contains(request()->route()->getName(), ['users', 'roles', 'permissions'])) active @endif">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-power-off"></i>
                <span>Authorization</span>
            </a>
            <div id="collapseOne"
                 class="collapse @if(\Illuminate\Support\Str::contains(request()->route()->getName(), ['users', 'roles', 'permissions'])) show @endif"
                 aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded-sm">
                    <h6 class="collapse-header">Manage authorization:</h6>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'users')) active @endif"
                       href="{{ route('users') }}">
                        <i class="fas fa-fw fa-user"></i>
                        Users
                    </a>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'roles')) active @endif"
                       href="{{ route('roles') }}">
                        <i class="fas fa-user-tag"></i>
                        Roles
                    </a>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'permissions')) active @endif"
                       href="{{ route('permissions') }}">
                        <i class="fas fa-ban"></i>
                        Permissions
                    </a>
                </div>
            </div>
        </li>
    @endif

    @if(auth()->user()->is_admin)
        <li class="nav-item @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'products')) active @endif">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
               aria-expanded="true" aria-controls="collapseThree">
                <i class="fas fa-shopping-cart"></i>
                <span>E-commerce</span>
            </a>
            <div id="collapseThree"
                 class="collapse @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'products')) show @endif"
                 aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded-sm">
                    <h6 class="collapse-header">Manage products:</h6>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'products')) active @endif"
                       href="{{ route('admin.products') }}">
                        <i class="fab fa-product-hunt"></i>
                        Products
                    </a>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'create')) active @endif"
                       href="{{ route('admin.products.create') }}">
                        <i class="fas fa-cart-plus"></i>
                        New Product
                    </a>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'orders')) active @endif"
                       href="{{ route('admin.products.orders') }}">
                        <i class="fab fa-product-hunt"></i>
                        Orders
                    </a>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'coupons')) active @endif"
                       href="{{ route('admin.products.coupons') }}">
                        <i class="fab fa-product-hunt"></i>
                        Coupons
                    </a>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'categories')) active @endif"
                       href="{{ route('admin.products.categories') }}">
                        <i class="fas fa-shopping-bag"></i>
                        Categories
                    </a>
                </div>
            </div>
        </li>

        <li class="nav-item @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'filemanager')) active @endif">
            <a class="nav-link" href="/admin/filemanager">
                <i class="fas fa-file-archive"></i>
                <span>File manager</span></a>
        </li>
@endif

{{--    <!-- Divider -->--}}
{{--    <hr class="sidebar-divider d-none d-md-block">--}}

<!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
