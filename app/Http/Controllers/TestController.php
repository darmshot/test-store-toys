<?php

namespace App\Http\Controllers;


use App\Mail\OrderCreateAdmin;
use App\Models\Admin\CatalogProduct;
use App\Models\CatalogCategory;
use App\Services\CatalogProductLoaderImagesService;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function startTestOne()
    {

//        $load = app(CatalogProductLoaderImagesService::class);
//
//        $nextPart = 100;
//        while ($nextPart) {
//            dump($nextPart);
//            $nextPart = $load->load($nextPart);
//        }


        return __METHOD__;
    }

    public function mail()
    {
//        $to_name  = 'customer-darmshot';
//        $to_email = 'darmshot@gmail.com';
//        $data     = array('name' => "Ogbonna Vitalis(sender_name)", 'body' => 'A test mail');
//
//        Mail::send('emails.test', $data, function ($message) use ($to_name, $to_email) {
//            $message->to($to_email, $to_name)
//                    ->subject('Laravel Test Mail');
//            $message->from('info@toys.indigital.tk', 'Test Mail');
//        });

        Mail::to('darmshot@gmail.com')->send(new OrderCreateAdmin(array()));


        return __METHOD__;
    }

    public function nested()
    {
        $d = CatalogCategory::select('id')->descendantsAndSelf(7)->pluck('id')->all();

        dd($d);
    }
}
