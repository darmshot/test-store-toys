<?php


namespace App\View\Composers;


use Illuminate\View\View;

class DocumentVarsComposer
{
    public function __construct()
    {
        // Dependencies are automatically resolved by the service container...
    }

    public function compose(View $view)
    {
        if (str_contains(($_SERVER['HTTP_ACCEPT'] ?? ''), 'image/webp')) {
            \Document::addMetas('webp');
        }


        if ( ! empty($_SERVER['HTTP_CART_SESSION'])) {
            \Document::addMetas('cart-session', $_SERVER['HTTP_CART_SESSION']);
        } else {
            $cartSession = session('cart_session', function () {
                $newKey = md5(time() . rand(0, 1000));

                session(['cart_session' => $newKey]);

                return $newKey;
            });

            \Document::addMetas('cart-session', $cartSession);
        }

//        $view->with('count', $this->users->count());
    }
}
