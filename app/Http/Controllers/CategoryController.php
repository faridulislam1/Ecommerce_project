<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public static $categories, $category;

    public function index()
    {
        return view('admin.category.index');

    }
    public function store()
    {
        self::$categories = Category::all();

        return view('admin.category.manage', [
            'categories' => self::$categories
        ]);

    }
    public function create(Request $request)
    {

        Category::newCategory($request);
        return back()->with('message', 'Category Info Create successfully');
    }
    public function destroy(Request $request)
    {
        Category::destroy($request->id);
        return back()->with('message', 'Info deleted');
    }
    public function edit($id)
    {
        self::$category = Category::find($id);
        return view('admin.category.edit', [
            'category' => self::$category
        ]);
    }
    public function updates(Request $request)
    {
        Category::updates($request);
        return back()->with('message', 'Info updated');


    }
}
