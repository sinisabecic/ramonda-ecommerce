@include('admin.layouts.head')
@include('admin.layouts.sidebar')


<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">

        @include('admin.layouts.nav')

        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">@yield('page-title', '')</h1>

            @yield('content')

        </div>
    </div>

@include('admin.layouts.footer')



