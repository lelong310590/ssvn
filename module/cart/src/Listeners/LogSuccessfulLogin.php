<?php

namespace Cart\Listeners;

use Cart\Models\Order;
use Cart\Models\OrderDetail;
use Course\Models\Course;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;

        Cart::restore($user->email);
        foreach (Cart::content() as $item) {
            $course = Course::find($item->id);
            if ($course->checkBought()) {
                Cart::remove($item->rowId);
            }
        }
        Cart::store(\Auth::user()->email);
    }
}
