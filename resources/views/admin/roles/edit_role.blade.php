@extends('admin.layouts.app')
@section('page-title', 'Edit role: ' . $role->name)

@section('content')

    <div class="row">
        <div class="col-sm-6">
            <form method="POST" action="" id="editRoleForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ $role->name }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label for="permissions"
                           class="col-md-4 col-form-label text-md-right">{{ __('Permissions') }}</label>
                    <div class="col-md-6">
                        @foreach ($permissions as $permission)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="permissions[]"
                                       value="{{ $permission->id }}" id="{{ $permission->name }}"

                                       @isset($role) @if(in_array($permission->id, $role->permissions->pluck('id')->toArray())) checked @endif @endisset
                                >

                                <label for="{{ $permission->name }}" class="form-check-label">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary" id="editRole">
                            {{ __('Update') }}
                        </button>
                        <a href="{{ route('roles') }}" class="btn btn-secondary">
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
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#editRoleForm').submit(function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    method: 'POST',
                    url: "{{ route('roles.update', $role->id) }}",
                    data: formData,
                    success: function () {
                        Swal.fire({
                            title: 'Role edited!',
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


