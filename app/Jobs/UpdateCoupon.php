<?php

namespace App\Jobs;

use App\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCoupon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $coupon;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon; // model
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (Cart::currentInstance() === 'default') {
            session()->put('coupon', [
                'name' => $this->coupon->code, // setting session for cupon name: session()->get('coupon')['name']
                'discount' => $this->coupon->discount(Cart::subtotal()), // setting session for cupon discount. session()->get('coupon')['discount']
            ]);
        }
    }
}
