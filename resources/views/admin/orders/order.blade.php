@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
@endsection
@section('page-title', 'View order: #'.$order->id)

@section('content')

    <form method="POST" id="editOrderForm" data-url="{{ route('admin.products.orders.updateOrder', $order->id) }}">
        @method('PUT')
        @csrf

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">{{ __('Products') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.orders') }}">{{ __('Orders') }}</a></li>
                <li class="breadcrumb-item">
                    Order ID: <a id="breadcrumb-link" class="font-weight-bold text-gray-700"
                                 href="#!"
                                 data-app-url="{{ env('APP_URL') }}" target="_blank"
                    >#{{ $order->id }}</a>
                </li>
            </ol>
        </nav>

        <div class="row">

            {{--? Left side --}}
            <div class="col-md-8">

                @if($order->error)
                    <div class="form-group">
                        <label for="error"
                               class="col-form-label text-md-left text-danger">{{ __('Error message') }}</label>
                        <textarea id="error" type="text"
                                  class="form-control border-left-danger text-danger bg-white"
                                  name="id" required autocomplete="id" autofocus
                                  disabled>{{ old('error', $order->error) }}</textarea>
                    </div>
                @endif


                <div class="form-group">
                    <label for="id" class="col-form-label text-md-left">{{ __('Order ID') }}</label>
                    <input id="id" type="text" class="form-control border-left-primary bg-white"
                           name="id" required autocomplete="id" autofocus
                           value="{{ old('id', $order->id) }}" disabled>
                </div>

                <div class="form-group">
                    <label for="products" class="col-form-label text-md-left">{{ __('Ordered products:') }}</label>
                    <ul class="list-group border-left-primary">
                        @foreach($products as $orderedProduct)
                            <li class="list-group-item">
                                <a href="{{ route('shop.show', $orderedProduct->slug) }}"
                                   target="blank">
                                    <img src="{{ $orderedProduct->productImage() }}" class="img-cover"
                                         alt="{{$orderedProduct->image}}"
                                         width="60" height="60"></a>

                                <span class="text-dark"> SKU #{{ $orderedProduct->id }}:</span>
                                <a href="{{ route('shop.show', $orderedProduct->slug) }}"
                                   target="blank">
                                    <span class="text-primary">{{ $orderedProduct->name }}</span></a>
                                <span class="small">({{ $orderedProduct->quantity }}) items left</span>
                                <p><small>{{ $orderedProduct->details }}</small></p>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="form-group">
                    <label for="billing_email"
                           class="col-form-label text-md-left">{{ __('Billing Email') }}</label>
                    <input id="billing_email" type="text"
                           class="form-control border-left-primary bg-white"
                           name="billing_email" required autocomplete="details" autofocus
                           value="{{ old('email', $order->billing_email) }}" disabled>
                </div>

                <div class="form-group">
                    <label for="billing_address"
                           class="col-form-label text-md-left">{{ __('Address') }}</label>
                    <input id="billing_address" type="text"
                           class="form-control border-left-primary bg-white"
                           name="billing_address" required autocomplete="billing_address" autofocus
                           value="{{ old('billing_address', $order->billing_address) }}" disabled>
                </div>

                <div class="form-group">
                    <label for="name" class="col-form-label text-md-left">{{ __('Billing City') }}</label>
                    <input id="billing_city" type="text"
                           class="form-control border-left-primary bg-white"
                           name="billing_city" required autocomplete="details" autofocus
                           value="{{ old('billing_city', $order->billing_city) }}" disabled>

                </div>

                <div class="form-group">
                    <label for="billing_province"
                           class="col-form-label text-md-left">{{ __('Billing Province') }}</label>
                    <input id="billing_province" type="text"
                           class="form-control border-left-primary bg-white"
                           name="billing_province" required autocomplete="billing_province" autofocus
                           value="{{ old('billing_province', $order->billing_province) }}" disabled>
                </div>

                <div class="form-group">
                    <label for="billing_postalcode" class="col-form-label text-md-left">{{ __('Postal code') }}</label>
                    <input id="billing_postalcode" type="text"
                           class="form-control border-left-primary bg-white"
                           name="billing_postalcode" required autocomplete="billing_postalcode" autofocus
                           value="{{ old('billing_postalcode', $order->billing_postalcode) }}" disabled>
                </div>

                <div class="form-group">
                    <label for="billing_phone" class="col-form-label text-md-left">{{ __('Billing Phone') }}</label>
                    <input id="billing_phone" type="text"
                           class="form-control border-left-primary bg-white"
                           name="billing_phone" required autocomplete="billing_phone" autofocus
                           value="{{ old('billing_phone', $order->billing_phone) }}" disabled>
                </div>

            </div>

            {{--? Right side --}}
            <div class="col-md-4">

                <div class="form-group">
                    <label for="billing_name_on_card"
                           class="col-form-label text-md-left">{{ __('Billing on Card') }}</label>
                    <input id="billing_name_on_card" type="text"
                           class="form-control border-left-primary bg-white"
                           name="billing_name_on_card" required autocomplete="billing_name_on_card" autofocus
                           value="{{ old('billing_name_on_card', $order->billing_name_on_card) }}" disabled>
                </div>

                <div class="form-group">
                    <label for="billing_discount"
                           class="col-form-label text-md-left">{{ __('Billing discount') }}</label>
                    <input id="billing_discount" type="text"
                           class="form-control border-left-primary bg-white"
                           name="billing_discount" required autocomplete="billing_discount" autofocus
                           value="{{ old('billing_discount', $order->billing_discount) }}" disabled>
                </div>

                <div class="form-group">
                    <label for="billing_discount_code"
                           class="col-form-label text-md-left">{{ __('Billing discount code') }}</label>
                    <input id="billing_discount_code" type="text"
                           class="form-control border-left-primary bg-white"
                           name="billing_discount_code" required autocomplete="billing_discount_code" autofocus
                           value="{{ old('billing_discount_code', $order->billing_discount_code) }}" disabled>
                </div>

                <div class="form-group">
                    <label for="billing_subtotal"
                           class="col-form-label text-md-left">{{ __('Billing price (no tax)') }}</label>
                    <input id="billing_subtotal" type="text"
                           class="form-control border-left-primary bg-white"
                           name="billing_subtotal" required autocomplete="billing_subtotal" autofocus
                           value="{{ old('billing_subtotal', $order->billing_subtotal) }}" disabled>
                </div>

                <div class="form-group">
                    <label for="billing_tax"
                           class="col-form-label text-md-left">{{ __('Billing tax (21%)') }}</label>
                    <input id="billing_tax" type="text"
                           class="form-control border-left-primary bg-white"
                           name="billing_tax" required autocomplete="billing_tax" autofocus
                           value="{{ old('billing_tax', $order->billing_tax) }}" disabled>
                </div>

                <div class="form-group">
                    <label for="billing_total"
                           class="col-form-label text-md-left">{{ __('Billing price (with tax)') }}</label>
                    <input id="billing_total" type="text"
                           class="form-control border-left-primary bg-white"
                           name="billing_total" required autocomplete="billing_total" autofocus
                           value="{{ old('billing_total', $order->billing_total) }}" disabled>
                </div>

                <div class="form-group">
                    <label for="shipped"
                           class="col-form-label text-md-left @if($order->error) text-danger @endif">{{ __('Ship status') }}</label>
                    <select
                            class="form-control
                            @if($order->shipped == 1) border-success text-success font-weight-700
                            @elseif($order->error) border-danger font-weight-700
                            @else border-warning text-warning font-weight-700 @endif"
                            name="shipped" id="shipped">
                        @if(!$order->error)
                            <option value="1" @if($order->shipped == 1) selected @endif>{{ __('Shipped') }}</option>
                            <option value="0" @if($order->shipped == 0) selected @endif>{{ __('No shipped') }}
                            </option>
                        @else
                            <option value="">{{ __('Failed') }}</option>
                        @endif
                    </select>
                </div>

                <div class="form-group mb-5 mt-4 float-right">
                    <div class="col-md">
                        @if(!$order->error)
                            <button type="submit" class="btn btn-primary btn-md">
                                <i class="fas fa-save"></i> {{ __('Save') }}
                            </button>
                        @endif
                        <a href="{{ route('admin.products.orders') }}" type="button" class="btn btn-secondary btn-md">
                            <i class="fas fa-angle-left"></i> {{ __('Return back') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ asset('/js/admin/orders/functions.js') }}"></script>
@endsection
