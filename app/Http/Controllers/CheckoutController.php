<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $page = (object) array(
            'title' => 'Оформить заказ'
        );

        \Document::setTitle($page->title);

        return view('checkout.index', compact('page'));
    }

    public function confirm(Request $request, OrderService $orderService)
    {
        if ( ! empty($_SERVER['HTTP_CART_SESSION'])) {
            \Cart::session($_SERVER['HTTP_CART_SESSION']);
        } else {
            abort(400);
        }

        $orderService->make([
            'products' => \Cart::getContent(),
            'customer' => $request->all()
        ]);


        return response()->json([
            'success' => true
        ]);
    }

    public function success()
    {
        $page = (object) array(
            'title' => 'Заказ оформлен'
        );

        \Document::setTitle($page->title);


      $cartSession =  session('cart_session');

        if ( $cartSession) {
            \Cart::session($cartSession);
        } else {
            abort(400);
        }


        \Cart::clear();

        return view('checkout.success',compact('page'));
    }
}
