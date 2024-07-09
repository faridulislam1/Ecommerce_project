<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
//
//    private static $product,$image,$imageNewName,$directory,$imgUrl;
//
//    public static function newProduct($request){
//        self::$product = new Product();
//        self::$product->category_id        = $request->category_id;
//        self::$product->sub_category_id    = $request->sub_category_id;
//        self::$product->brand_id           = $request->brand_id;
//        self::$product->unit_id            = $request->unit_id;
//        self::$product->name               = $request->name;
//        self::$product->code               = $request->code ;
//        self::$product->model              = $request->model;
//        self::$product->stock_amount       = $request->stock_amount;
//        self::$product->regular_price      = $request->regular_price;
//        self::$product->selling_price      = $request->selling_price;
//        self::$product->short_description  = $request->short_description;
//        self::$product->long_description   = $request->long_description;
//        self::$product->image              =self::getImageUrl($request);
//        self::$product->status             = $request->status;
//        self::$product->save();
//        return self::$product;
//    }
//
//    private static function getImageUrl($request){
//        self::$image = $request->file('image');
//        self::$imageNewName= rand().'.'.self::$image->getClientOriginalExtension();
//        self::$directory='admin/product-image/';
//        self::$imgUrl= self::$directory.self::$imageNewName;
//        self::$image->move( self::$directory,self::$imageNewName);
//        return  self::$imgUrl;
//    }
//    public static function destroy($id){
//        self::$product=Product::find($id);
//        if(self::$product->image){
//            if(file_exists(self::$product->image)){
//                unlink(self::$product->image);
//                self::$product->delete();
//            }
//        }
//        else{
//            self::$product->delete();
//        }
//    }
//    public static  function updatedProduct($request,$id){
//        self::$product = Product::find($id);
//        if ($request->file('image'))
//        {
//            if (file_exists(self::$product->image))
//            {
//                unlink(self::$product->image);
//            }
//            self::$imgUrl = self::getImageUrl($request);
//        }
//        else
//        {
//            self::$imgUrl = self::$product->image;
//        }
//        self::$product->category_id       = $request->category_id;
//        self::$product->sub_category_id    = $request->sub_category_id;
//        self::$product->brand_id           = $request->brand_id;
//        self::$product->unit_id            = $request->unit_id;
//        self::$product->name               = $request->name;
//        self::$product->code               = $request->code ;
//        self::$product->model              = $request->model;
//        self::$product->stock_amount       = $request->stock_amount;
//        self::$product->regular_price      = $request->regular_price;
//        self::$product->selling_price      = $request->selling_price;
//        self::$product->short_description  = $request->short_description;
//        self::$product->long_description   = $request->long_description;
//        self::$product->image              = self::$imgUrl;
//        self::$product->status             = $request->status;
//        self::$product->save();
//    }
//
//    public static function deleteProduct($id)
//    {
//        self::$product = Product::find($id);
//        if (file_exists(self::$product->image))
//        {
//            unlink(self::$product->image);
//        }
//        self::$product->delete();
//    }
//    public function category(){
//        return $this->belongsTo(Category::class);
//    }
//    public function subCategory(){
//        return $this->belongsTo(SubCategory::class);
//    }
//    public function brand(){
//        return $this->belongsTo(Brand::class);
//    }
//    public function unit(){
//        return $this->belongsTo(Unit::class);
//    }
//    public function otherImages(){
//        return $this->hasMany(otherImage::class);
//    }

    private static $product, $image, $imageName, $directory, $imageUrl;


    public static function getImageUrl($request)
    {
        self::$image        = $request->file('image');
        self::$imageName    = self::$image->getClientOriginalName();
        self::$directory    = 'upload/product-images/';
        self::$image->move(self::$directory, self::$imageName);
        self::$imageUrl     = self::$directory.self::$imageName;
        return self::$imageUrl;
    }

    public static function newProduct($request)
    {
        self::$product = new Product();
        self::$product->category_id         = $request->category_id;
        self::$product->sub_category_id     = $request->sub_category_id;
        self::$product->brand_id            = $request->brand_id;
        self::$product->unit_id             = $request->unit_id;
        self::$product->name                = $request->name;
        self::$product->code                = $request->code;
        self::$product->model               = $request->model;
        self::$product->stock_amount        = $request->stock_amount;
        self::$product->regular_price       = $request->regular_price;
        self::$product->selling_price       = $request->selling_price;
        self::$product->short_description   = $request->short_description;
        self::$product->long_description    = $request->long_description;
        self::$product->image               = self::getImageUrl($request);
        self::$product->status              = $request->status;
        self::$product->save();
        return self::$product;
    }

    public static function updatedProduct($request, $id)
    {
        self::$product = Product::find($id);
        if ($request->file('image'))
        {
            if (file_exists(self::$product->image))
            {
                unlink(self::$product->image);
            }
            self::$imageUrl = self::getImageUrl($request);
        }
        else
        {
            self::$imageUrl = self::$product->image;
        }

        self::$product->category_id         = $request->category_id;
        self::$product->sub_category_id     = $request->sub_category_id;
        self::$product->brand_id            = $request->brand_id;
        self::$product->unit_id             = $request->unit_id;
        self::$product->name                = $request->name;
        self::$product->code                = $request->code;
        self::$product->model               = $request->model;
        self::$product->stock_amount        = $request->stock_amount;
        self::$product->regular_price       = $request->regular_price;
        self::$product->selling_price       = $request->selling_price;
        self::$product->short_description   = $request->short_description;
        self::$product->long_description    = $request->long_description;
        self::$product->image               = self::$imageUrl;
        self::$product->status              = $request->status;
        self::$product->save();
    }

    public static function deleteProduct($id)
    {
        self::$product = Product::find($id);
        if (file_exists(self::$product->image))
        {
            unlink(self::$product->image);
        }
        self::$product->delete();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function otherImages()
    {
        return $this->hasMany(OtherImage::class);
    }
}
