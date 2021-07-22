<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\CatalogProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartController extends Controller
{
    public function index(Request $request)
    {
        if ( ! empty($_SERVER['HTTP_CART_SESSION'])) {
            \Cart::session($_SERVER['HTTP_CART_SESSION']);
        } else {
            abort(400);
        }

        $items = \Cart::getContent();

        $meta = [
            'total'    => \Currency::format(\Cart::getTotal(), 'byn'),
            'quantity' => \Cart::getTotalQuantity(),
            'checkout' => route('checkout'),
            'all'      => $items
        ];


        return CartResource::collection($items)->additional(compact('meta'));
    }

    public function add(Request $request)
    {

        $request->validate([
            'product_id' => 'required'
        ]);

        if ( ! empty($_SERVER['HTTP_CART_SESSION'])) {
            $cartSession = $_SERVER['HTTP_CART_SESSION'];
        } else {
            abort(400);
        }

        $product = CatalogProduct::findOrFail($request->input('product_id'));


        $cart = \Cart::session($cartSession)->add(array(
            'id'              => $product->id,
            'name'            => $product->title,
            'price'           => $product->getPrice(),
            'quantity'        => 1,
            'attributes'      => array(),
            'associatedModel' => $product
        ));

        return response()->json([
            'success' => __('catalog.text_cart_success_add', [
                'product_url'   => $product->url,
                'product_title' => $product->title,
                'checkout_url'  => route('checkout'),
            ])
        ]);
    }

    public function remove(Request $request)
    {

        $request->validate([
            'product_id' => 'required'
        ]);

        if ( ! empty($_SERVER['HTTP_CART_SESSION'])) {
            $cartSession = $_SERVER['HTTP_CART_SESSION'];
        } else {
            abort(400);
        }
        \Cart::session($cartSession);

        $cartItem = \Cart::get($request->input('product_id'));

        if(!$cartItem){
            abort(400);
        }

        \Cart::remove($request->input('product_id'));

        $product = $cartItem->associatedModel;

        return response()->json([
            'success' => __('catalog.text_cart_success_remove', [
                'product_url'   => $product->url,
                'product_title' => $product->title,
                'checkout_url'  => route('checkout'),
            ])
        ]);
    }
}
