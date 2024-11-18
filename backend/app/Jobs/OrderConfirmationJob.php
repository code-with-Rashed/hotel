<?php

namespace App\Jobs;

use App\Mail\OrderConfirmationEmail;
use App\Models\BookingOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OrderConfirmationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $booking_order_id;
    /**
     * Create a new job instance.
     */
    public function __construct($booking_order_id)
    {
        $this->booking_order_id = $booking_order_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $newbooking = BookingOrder::with('booking_details')->find($this->booking_order_id);
        if (!is_null($newbooking)) {
            Mail::to($newbooking->booking_details->email)->send(new OrderConfirmationEmail($newbooking));
        }
    }
}
