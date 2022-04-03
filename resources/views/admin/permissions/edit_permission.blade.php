@extends('admin.layouts.app')
@section('page-title', 'Edit permission: ' . $permission->name)

@section('content')

    <div class="row">
        <div class="col-sm-6">
            <form method="POST" action="" id="editPermissionForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="permission"
                           class="col-md-4 col-form-label text-md-right">{{ __('Permission name') }}</label>

                    <div class="col-md-6">
                        <input id="permission" type="text"
                               class="form-control @error('permission') is-invalid @enderror"
                               name="name" value="{{ $permission->name }}" required autocomplete="permission"
                               autofocus>

                        @error('permission')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label for="description"
                           class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                    <div class="col-md-6">
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                      id="description" cols="30" rows="5">{{ $permission->description }}</textarea>


                        @error('description')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary" id="editPermission">
                            {{ __('Update') }}
                        </button>
                        <a href="{{ route('permissions') }}" class="btn btn-secondary">
                            {{ __('Close') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection

@section('script')
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

            $('#editPermissionForm').submit(function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    method: 'POST',
                    url: "{{ route('permissions.update', $permission->id) }}",
                    data: formData,
                    success: function () {
                        Swal.fire({
                            title: 'Permission edited!',
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
    </script>
@endsection


