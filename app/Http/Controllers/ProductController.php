<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        
        if(request()->ajax()) {

            $query = Products::query();
            return DataTables::of($query)
            ->addColumn('action', function($item){

                return 
                '<a href="'. route('dashboard.product.gallery.index',$item->id) . '" class="bg-pink-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-2 rounded shadow-lg" >Gallery</a>

                <a href="'. route('dashboard.product.edit',$item->id) . '" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg" >Edit</a>
                
                <form class="inline-block" method="POST" action="'.route('dashboard.product.destroy' ,$item->id) . '">
                '. method_field('delete') . csrf_field().'
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold mx-2 py-1.5 px-3 rounded shadow-lg " type="submit">
                DELETE
                </button>
                </form>
                ';
            })->editColumn('price' , function($item){
                return number_format($item->price);
            })->rawColumns(['action'])->make();
        }
        return view('pages.dasboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dasboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $Request)
    {
        $data = $Request->all();
        $data['slug'] = Str::slug($Request->title);

        Products::create($data);

        return Redirect()->route('dashboard.product.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $product)
    {
        return view('pages.dasboard.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $Request,Products $product)
    {
        $data = $Request->all();
        $data['slug'] = Str::slug($Request->title);

        $product->update($data);

        return Redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {

        $product->delete();
        return Redirect()->route('dashboard.product.index');
    }
}
