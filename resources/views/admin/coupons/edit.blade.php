@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
@endsection
@section('page-title', 'Edit coupon')

@section('content')

    <form method="POST" action="" id="editCouponForm" enctype="multipart/form-data"
          data-url="{{ route('admin.products.coupons.update', $coupon->id) }}">
        @method('PUT')
        @csrf

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item"><a
                            href="{{ route('admin.products') }}">{{ __('Products') }}</a></li>
                <li class="breadcrumb-item"><a
                            href="{{ route('admin.products.coupons') }}">{{ __('Coupons') }}</a></li>
                <li class="breadcrumb-item">
                    Coupon: <a id="breadcrumb-link" class="font-weight-bold"
                               href="#!">{{ $coupon->code }}</a>
                </li>
            </ol>
        </nav>

        <div class="row">

            {{--? Left side --}}
            <div class="col-md-8">

                <div class="form-group">
                    <label for="code" class="col-form-label text-md-left">{{ __('Code') }}</label>
                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror"
                           name="code" required autocomplete="code" autofocus onkeyup="generateCode()"
                           value="{{ old('code', $coupon->code) }}">
                    @error('code')
                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type" class="col-form-label text-md-left">{{ __('Type') }}</label>
                    <select class="form-control" name="type" id="type">
                        <option value="percent"
                                @if($coupon->type == 'percent') selected @endif>{{ __('Percent') }}</option>
                        <option value="fixed"
                                @if($coupon->type == 'fixed') selected @endif>{{ __('Fixed') }}</option>
                    </select>
                </div>

            </div>

            {{--? Right side --}}
            <div class="col-md-4">

                <div class="form-group" id="fixed_div" @if(is_null($coupon->value)) style="display:none" @endif>
                    <label for="value" class="col-form-label text-md-left">{{ __('Discount') }}
                        <small><strong>(fixed)</strong></small></label>
                    <input id="value" type="number" class="form-control @error('value') is-invalid @enderror"
                           name="value" autocomplete="value" autofocus placeholder=""
                           value="{{ old('fixed', $coupon->value) }}" min="1">
                    @error('fixed')
                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group" id="percent_div"
                     @if(is_null($coupon->percent_off)) style="display:none" @endif>
                    <label for="percent_off" class="col-form-label text-md-left">{{ __('Discount') }}
                        <small><strong>(percent)</strong></small></label>
                    <input id="percent_off" type="number"
                           class="form-control @error('percent_off') is-invalid @enderror"
                           name="percent_off" autocomplete="value" autofocus placeholder=""
                           value="{{ old('percent_off', $coupon->percent_off) }}" min="1" max="100">
                    @error('percent_off')
                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="form-group mb-5 mt-4 float-right">
                    <div class="col-md">
                        <button type="submit" class="btn btn-primary btn-md">
                            <i class="fas fa-save"></i> {{ __('Save') }}
                        </button>
                        <a href="{{ route('admin.products.coupons') }}" type="button"
                           class="btn btn-secondary btn-md">
                            <i class="fas fa-angle-left"></i> {{ __('Return back') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ asset('/js/admin/coupons/functions.js') }}"></script>
@endsection
