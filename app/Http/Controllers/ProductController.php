<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){

        if (request()->categorie) {
            $produits = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->categorie);
            })->orderBy('created_at', 'DESC')->paginate(6);
        } else {
            $produits = Product::with('categories')->orderBy('created_at', 'DESC')->paginate(6);
        }

        return view('products.index')->with('produits', $produits);
    }

    public function details($slug)
    {
        $produit = Product::where('slug', $slug)->firstOrFail();
        return view('products.details')->with('produit', $produit);
    }

    public function search()
    {
        request()->validate([
            'q' => 'required|min:3'
        ]);

        $q = request()->input('q');

        $produits = Product::where('titre', 'like', "%$q%")
                ->orWhere('description', 'like', "%$q%")
                ->paginate(6);

        return view('products.search')->with('produits', $produits);
    }
}
