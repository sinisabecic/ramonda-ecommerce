@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" type="text/css"
          href="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.css"/>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('page-title', 'Users')


@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-primary" href="/admin">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="font-weight-bold text-primary"
                           href="{{ route('users') }}">{{ __('Users') }}</a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a href="#!" class="btn btn-primary btn-sm" data-toggle="modal"
                   data-target="#addModal"
                   style="float: right">
                    <i class="fas fa-user-plus"></i> New user
                </a>

                {{-- Submit bulk delete --}}
                <button class="btn btn-danger btn-sm ml-1 bulkDeleteBtn"
                        onclick="deleteUsers()"
                        style=" float: right
                "
                        data-url="{{ route('admin.users.delete') }}">
                    <i class="fas fa-trash"></i> Delete
                </button>

                <button class="btn btn-warning btn-sm text-dark ml-1 bulkRemoveBtn"
                        onclick="removeUsers()"
                        style=" float: right
                "
                        data-url="{{ route('admin.users.remove') }}">
                    <i class="fas fa-minus-circle"></i> Remove
                </button>

                <button class="btn btn-dark btn-sm ml-1 bulkRestoreBtn"
                        onclick="restoreUsers()"
                        style=" float: right
                "
                        data-url="{{ route('admin.users.restore') }}">
                    <i class="fas fa-trash-restore"></i> Restore
                </button>

                <a href="{{ route('users') }}" class="btn btn-outline-secondary btn-sm ml-1"
                   style="float: right">
                    <i class="fas fa-redo-alt"></i> Refresh
                </a>
            </div>
            <div class="table table-responsive">
                <table class="display" id="dataTable" width="100%"
                       cellspacing="0">
                    <thead>
                    <tr>
                        <th width="12px !important">
                            #
                            <input type="checkbox" id="master" name="checkBoxArray[]"/>
                        </th>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Role(s)</th>
                        <th>E-mail</th>
                        <th>Country</th>
                        <th>Registered</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($users as $user)
                        <tr class="row-user sub_chk" data-id="{{ $user->id }}">
                            <td>
                                <input type="checkbox" class="sub_chk" data-id="{{$user->id}}">
                            </td>
                            <td><span class="small">{{ $user->id }}</span></td>
                            <td>
                                <p class="small"><strong>{{ $user->username }}</strong></p>
                            </td>
                            <td>
                                @if ($user->photo)
                                    <img src="{{ $user->avatar() }}" alt="{{ $user->photo->url }}"
                                         height="43px"
                                         width="43px"
                                         class="img-cover rounded">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route("users.edit", $user->id) }}">
                                    <span class="small font-weight-bold text-primary">{{ $user->name }}</span>
                                </a>
                            </td>
                            <td class="role">
                                @foreach($user->roles as $role)
                                    @switch($role->name)
                                        @case(ucfirst("admin"))
                                        <span class="badge badge-pill badge-success rounded-0">{{ $role->name }}</span>
                                        @break
                                        @default
                                        <span class="badge badge-pill badge-dark rounded-0">{{ $role->name }}</span>
                                    @endswitch
                                @endforeach
                            </td>
                            <td class="small font-weight-bold">
                                <a href="mailto:{{ $user->email }}" class="text-dark">{{ $user->email }}</a>
                            </td>
                            <td class="country small">{{ $user->country->name }}</td>
                            <td>
                                 <span class="badge badge-pill badge-secondary small">
                                     {{ $user->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-pill small">
                                    {{ $user->created_at->format('d.m.Y. H:i:s') }}
                                </span>
                            </td>
                            <td>
                                <div class="d-inline-flex">

                                    @if(!$user->deleted_at)
                                        <div class="px-1">
                                            <button type="button" onclick="deleteUser('{{ $user->id }}')"
                                                    class="btn btn-danger deleteBtn">
                                                Delete
                                            </button>
                                        </div>
                                    @else
                                        @if(auth()->user()->is_admin)
                                            <div class="px-1">
                                                <button type="button" onclick="restoreUser('{{ $user->id }}')"
                                                        class="btn btn-dark restoreBtn">
                                                    Restore
                                                </button>
                                            </div>
                                        @endif
                                    @endif

                                    @if(auth()->user()->is_admin)
                                        <div class="px-1">
                                            <button type="button" onclick="forceDeleteUser('{{ $user->id }}')"
                                                    class="btn btn-warning text-dark forceDeleteBtn">
                                                Remove
                                            </button>
                                        </div>
                                    @endif
                                    @if(!$user->deleted_at)

                                        <div class="btn-group editUserBtn">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                Edit
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route("users.edit", $user->id) }}" id="edituser"
                                                   class="dropdown-item" data-id="{{ $user->id }}">
                                                    Edit data
                                                </a>
                                                <a href="{{ route("users.edit.password", $user->id) }}"
                                                   id="editpassword"
                                                   class="dropdown-item"
                                                   data-id="{{ $user->id }}">
                                                    Edit password
                                                </a>
                                            </div>
                                        </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@include('admin.layouts.add_user')

@section('script')
    <script src="{{ asset('/js/admin/users/functions.js') }}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('/js/demo/datatables-demo.js') }}"></script>
@endsection



