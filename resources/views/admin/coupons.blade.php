@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" type="text/css"
          href="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.css"/>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('page-title', 'Coupons')


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
                           href="{{ route('admin.products.coupons') }}">{{ __('Coupons') }}</a>
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

                <div class="btn-group addCouponBtn">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <i class="fas fa-cart-plus"></i> New coupon
                    </button>
                    <div class="dropdown-menu">
                        <a href="#!" class="dropdown-item" data-toggle="modal" data-target="#addCouponPercentModal">
                            <span class="font-weight-bold"> Percent discount</span> (&percnt;)
                        </a>
                        <a href="#!" class="dropdown-item" data-toggle="modal" data-target="#addCouponFixedModal">
                            <span class="font-weight-bold"> Fixed discount</span> (&euro;)
                        </a>
                    </div>
                </div>


                {{-- Submit bulk delete --}}
                <button class="btn btn-danger btn-sm ml-1 bulkDeleteBtn"
                        onclick="deleteCoupons()"
                        style=" float: right
                "
                        data-url="{{ route('admin.products.coupons.deleteCoupons') }}">
                    <i class="fas fa-trash"></i> Delete
                </button>

                <a href="{{ route('admin.products.coupons') }}" class="btn btn-outline-secondary btn-sm ml-1"
                   style="float: right">
                    <i class="fas fa-redo-alt"></i> Refresh
                </a>
            </div>
            <div class="table table-responsive">
                <table class="display" id="dataTableCoupons" width="100%"
                       cellspacing="0">
                    <thead>
                    <tr>
                        <th width="12px !important">
                            #
                            <input type="checkbox" id="master"/>
                        </th>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Percent off</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if($coupons)
                        @foreach($coupons as $coupon)

                            <tr class="row-coupon sub_chk" data-id="{{ $coupon->id }}">
                                <td>
                                    <input type="checkbox" class="sub_chk" data-id="{{$coupon->id}}">
                                </td>
                                <td><span class="">{{ $coupon->id }}</span></td>
                                <td>
                                    <strong>{{ $coupon->code }}</strong>
                                <td>
                                    {{ $coupon->type }}
                                </td>
                                <td>
                                    <strong>{{ $coupon->value }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $coupon->percent_off }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-secondary small">
                                         {{ $coupon->created_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-secondary small">
                                         {{ $coupon->updated_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-inline-flex">
                                        @if(auth()->user()->is_admin)
                                            <div class="px-1">
                                                <button type="button" onclick="deleteCoupon('{{ $coupon->id }}')"
                                                        class="btn btn-danger deleteBtn"
                                                        data-url="{{ route('admin.products.coupons.destroy', $coupon->id) }}">
                                                    Delete
                                                </button>
                                            </div>

                                            <div class="px-1">
                                                <a href="{{ route("admin.products.coupons.edit", $coupon->id) }}"
                                                   id="editcoupon"
                                                   class="btn btn-primary editBtn" data-id="{{ $coupon->id }}">
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

@include('admin.coupons.add_percent_coupon')
@include('admin.coupons.add_fixed_coupon')

@section('script')
    <script src="{{ asset('/js/admin/coupons/functions.js') }}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('/js/demo/datatables-demo.js') }}"></script>
@endsection