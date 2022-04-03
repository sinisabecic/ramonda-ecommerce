@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
@endsection
@section('page-title', 'Edit category')

@section('content')

    <form method="POST" action="" id="editCategoryForm" enctype="multipart/form-data"
          data-url="{{ route('admin.products.categories.update', $category->id) }}">
        @method('PUT')
        @csrf

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item"><a
                            href="{{ route('admin.products') }}">{{ __('Products') }}</a></li>
                <li class="breadcrumb-item"><a
                            href="{{ route('admin.products.categories') }}">{{ __('Categories') }}</a></li>
                {{--                <li class="breadcrumb-item" aria-current="page">Edit</li>--}}
                <li class="breadcrumb-item">
                    Category: <a id="breadcrumb-link" class="font-weight-bold"
                                 href="{{ route('shop.index', ['category' => $category->slug]) }}"
                                 data-app-url="{{ env('APP_URL') }}" target="_blank"
                    >{{ $category->name }}</a>
                </li>
            </ol>
        </nav>

        <div class="row">

            {{--? Left side --}}
            <div class="col-md-8">

                <div class="form-group">
                    <label for="name" class="col-md-4 col-form-label text-md-left">{{ __('Name') }}</label>

                    <div class="col-lg">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" required autocomplete="name" autofocus onkeyup="generateSlug()"
                               value="{{ old('name',$category->name) }}">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

            </div>

            {{--? Right side --}}
            <div class="col-md-4">

                <div class="form-group">
                    <label for="slug" class="col-form-label text-md-left">{{ __('Slug') }}</label>
                    <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                           name="slug" required autocomplete="price" autofocus placeholder=""
                           value="{{ old('quantity', $category->slug) }}">
                    @error('slug')
                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="form-group mb-5 mt-4 float-right">
                    <div class="col-md">
                        <button type="submit" class="btn btn-primary btn-md">
                            <i class="fas fa-save"></i> {{ __('Save') }}
                        </button>
                        <a href="{{ route('admin.products.categories') }}" type="button"
                           class="btn btn-secondary btn-md">
                            <i class="fas fa-angle-left"></i> {{ __('Return back') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ asset('/js/admin/categories/functions.js') }}"></script>
@endsection
