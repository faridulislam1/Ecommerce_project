<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    private static $brand,$brands;
    public function index()
    {
        return view('admin.brand.index');

    }

    public function store()
    {
        self::$brands = Brand::all();
        return view('admin.brand.manage', [
            'brands' => self::$brands
        ]);

    }
    public function create(Request $request)
    {

        Brand::newBrand($request);
        return back()->with('message', 'Brand Info Create successfully');

    }
    public function destroy(Request $request)
    {
        Brand::destroy($request->id);
        return back()->with('message', ' Brand Info deleted');

    }
    public function edit($id)
    {
        self::$brand = Brand::find($id);
        return view('admin.brand.edit', [
            'brand' => self::$brand
        ]);

    }

    public function updates(Request $request)
    {
        Brand::updates($request);
        return back()->with('message', 'Brand Info updated');


    }
}
