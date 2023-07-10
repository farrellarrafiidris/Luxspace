<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $products = Products::with(['gallery'])->latest()->get();
        return view('pages.frontend.index',compact('products'));
    }

    public function details(Request $request, $slug)
    {
        $products = Products::with(['gallery'])->where('slug', $slug)->firstOrFail();
        $recommendations =  Products::with(['gallery'])->inRandomOrder()->limit(4)->get();
        return view('pages.frontend.details' ,compact('products','recommendations'));
    }

    public function cartAdd(Request $request,$id)
    {
        Carts::create([
            'user_id' => Auth::user()->id,
            'product_id' => $id,
        ]);

        return redirect('cart');
    }

        public function cart(Request $request)
    {

        $carts = Carts::with(['product.gallery'])->where('user_id', Auth::user()->id )->firstOrFail();    
        return view('pages.frontend.cart' ,compact('carts'));
    }

        public function success(Request $request)
    {
        return view('pages.frontend.success');
    }
}
