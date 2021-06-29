<?php

namespace Base\Mail;

use Cart\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Users\Models\Users;

class CheckoutSuccess extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Users $user, Order $order)
    {
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Hóa đơn ' . $this->order->getOrderCode() . ' được xác nhận thành công!')->view('nqadmin-dashboard::mail.content.checkout.success');
    }
}
