@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
@endsection
@section('page-title', 'New product')

@section('content')

    <form method="POST" action="" id="addProductForm" enctype="multipart/form-data"
          data-url="{{ route('admin.products.store') }}">
        @csrf

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">{{ __('Products') }}</a></li>
                {{--                <li class="breadcrumb-item" aria-current="page">Create</li>--}}
                <li class="breadcrumb-item">
                    Create product: <a id="breadcrumb-link" class="font-weight-bold"
                                       href="#!"
                                       data-app-url="{{ env('APP_URL') }}" target="_blank"
                    ></a>
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
                               name="name" required autocomplete="name" autofocus onkeyup="generateSlug()">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-md-4 col-form-label text-md-left">{{ __('Details') }}</label>

                    <div class="col-lg">
                        <input id="details" type="text" class="form-control @error('details') is-invalid @enderror"
                               name="details" required autocomplete="details" autofocus>

                        @error('details')
                        <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="editor" class="col-md-4 col-form-label text-md-left">{{ __('Description') }}</label>

                    <div class="col-lg">
                        <textarea id="editor" cols="80" rows="20"
                                  class="form-control my-editor @error('description') is-invalid @enderror"
                                  name="description"></textarea>

                        @error('description')
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
                    <label for="price" class="col-form-label text-md-left">{{ __('Price') }}</label>
                    <input id="price" type="text" class="form-control @error('price') is-invalid @enderror"
                           name="price" required autocomplete="price" autofocus placeholder="00,0 &euro;">
                    @error('price')
                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="quantity" class="col-form-label text-md-left">{{ __('Quantity') }}</label>


                    <input id="quantity" type="text" class="form-control @error('quantity') is-invalid @enderror"
                           name="quantity" required autocomplete="quantity" autofocus placeholder="">

                    @error('quantity')
                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="slug" class="col-form-label text-md-left">{{ __('Slug') }}</label>
                    <input id="slug" type="text" class="form-control @error('price') is-invalid @enderror"
                           name="slug" required autocomplete="price" autofocus placeholder="">
                    @error('slug')
                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="featured" class="col-form-label text-md-left">{{ __('Featured') }}</label>
                    <select class="form-control" name="featured" id="featured">
                        <option value="1">{{ __('Featured') }}</option>
                        <option value="0" checked>{{ __('Not Featured') }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="categories" class="col-form-label text-md-left">{{ __('Categories') }}</label>
                    <div class="col-md-6">
                        @foreach ($categories as $category)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="categories[]"
                                       value="{{ $category->id }}" id="{{ $category->name }}"
                                       @isset($product) @if(in_array($category->id, $product->categories->pluck('id')->toArray())) checked @endif @endisset
                                >
                                <label for="{{ $category->name }}" class="form-check-label">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label for="image" class="col-form-label text-md-left">{{ __('Featured Image') }}</label>
                    <div class="custom-file">
                        <label for="image"
                               class="custom-file-label col-form-label text-md-left">{{ __('Select product image') }}</label>
                        <input type="file" id="image"
                               class="custom-file-input @error('image') is-invalid @enderror"
                               name="image" value="{{ old('image') }}">

                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="images" class="col-form-label text-md-left">{{ __('Multiple Images') }}</label>
                    <div class="custom-file">
                        <label for="images"
                               class="custom-file-label col-form-label text-md-left">{{ __('Select images') }}</label>
                        <input type="file" id="images"
                               class="custom-file-input @error('images') is-invalid @enderror"
                               name="images[]" value="{{ old('images') }}" accept="image/*" multiple>

                        @error('images')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-5 mt-4 float-right">
                    <div class="col-md">
                        <button type="submit" class="btn btn-primary btn-md">
                            {{ __('Create') }}
                        </button>
                        <a href="{{ route('admin.products') }}" type="button" class="btn btn-secondary  btn-md">
                            {{ __('Cancel') }}
                        </a>
                        <a href="" type="button" target="_blank"
                           class="btn btn-success btn-md showProductBtn">
                            <i class="fa fa-shopping-cart"></i> {{ __('Product') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/aq4yxpek36fz7epa0kqorg4304hgfjrk8qqwtf0binzc8iw6/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script src="{{ asset('/js/admin/products/functions.js') }}"></script>
    <script src="{{ asset('/js/admin/products/editor.js') }}"></script>
@endsection
