<div class="modal animated--fade-in" id="addCouponFixedModal" tabindex="-1" aria-labelledby="addCouponFixedModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCouponFixedModalLabel">Creating new coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" action="" id="addCouponFixedForm" enctype="multipart/form-data"
                      data-url="{{ route('admin.products.coupons.addFixedDiscount') }}">
                    @csrf
                    @method('POST')

                    <div class="form-group row">
                        <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Code') }}</label>
                        <div class="col-md-6">
                            <input id="code" type="text"
                                   class="form-control"
                                   name="code" value="{{ old('code') }}" required autocomplete="code"
                                   autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="value"
                               class="col-md-4 col-form-label text-md-right">{{ __('Discount') }}</label>
                        <div class="col-md-6">
                            <input id="value" type="text"
                                   class="form-control"
                                   name="value" value="{{ old('value') }}" required autocomplete="value"
                                   autofocus>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary" id="addFixedCoupon">
                                {{ __('Add') }}
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                {{ __('Close') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




