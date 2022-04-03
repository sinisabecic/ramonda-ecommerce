@extends('admin.layouts.app')
@section('page-title', 'New post')

@section('content')

    <form method="POST" action="" enctype="multipart/form-data" id="addPostForm"
          data-url="{{ route('blog.posts.store') }}">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="title" class="col-md-4 col-form-label text-md-left">{{ __('Title') }}</label>

            <div class="col-lg">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                       name="title" required autocomplete="name" autofocus>

                @error('title')
                <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="editor" class="col-md-4 col-form-label text-md-left">{{ __('Content') }}</label>

            <div class="col-lg">
                        <textarea id="editor" cols="80" rows="20"
                                  class="form-control my-editor @error('content') is-invalid @enderror"
                                  name="content"></textarea>

                @error('content')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="user_id" class="col-md-4 col-form-label text-md-left">{{ __('Author') }}</label>

            <div class="col-md-4">
                <select class="form-control" name="user_id" id="user_id">

                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"

                                @if(in_array($user->id, auth()->user()->pluck('id')->toArray())) checked @endif

                        >{{ $user->name }}</option>
                    @endforeach

                </select>
            </div>
        </div>

        <div>
            <label for="banner" class="col-md-4 col-form-label text-md-left">{{ __('Banner') }}</label>
            <div class="col-md-6" style="">
                <input type="file" id="banner"
                       class="form-control-file @error('banner') is-invalid @enderror"
                       name="banner" value="{{ old('banner') }}">

                @error('banner')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group mb-5 mt-4 float-right">
            <hr/>
            <div class="col-md">
                <button type="submit" class="btn btn-primary btn-lg">
                    {{ __('Create') }}
                </button>
                <a href="{{ route('blog.posts') }}" type="button" class="btn btn-secondary  btn-lg">
                    {{ __('Cancel') }}
                </a>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/aq4yxpek36fz7epa0kqorg4304hgfjrk8qqwtf0binzc8iw6/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script src="{{ asset('/js/admin/posts/functions.js') }}"></script>
    <script src="{{ asset('/js/admin/posts/editor.js') }}"></script>
@endsection
