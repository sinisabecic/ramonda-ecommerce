@extends('admin.layouts.app')
@section('page-title', 'Edit post')

@section('content')

    <form method="POST" action="" enctype="multipart/form-data" id="editPostForm">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title" class="col-md-4 col-form-label text-md-left">{{ __('Title') }}</label>

            <div class="col-lg">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                       name="title" value="{{ $post->title }}" required autocomplete="name" autofocus>

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
                                  name="content">{{ $post->content }}</textarea>

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

                    <option value="{{ $post->author->id }}" selected> {{ $post->author->username }} <span
                            class="text-primary">({{ $post->author->name }} from {{ $post->author->country->name }})</span>
                    </option>

                    @foreach ($users as $user)
                        {{-- ? Da se ne ponavlja ime autora dva puta --}}
                        @if($post->author->id !== $user->id)
                            <option value="{{ $user->id }}">{{ $user->username }} <span class="text-primary">({{ $user->name }} from {{ $user->country->name }})</span>
                            </option>
                        @endif
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
                    {{ __('Update') }}
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
    <script>

        //? Dodavanje korisnika
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //? Za dodavanje korisnika
            $('#editPostForm').submit(function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    method: 'POST', //nekad mora post da ide za update i za delete
                    url: "{{ route('blog.posts.update', $post->id) }}",
                    data: formData,
                    success: function () {
                        Swal.fire({
                            title: 'Post edited!',
                            // text: '',
                            icon: 'success',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,
                        });
                    },
                    error: function () {
                        // alert('Greska! Pokusaj ponovo');
                        Swal.fire({
                            title: 'Error! Something went wrong',
                            // text: '',
                            icon: 'error',
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 2500,
                        })
                    },
                    contentType: false,
                    processData: false,
                });
            });
        });

        function clearFields(form) {
            $(':input', form)
                .not(':button, :submit, :reset, :hidden')
                .val('')
                .prop('checked', false)
                .prop('selected', false);

        }

        //? Editor
        var editor_config = {
            path_absolute: "/",
            selector: 'textarea.my-editor',
            relative_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            file_picker_callback: function (callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        };

        tinymce.init(editor_config);

    </script>
@endsection
