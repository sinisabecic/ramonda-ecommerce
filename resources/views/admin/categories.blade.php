@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" type="text/css"
          href="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.css"/>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('page-title', 'Categories')


@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-primary" href="/admin">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a id="breadcrumb-link"
                           href="{{ route('admin.products') }}"
                        >Products</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="font-weight-bold text-gray-700"
                           href="{{ route('admin.products.categories') }}">{{ __('Categories') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a id="breadcrumb-link"
                           href="{{ route('shop.index') }}"
                           target="_blank"
                        >Shop</a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a href="#!" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCategoryModal"
                   style="float: right">
                    <i class="fas fa-cart-plus"></i> New category
                </a>

                {{-- Submit bulk delete --}}
                <button class="btn btn-danger btn-sm ml-1 bulkDeleteBtn"
                        onclick="deleteCategories()"
                        style=" float: right
                "
                        data-url="{{ route('admin.products.categories.delete') }}">
                    <i class="fas fa-trash"></i> Delete
                </button>

                <button class="btn btn-warning btn-sm text-dark ml-1 bulkRemoveBtn"
                        onclick="removeCategories()"
                        style=" float: right
                "
                        data-url="{{ route('admin.products.categories.remove') }}">
                    <i class="fas fa-minus-circle"></i> Remove
                </button>

                <button class="btn btn-dark btn-sm ml-1 bulkRestoreBtn"
                        onclick="restoreCategories()"
                        style=" float: right
                "
                        data-url="{{ route('admin.products.categories.restore') }}">
                    <i class="fas fa-trash-restore"></i> Restore
                </button>

                <a href="{{ route('admin.products.categories') }}" class="btn btn-outline-secondary btn-sm ml-1"
                   style="float: right">
                    <i class="fas fa-redo-alt"></i> Refresh
                </a>
            </div>
            <div class="table table-responsive">
                <table class="display" id="dataTableProducts" width="100%"
                       cellspacing="0">
                    <thead>
                    <tr>
                        <th width="12px !important">
                            #
                            <input type="checkbox" id="master"/>
                        </th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if($categories)
                        @foreach($categories as $category)

                            <tr class="row-category sub_chk" data-id="{{ $category->id }}">
                                <td>
                                    <input type="checkbox" class="sub_chk" data-id="{{$category->id}}">
                                </td>
                                <td><span class="small">{{ $category->id }}</span></td>
                                <td>
                                    <a href="{{ route('shop.index', ['category' => $category->slug ]) }}"
                                       target="_blank"
                                       class="small"><strong>{{ $category->name }}</strong></a>
                                </td>
                                <td>
                                    <a href="{{ route('shop.index', ['category' => $category->slug ]) }}"
                                       target="_blank"
                                       class="small"><strong>{{ $category->slug }}</strong></a>
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-secondary small">
                                         {{ $category->created_at->diffForHumans() }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge badge-pill badge-secondary small">
                                         {{ $category->updated_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-inline-flex">
                                        @if(!$category->deleted_at)
                                            <div class="px-1">
                                                <button type="button" onclick="deleteCategory('{{ $category->id }}')"
                                                        class="btn btn-danger deleteBtn"
                                                        data-url="{{ route('admin.products.categories.destroy', $category->id) }}">
                                                    Delete
                                                </button>
                                            </div>
                                        @else
                                            @if(auth()->user()->is_admin)
                                                <div class="px-1">
                                                    <button type="button"
                                                            onclick="restoreCategory('{{ $category->id }}')"
                                                            class="btn btn-dark restoreBtn">
                                                        Restore
                                                    </button>
                                                </div>
                                            @endif
                                        @endif

                                        @if(auth()->user()->is_admin)
                                            <div class="px-1">
                                                <button type="button"
                                                        onclick="forceDeleteCategory('{{ $category->id }}')"
                                                        class="btn btn-warning text-dark forceDeleteBtn">
                                                    Remove
                                                </button>
                                            </div>
                                        @endif
                                        @if(!$category->deleted_at)
                                            <div class="px-1">
                                                <a href="{{ route("admin.products.categories.edit", $category->id) }}"
                                                   id="editcategory"
                                                   class="btn btn-primary editBtn" data-id="{{ $category->id }}">
                                                    Edit
                                                </a>
                                            </div>
                                    @endif
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

@include('admin.categories.add_category')

@section('script')
    <script src="{{ asset('/js/admin/categories/functions.js') }}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('/js/demo/datatables-demo.js') }}"></script>
@endsection