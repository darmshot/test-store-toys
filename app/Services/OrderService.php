<?php


namespace App\Services;


use App\Mail\OrderCreateAdmin;
use App\Mail\OrderCreateCustomer;
use Illuminate\Support\Facades\Mail;

class OrderService
{


    public function make($order)
    {
        try {
            Mail::to('darmshot@gmail.com')->send(new OrderCreateAdmin($order));

        } catch (\Exception $exception) {
            error_log($exception);
        }
//        Mail::to($inputs['email'])->send(new OrderShipped($order));


    }

    private function sendMail()
    {

    }
}
