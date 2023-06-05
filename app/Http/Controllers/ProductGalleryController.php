<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ProductsGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Products $product)
    {
         if(request()->ajax()) {

            $query = ProductsGallery::query();
            return DataTables::of($query)
            ->addColumn('action', function($item){
                return 
                '
                <form class="inline-block" method="POST" action="'.route('dashboard.product.destroy' ,$item->id) . '">
                '. method_field('delete') . csrf_field().'
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold mx-2 py-1.5 px-3 rounded shadow-lg " type="submit">
                DELETE
                </button>
                </form>
                ';
            })->editColumn('url' , function($item){
                return '.<imag style="mac-widthL:150px" src="'.Storage::url($item->url).'"> </img>';

            })->editColumn('is_featured' , function($item){
                return $item->is_featured ? 'Yes' : 'No';
            })->rawColumns(['action'])
            ->make();
        }
        return view('pages.dasboard.gallery.index',compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
