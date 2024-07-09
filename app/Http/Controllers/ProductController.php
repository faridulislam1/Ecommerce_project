<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\otherImage;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
//    public  static $products, $product;
//
//    public function index()
//    {
//        return view('admin.product.index',[
//            'categories'=>Category::all(),
//            'Sub_categories'=>SubCategory::all(),
//            'brands'=>Brand::all(),
//            'units'=>Unit::all(),
//        ]);
//
//    }
//    public function getSubCategoryByCategory(){
//        return response()->json( SubCategory::where('category_id', $_GET['id'])->get());
//    }
//    public function store()
//    {
//        self::$products = Product::all();
//        return view('admin.product.manage', [
//            'products' => self::$products
//        ]);
//
//    }
//
//    public function detail($id)
//    {
//        self::$products = Product::find($id);
//        return view('admin.product.detail', [
//            'product' => self::$products
//        ]);
//
//    }
//    public function create(Request $request)
//    {
//       self::$product = Product::newProduct($request);
//       otherImage::newOtherImage($request->other_image,self::$product->id);
//        return back()->with('message', 'Product Info Create successfully');
//    }
////    public function destroy(Request $request)
////    {
////        Product::destroy($request->id);
////        return back()->with('message', 'Info deleted');
////    }
//    public function edit($id)
//    {
//        self::$product = Product::find($id);
//        return view('admin.product.edit', [
//            'categories'=>Category::all(),
//            'Sub_categories'=>SubCategory::all(),
//            'brands'=>Brand::all(),
//            'units'=>Unit::all(),
//            'product' => self::$product
//        ]);
//    }
//    public function updates(Request $request, $id)
//    {
//        Product::updatedProduct($request, $id);
//        if ($request->other_image)
//        {
//            OtherImage::updateOtherImage($request->other_image, $id);
//        }
//        return redirect('/product/manage')->with('message', 'Product info update successfully.');
//    }
//
//    public function destroy($id)
//    {
//        Product::deleteProduct($id);
//        OtherImage::deleteOtherImage($id);
//        return redirect('/product/manage')->with('message', 'Product info delete successfully.');
//    }

    private $product;

    public function index()
    {
        return view('admin.product.index', [
            'categories'        => Category::all(),
            'sub_categories'    => SubCategory::all(),
            'brands'            => Brand::all(),
            'units'             => Unit::all(),
        ]);
    }

    public function getSubCategoryByCategory()
    {

        return response()->json(SubCategory::where('category_id', $_GET['id'])->get());
    }

    public function create(Request $request)
    {
        $this->product = Product::newProduct($request);
        OtherImage::newOtherImage($request->other_image, $this->product->id);
        return back()->with('message', 'Product info create successfully.');
    }

    public function store()
    {
        return view('admin.product.manage', ['products' => Product::all()]);
    }

    public function detail($id)
    {
        return view('admin.product.detail', ['product' => Product::find($id)]);
    }

    public function edit($id)
    {
        return view('admin.product.edit', [
            'categories'        => Category::all(),
            'sub_categories'    => SubCategory::all(),
            'brands'            => Brand::all(),
            'units'             => Unit::all(),
            'product'           => Product::find($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        Product::updatedProduct($request, $id);
        if ($request->other_image)
        {
            OtherImage::updateOtherImage($request->other_image, $id);
        }
        return redirect('/product/manage')->with('message', 'Product info update successfully.');
    }

    public function delete($id)
    {
        Product::deleteProduct($id);
        OtherImage::deleteOtherImage($id);
        return redirect('/product/manage')->with('message', 'Product info delete successfully.');
    }
}
