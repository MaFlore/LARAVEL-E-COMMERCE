<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {

        return view('cart.index');
    }

    public function ajouter(Request $request)
    {
        $duplicata = Cart::search(function ($cartItem, $rowId) use($request) {
            return $cartItem->id == $request->produit_id;
        });

        if($duplicata->isNotEmpty()){
            return redirect()->route('products.index')->with('success', 'Le produit a bien été ajouté !');
        }

        $produit = Product::find($request->produit_id);

        Cart::add($produit->id, $produit->titre, 1, $produit->prix)
            ->associate('App\Models\Product');

        return redirect()->route('products.index')->with('success', 'Le produit a bien été ajouté !');
    }

    public function update(Request $request, $rowId){

        $donnees = $request->json()->all();

        Cart::update($rowId, $donnees['qty']);

        Session::flash('success', 'La quantité du produit est passée à '.$donnees['qty'].'.');

        return response()->json(['success'=>'Cart Quantity Has Been Updated']);
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);

        return back()->with('success', 'Le produit a été supprimé.');
    }
}
