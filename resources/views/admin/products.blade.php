@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" type="text/css"
          href="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.css"/>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('page-title', 'Products')


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
                           href="{{ route('admin.products') }}">{{ __('Products') }}</a>
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
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm"
                   style="float: right">
                    <i class="fas fa-cart-plus"></i> New product
                </a>

                {{-- Submit bulk delete --}}
                <button class="btn btn-danger btn-sm ml-1 bulkDeleteBtn"
                        onclick="deleteProducts()"
                        style=" float: right
                "
                        data-url="{{ route('admin.products.delete') }}">
                    <i class="fas fa-trash"></i> Delete
                </button>

                <button class="btn btn-warning btn-sm text-dark ml-1 bulkRemoveBtn"
                        onclick="removeProducts()"
                        style=" float: right
                "
                        data-url="{{ route('admin.products.remove') }}">
                    <i class="fas fa-minus-circle"></i> Remove
                </button>

                <button class="btn btn-dark btn-sm ml-1 bulkRestoreBtn"
                        onclick="restoreProducts()"
                        style=" float: right
                "
                        data-url="{{ route('admin.products.restore') }}">
                    <i class="fas fa-trash-restore"></i> Restore
                </button>

                <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary btn-sm ml-1"
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
                        <th>Image</th>
                        <th>Price</th>
                        <th>Featured</th>
                        <th>Created</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if($products)
                        @foreach($products as $product)

                            <tr class="row-product sub_chk" data-id="{{ $product->id }}">
                                <td>
                                    <input type="checkbox" class="sub_chk" data-id="{{$product->id}}">
                                </td>
                                <td><span class="">{{ $product->id }}</span></td>
                                <td>
                                    <a href="{{ route('shop.show', $product->slug) }}" target="_blank"
                                       class=""><strong>{{ $product->name }}</strong></a>
                                </td>
                                <td>
                                    <img class="img-cover"
                                         src="{{ $product->productImage() }}"
                                         alt="{{$product->image}}"
                                         height="50px"
                                         width="50px"
                                    >
                                </td>
                                <td class="font-weight-bold">
                                    <span class="text-dark">{{ $product->presentPrice() }} &euro;</span>
                                </td>
                                <td>
                                    @switch($product->featured)
                                        @case("1")
                                        <span
                                                class="badge badge-pill badge-warning text-dark rounded">{{ __('Featured') }}</span>
                                        @break
                                        @case("0")
                                        <span
                                                class="badge badge-pill badge-light rounded">{{ __('Not Featured') }}</span>
                                        @break
                                        @default("0")
                                    @endswitch
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-secondary">
                                         {{ $product->created_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td>
                                <span>
                                    {{ $product->quantity }}
                                </span>
                                </td>
                                <td>
                                    <div class="d-inline-flex">
                                        @if(!$product->deleted_at)
                                            <div class="px-1">
                                                <button type="button" onclick="deleteProduct('{{ $product->id }}')"
                                                        class="btn btn-danger btn-sm deleteProductBtn">
                                                    Delete
                                                </button>
                                            </div>
                                        @else
                                            @if(auth()->user()->is_admin)
                                                <div class="px-1">
                                                    <button type="button" onclick="restoreProduct('{{ $product->id }}')"
                                                            class="btn btn-dark btn-sm restoreProductBtn">
                                                        Restore
                                                    </button>
                                                </div>
                                            @endif
                                        @endif

                                        @if(auth()->user()->is_admin)
                                            <div class="px-1">
                                                <button type="button" onclick="forceDeleteProduct('{{ $product->id }}')"
                                                        class="btn btn-warning btn-sm text-dark forceDeleteBtn">
                                                    Remove
                                                </button>
                                            </div>
                                        @endif
                                        @if(!$product->deleted_at)
                                            <div class="px-1">
                                                <a href="{{ route("admin.products.edit", $product->id) }}"
                                                   id="editproduct"
                                                   class="btn btn-primary btn-sm editProductBtn"
                                                   data-id="{{ $product->id }}">
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


@section('script')
    <script src="{{ asset('/js/admin/products/functions.js') }}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('/js/demo/datatables-demo.js') }}"></script>
@endsection



