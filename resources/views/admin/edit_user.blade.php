@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
    <style>
        .dropzone.dz-clickable {
            width: 50%;
            margin: 0.5rem 0 0 9.6rem;
        }
    </style>
@endsection

@section('page-title', 'Edit user')

@section('content')

    <div class="row">
        <div class="col-sm-6">
            <form method="POST" action="" enctype="multipart/form-data" id="editUserForm">
                @csrf
                @method('PUT')

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        @if(auth()->user()->is_admin)
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="{{ route('users') }}">Users</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item" aria-current="page">
                        
                            <a href="{{ route('users.edit', $user->id) }}"
                               class="font-weight-bold">{{ $user->name }}</a>
                        </li>
                    </ol>
                </nav>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                    <div class="col-md-6">
                        <input id="username" type="text"
                               class="form-control @error('username') is-invalid @enderror" name="username"
                               value="{{ $user->username }}" autocomplete="username" autofocus>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ $user->email }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country')
                                        }}</label>

                    <div class="col-md-6">
                        <select class="form-control" name="country_id" id="country">

                            <option value="{{ $user->country->id }}" selected>{{ $user->country->name }}</option>

                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address')
                                        }}</label>

                    <div class="col-md-6">
                        <input id="address" type="text"
                               class="form-control @error('address') is-invalid @enderror" name="address"
                               value="{{ $user->address }}" autocomplete="address" autofocus>

                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="is_active" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                    <div class="col-md-6">
                        <select class="form-control" name="is_active" id="is_active">

                            @isset($user) @if($user->is_active == '1')
                                <option value="1" selected>{{ __('Active') }}</option>
                                <option value="0">{{ __('Not active') }}</option>
                            @endif

                            @if($user->is_active == '0')
                                <option value="0" selected>{{ __('Not active') }}</option>
                                <option value="1">{{ __('Active') }}</option>
                            @endif
                            @endisset

                        </select>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="roles" class="col-md-4 col-form-label text-md-right">{{ __('Roles') }}</label>
                    <div class="col-md-6">
                        @foreach ($roles as $role)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="roles[]"
                                       value="{{ $role->id }}" id="{{ $role->name }}"
                                       @isset($user) @if(in_array($role->id, $user->roles->pluck('id')->toArray())) checked @endif @endisset
                                >
                                <label for="{{ $role->name }}" class="form-check-label">
                                    {{ $role->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                        <a href="{{ route('users') }}" type="button" class="btn btn-secondary">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-sm-6">
            <div class="d-flex justify-content-center">
                <img src="{{ $user->avatar() }}"
                     alt="{{ $user->photo->url }}"
                     height="50%"
                     width="50%"
                     class="rounded">
            </div>

            <form action="{{ route('user.photo.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                  class="dropzone"
                  id="updatePhoto">
                @csrf
                @method('PUT')
            </form>

        </div>

    </div>



@endsection

@section('script')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Access-Control-Allow-Origin': '*',
                    'Access-Control-Allow-Methods': 'GET,POST,PUT,PATCH,DELETE,OPTIONS',
                    'Access-Control-Max-Age': '3600',
                    'Access-Control-Allow-Headers': 'x-requested-with, content-type',
                    'Accept': 'application/json',
                }
            });

            //? Edit user from admin
            $('#editUserForm').submit(function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    method: 'POST',
                    url: "{{ route('users.update', $user->id) }}",
                    data: formData,
                    success: function () {
                        Swal.fire({
                            title: 'User edited!',
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
                })
                ;
            });
        });


        Dropzone.options.updatePhoto = { // camelized version of the `id`
            paramName: "avatar", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            init: function () {
                this.on("addedfile", avatar => {
                    console.log("Photo has updated!");
                    Swal.fire({
                        title: 'Photo has updated!',
                        // text: '',
                        icon: 'success',
                        toast: true,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 2500,
                    });
                });
            },
        };
    </script>
@endsection
