<?php

namespace App\Http\Controllers;

use App\Models\Order;
use DateTime;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Stripe\PaymentIntent;

class CaisseController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if (Cart::count() <= 0){
            return redirect()->route('products.index');
        }

        Stripe::setApiKey('sk_test_51KlTNFDqbyJ3QlcEy8hJYVYhjPpiMhNzDxjh2pPccWY1fVNAYNCVQefj8zOfdi6SyNk6ndeA4EOfoFY8rixPgTAL00sp3qV212');

        $intent = PaymentIntent::create([
                'amount' => round(Cart::total()),
                'currency' => 'eur',
                // 'metadata' =>[
                //     'userId'=> Auth::user()->id
                // ]
        ]);

        $clientSecret = Arr::get($intent, 'client_secret');

        return view('caisse.index',
            [
                'clientSecret' => $clientSecret
            ]);
    }

    public function enregistrer(Request $request)
    {

        $donnees = $request->json()->all();
        $order = new Order();
        $order -> payment_intent_id = $donnees['paymentIntent']['id'];
        $order -> montant = $donnees['paymentIntent']['amount'];

        $order -> date_creation_payement = (new DateTime())
                ->setTimestamp($donnees['paymentIntent']['created'])
                ->format('Y-m-d H:i:s');

        $products = [];
        $i = 0;
        foreach(Cart::content() as $product)
        {
            $products['product_' . $i][] = $product->model->titre;
            $products['product_' . $i][] = $product->model->prix;
            $products['product_' . $i][] = $product->qty;
            $i++;
        }

        $order ->products = serialize($products);
        $order->id_utilisateur = Auth()->user()->id;

        $order->save();
        if($donnees['paymentIntent']['status'] === "succeeded")
        {
            Cart::destroy();
            Session::flash('success', 'Votre demande a été traité avec succès !');
            return response()->json(['success'=>'Payment Intent Suceeded']);
        }
        else{
            return response()->json(['error'=>'Payment Intent Not Suceeded']);
        }
    }

    public function merci()
    {
        return Session::has('success') ? view('caisse.merci') : redirect()->route('products.index');
    }
}
