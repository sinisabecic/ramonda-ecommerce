@include('admin.layouts.head')
@include('admin.layouts.sidebar')


<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">

        @include('admin.layouts.nav')

        <div class="container-fluid">

            @if (session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session()->get('success_message') }}
                </div>
            @endif

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">@yield('page-title', '')</h1>

            @yield('content')

        </div>
    </div>

@include('admin.layouts.footer')



