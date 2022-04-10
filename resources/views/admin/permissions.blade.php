@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.css"/>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('page-title', 'Permissions')


@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a href="#!" class="btn btn-primary btn-sm" data-toggle="modal"
                   data-target="#addPermissionModal"
                   style="float: right">
                    <i class="fas fa-user-plus"></i> New permission
                </a>
                <a href="{{ route('permissions') }}" class="btn btn-secondary btn-sm ml-1"
                   style="float: right">
                    <i class="fas fa-redo-alt"></i> Refresh
                </a>
            </div>
            <div class="table table-responsive">
                <table class="display hover" id="dataTablePermissions" width="100%"
                       cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Permission</th>
                        <th>Created</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if($permissions)
                        @foreach($permissions as $permission)
                            <tr class="row-permission" data-id="{{ $permission->id }}">
                                <td><span class="small">{{ $permission->id }}</span></td>
                                <td class="permission">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item m-0 p-0 py-1 bg-transparent">
                                            <span
                                                    class="badge badge-pill badge-primary rounded-0">{{ $permission->name }}</span>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                 <span class="badge badge-pill badge-secondary small">
                                     {{ $permission->created_at->diffForHumans() }}
                                </span>
                                </td>
                                <td>
                                <span class="badge badge-pill small">
                                    {{ $permission->created_at->format('d.m.Y. H:i:s') }}
                                </span>
                                </td>
                                <td>
                                    <div class="d-inline-flex">

                                        <div class="px-1">
                                            <button type="button"
                                                    onclick="deletePermission('{{ $permission->id }}')"
                                                    class="btn btn-danger deletePermissionBtn">
                                                Delete
                                            </button>
                                        </div>

                                        <div class="px-1">
                                            <a href="{{ route("permissions.edit", $permission->id) }}"
                                               id="editpermission"
                                               class="btn btn-primary editPermissionBtn"
                                               data-id="{{ $permission->id }}">
                                                Edit
                                            </a>
                                        </div>

                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@include('admin.layouts.add_permission')

@section('script')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('/js/demo/datatables-demo.js') }}"></script>
    <script src="{{ asset('/js/admin/permissions/functions.js') }}"></script>
@endsection



