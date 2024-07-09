<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    private static $subcategory,$image,$imageNewName,$directory,$imgUrl;

    public static function newSubCategory($request){
        self::$subcategory = new SubCategory();
        self::$subcategory->category_id    = $request->category_id;
        self::$subcategory->name           = $request->name;
        self::$subcategory->description    = $request->description;
        if($request->file('image')){
            self::$subcategory->image      = self::saveImage($request);
        }
        self::$subcategory->status         = $request->status;
        self::$subcategory->save();

    }

    private static function saveImage($request){
        self::$image = $request->file('image');
        self::$imageNewName='stu-'.rand().'.' .self::$image->getClientOriginalExtension();
        self::$directory='admin/sub-category-image/category/';
        self::$imgUrl= self::$directory.self::$imageNewName;
        self::$image->move( self::$directory,self::$imageNewName);

        return  self::$imgUrl;
    }

    public static function destroy($id){
        self::$subcategory=SubCategory::find($id);
        if(self::$subcategory->image){
            if(file_exists(self::$subcategory->image)){
                unlink(self::$subcategory->image);
                self::$subcategory->delete();
            }
        }
        else{
            self::$subcategory->delete();
        }
    }
    public static  function updates($request){
        self::$subcategory=SubCategory::find($request->id);
        self::$subcategory->category_id    = $request->category_id;
        self::$subcategory->name = $request->name;
        self::$subcategory->description = $request->description;
        if( $request->file('image')){
            if(  self::$subcategory->image){
                if(file_exists(  self::$subcategory->image)){
                    unlink(  self::$subcategory->image);
                    self::$subcategory->image =self::saveImage($request);

                }

            }
            else{
                self::$subcategory->image =self::saveImage($request);
            }

        }
        self::$subcategory->status = $request->status;
        self::$subcategory->save();
    }
    public  function category(){
        return $this->belongsTo(Category::class);
    }
}
