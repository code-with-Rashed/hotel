<?php

namespace App\Http\Controllers;

use App\Jobs\OrderConfirmationJob;
use Illuminate\Http\Request;
use App\Models\BookingOrder;
use App\Models\BookingDetail;
use \Raziul\Sslcommerz\Facades\Sslcommerz;

class SslCommerzController extends Controller
{
    public $frontend_app_url;
    public function __construct()
    {
        $this->frontend_app_url = env('FRONTEND_APP_URL', 'http://localhost');
    }
    public function pay(Request $request)
    {
        $request->validate([
            "id" => "required|integer",
            "name" => "required|string",
            "email" => "required|email",
            "number" => "required",
            "address" => "required|string",
            "checkin" => "required|date",
            "checkout" => "required|date",
            "room_id" => "required|integer",
            "room_name" => "required|string",
            "price" => "required|integer",
            "total_day" => "required|integer",
            "total_pay" => "required|integer"
        ]);

        $tran_id = uniqid();
        $response = Sslcommerz::setOrder($request->total_pay, $tran_id, $request->room_name)
            ->setCustomer($request->name, $request->email, $request->number)
            ->setShippingInfo(0, '')
            ->makePayment();

        if ($response->success()) {
            // booking save order
            $booking_order = new BookingOrder();
            $booking_order->room_id = $request->room_id;
            $booking_order->user_id = $request->id;
            $booking_order->checkin = $request->checkin;
            $booking_order->checkout = $request->checkout;
            $booking_order->tran_id = $tran_id;
            $booking_order->tran_status = 'PENDING';
            $booking_order->amount = $request->total_pay;
            $booking_order->currency = env('SSLC_STORE_CURRENCY', 'BDT');
            $booking_order->save();
            $lastInsertedId = $booking_order->id;

            // save booking details
            $booking_detais = new BookingDetail();
            $booking_detais->booking_order_id = $lastInsertedId;
            $booking_detais->room_name = $request->room_name;
            $booking_detais->price = $request->price;
            $booking_detais->total_pay = $request->total_pay;
            $booking_detais->room_no = rand(1,20);
            $booking_detais->user_name = $request->name;
            $booking_detais->phone = $request->number;
            $booking_detais->email = $request->email;
            $booking_detais->address = $request->address;
            $booking_detais->save();

            // payment initiate
            return redirect($response->gatewayPageURL());
        } else {
            return redirect($this->frontend_app_url . '/booking/status?s=failure');
        }
    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $bank_tran_id = $request->input('bank_tran_id');
        $status = $request->input('status');
        $booking_order = BookingOrder::select('id', 'tran_id', 'tran_status', 'currency', 'amount')->where('tran_id', $tran_id)->first();
        if ($booking_order->tran_status == 'PENDING') {
            $isValid = Sslcommerz::validatePayment($request->all(), $tran_id, $booking_order->amount);
            if ($isValid) {
                $update_booking_order = BookingOrder::find($booking_order->id);
                $update_booking_order->booking_status = 'booked';
                $update_booking_order->tran_status = $status;
                $update_booking_order->bank_tran_id = $bank_tran_id;
                $update_booking_order->save();
                dispatch(new OrderConfirmationJob($booking_order->id)); // run queue job for order confirmation email
            }
            return redirect($this->frontend_app_url . '/booking/status?s=success');
        } else if ($booking_order->tran_status == 'VALID') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            return redirect($this->frontend_app_url . '/booking/status?s=success');
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            return redirect($this->frontend_app_url . '/booking/status?s=failure');
        }
    }

    public function failure(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $status = $request->input('status');
        $booking_order = BookingOrder::select('id', 'tran_status')->where('tran_id', $tran_id)->first();
        if ($booking_order->tran_status == 'PENDING') {
            $update_booking_order = BookingOrder::find($booking_order->id);
            $update_booking_order->tran_status = $status;
            $update_booking_order->save();
            return redirect($this->frontend_app_url . '/booking/status?s=failure');
        } else if ($booking_order->tran_status == 'VALID') {
            return redirect($this->frontend_app_url . '/booking/status?s=success');
        } else {
            return redirect($this->frontend_app_url . '/booking/status?s=failure');
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $status = $request->input('status');
        $booking_order = BookingOrder::select('id', 'tran_status')->where('tran_id', $tran_id)->first();
        if ($booking_order->tran_status == 'PENDING') {
            $update_booking_order = BookingOrder::find($booking_order->id);
            $update_booking_order->tran_status = $status;
            $update_booking_order->save();
            return redirect($this->frontend_app_url . '/booking/status?s=cancel');
        } else if ($booking_order->tran_status == 'VALID') {
            return redirect($this->frontend_app_url . '/booking/status?s=success');
        } else {
            return redirect($this->frontend_app_url . '/booking/status?s=failure');
        }
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {
            $tran_id = $request->input('tran_id');
            $bank_tran_id = $request->input('bank_tran_id');
            $status = $request->input('status');
            $booking_order = BookingOrder::select('id', 'tran_id', 'tran_status', 'amount')->where('tran_id', $tran_id)->first();
            if ($booking_order->tran_status == 'PENDING') {

                $isValid = Sslcommerz::validatePayment($request->all(), $tran_id, $booking_order->amount);

                if ($isValid) {
                    $update_booking_order = BookingOrder::find($booking_order->id);
                    $update_booking_order->booking_status = 'booked';
                    $update_booking_order->tran_status = $status;
                    $update_booking_order->bank_tran_id = $bank_tran_id;
                    $update_booking_order->save();
                }
            }
        }
    }
}
