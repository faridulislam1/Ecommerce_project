<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public static  $subcategories,$category;
    public function index(){
        return view('admin.sub-category.index',['categories'=>Category::all()]);

    }
    public function store(){
        self::$subcategories=SubCategory::all();
        return view('admin.sub-category.manage',[
            'sub_categories'=>self::$subcategories
        ]);

    }

    public function create(Request $request){

        SubCategory::newSubCategory($request);
        return back()->with('message', 'Sub Category Info Create successfully');

    }

    public function destroy(Request $request){
        SubCategory::destroy($request->id);
        return back()->with('message', 'Info deleted');

    }
    public function edit($id){
//        self::$subcategories=SubCategory::find($id);
        return view('admin.sub-category.edit',[
            'categories'=>Category::all(),
            'sub_category'=> SubCategory::find($id)
        ]);

    }
    public function updates(Request $request){
        SubCategory::updates($request);
        return back()->with('message', ' Sub category Info updated');
    }
}
