@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" type="text/css"
          href="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.css"/>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('page-title', 'Orders')


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
                        <a class="font-weight-bold text-gray-700"
                           href="{{ route('admin.products.orders') }}">{{ __('Orders') }}</a>
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

                <button class="btn btn-success btn-sm ml-1 bulkShipOrdersBtn"
                        onclick="shipOrders()"
                        style=" float: right
                "
                        data-url="{{ route('admin.products.orders.shipOrders') }}">
                    <i class="fas fa-shipping-fast"></i> Ship order(s)
                </button>

                <button class="btn btn-danger btn-sm ml-1 bulkDeleteOrdersBtn"
                        onclick="deleteOrders()"
                        style=" float: right
                "
                        data-url="{{ route('admin.products.orders.deleteOrders') }}">
                    <i class="fas fa-minus-circle"></i> Delete
                </button>

                <a href="{{ route('admin.products.orders') }}" class="btn btn-outline-secondary btn-sm ml-1"
                   style="float: right">
                    <i class="fas fa-redo-alt"></i> Refresh
                </a>
            </div>
            <div class="table table-responsive">
                <table class="display" id="dataTableOrders" width="100%"
                       cellspacing="0">
                    <thead>
                    <tr>
                        <th width="12px !important">
                            #
                            <input type="checkbox" id="master"/>
                        </th>
                        <th class="small font-weight-bold text-gray-700">ID</th>
                        <th class="small font-weight-bold text-gray-700">Ordered products</th>
                        <th class="small font-weight-bold text-gray-700">Name</th>
                        <th class="small font-weight-bold text-gray-700">E-mail</th>
                        <th class="small font-weight-bold text-gray-700">Address</th>
                        <th class="small font-weight-bold text-gray-700">City</th>
                        <th class="small font-weight-bold text-gray-700">Province</th>
                        <th class="small font-weight-bold text-gray-700">Postal code</th>
                        <th class="small font-weight-bold text-gray-700">Phone</th>
                        <th class="small font-weight-bold text-gray-700">Name on Card</th>
                        <th class="small font-weight-bold text-gray-700">Discount</th>
                        <th class="small font-weight-bold text-gray-700">Discount code</th>
                        <th class="small font-weight-bold text-gray-700">Price(no tax)</th>
                        <th class="small font-weight-bold text-gray-700">Tax</th>
                        <th class="small font-weight-bold text-gray-700">Price(with tax)</th>
                        <th class="small font-weight-bold text-gray-700">Payment Gateway</th>
                        <th class="small font-weight-bold text-gray-700">Shipped</th>
                        <th class="small font-weight-bold text-gray-700">Error</th>
                        <th class="small font-weight-bold text-gray-700">Created</th>
                        <th class="small font-weight-bold text-gray-700">Updated</th>
                        <th class="small font-weight-bold text-gray-700">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if($orders)
                        @foreach($orders as $order)

                            <tr class="row-order sub_chk" data-id="{{ $order->id }}">
                                <td>
                                    <input type="checkbox" class="sub_chk" data-id="{{$order->id}}">
                                </td>
                                <td>
                                    <span class="IdBadge badge badge-pill
                                    @if($order->error) badge-danger
                                    @elseif($order->shipped == 1) badge-success
                                    @else($order->shipped == 0) badge-warning text-dark
                                    @endif">{{ $order->id }}</span>
                                </td>
                                <td>
                                    @foreach($order->products as $orderedProduct)
                                        <a href="{{ route('shop.show', $orderedProduct->slug) }}" target="_blank"
                                           class="small"
                                        ><strong>{{ '['. $orderedProduct->name . '], '}}</strong></a>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route("admin.products.orders.show", $order->id) }}"
                                       class="small"
                                    ><strong>{{ $order->billing_name }}</strong></a>
                                </td>
                                <td class="font-weight-bold small">
                                    <a href="mailto:{{ $order->billing_email }}"
                                       class="text-dark">{{ $order->billing_email }}</a>
                                </td>
                                <td class="font-weight-bold small">
                                    <span class="text-dark">{{ $order->billing_address }}</span>
                                </td>
                                <td class="font-weight-bold small">
                                    <span class="text-dark">{{ $order->billing_city }}</span>
                                </td>
                                <td class="font-weight-bold small">
                                    <span class="text-dark">{{ $order->billing_province }}</span>
                                </td>
                                <td class="font-weight-bold small">
                                    <span class="text-dark">{{ $order->billing_postalcode }}</span>
                                </td>
                                <td class="font-weight-bold small">
                                    <a href="tel:{{ $order->billing_phone }}"
                                       class="text-dark">{{ $order->billing_phone }}</a>
                                </td>
                                <td class="font-weight-bold small">
                                    <span class="text-dark">{{ $order->billing_name_on_card }}</span>
                                </td>
                                <td class="font-weight-bold small">
                                    <span class="text-dark">{{ $order->presentPrice($order->billing_discount) }} &euro;</span>
                                </td>
                                <td class="font-weight-bold small">
                                    <span class="text-dark">{{ $order->billing_discount_code }}</span>
                                </td>
                                <td class="font-weight-bold small">
                                    <span class="text-dark">{{ $order->presentPrice($order->billing_subtotal)}} &euro;</span>
                                </td>
                                <td class="font-weight-bold small">
                                    <span class="text-dark">{{ $order->presentPrice($order->billing_tax)}} &euro;</span>
                                </td>
                                <td class="font-weight-bold small">
                                    <span class="text-dark">{{ $order->presentPrice($order->billing_total) }} &euro;</span>
                                </td>
                                <td class="font-weight-bold">
                                    <span class="badge badge-pill badge-primary rounded">{{ $order->payment_gateway }}</span>
                                </td>
                                <td class="font-weight-bold">
                                    @if($order->error)
                                        <span
                                                class="badge badge-pill badge-danger rounded failedBadge">{{ __('Failed') }}</span>
                                    @else
                                        @switch($order->shipped)
                                            @case("1")
                                            <span
                                                    class="badge badge-pill badge-success rounded shippedBadge">{{ __('Shipped') }}</span>
                                            @break
                                            @case("0")
                                            <span
                                                    class="badge badge-pill badge-warning rounded text-dark noShippedBadge">{{ __('No shipped') }}</span>
                                            @break
                                            @default("0")
                                        @endswitch
                                    @endif
                                </td>
                                <td class="font-weight-bold small">
                                    <span class="text-danger">{{ $order->error }}</span>
                                </td>
                                <td>
                                    <span class="small text-dark font-weight-bold">
                                         {{ $order->created_at->format('m.d.Y H:m:s') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="small text-dark font-weight-bold">
                                        {{ $order->updated_at->format('m.d.Y H:m:s') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-inline-flex">
                                        @if(auth()->user()->is_admin)
                                            @if($order->shipped !== 1)
                                                @if(!$order->error)
                                                    <div class="px-1">
                                                        <button type="button" onclick="shipOrder('{{ $order->id }}')"
                                                                class="btn btn-success btn-sm shipOrderBtn">
                                                            <span class="font-weight-bold">Ship</span>
                                                        </button>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif

                                        <div class="px-1">
                                            <a href="{{ route("admin.products.orders.show", $order->id) }}"
                                               id="editorder"
                                               class="btn btn-primary btn-sm viewOrderBtn"
                                               data-id="{{ $order->id }}">
                                                <span class="font-weight-bold">View</span>
                                            </a>
                                        </div>
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


@section('script')
    <script src="{{ asset('/js/admin/orders/functions.js') }}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('/js/demo/datatables-demo.js') }}"></script>
@endsection



