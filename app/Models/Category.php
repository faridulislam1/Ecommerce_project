<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    Protected $fillable =['name','description','image','status'];
    private static $category,$image,$imageNewName,$directory,$imgUrl;

    public static function newCategory($request){
        self::$category = new Category();
        self::$category->name = $request->name;
        self::$category->description = $request->description;
        if($request->file('image')){
            self::$category->image = self::saveImage($request);


        }
        self::$category->status = $request->status;
        self::$category->save();

    }

    private static function saveImage($request){
        self::$image = $request->file('image');
        self::$imageNewName='stu-'.rand().'.' .self::$image->getClientOriginalExtension();
        self::$directory='admin/category-image/category/';
        self::$imgUrl= self::$directory.self::$imageNewName;
        self::$image->move( self::$directory,self::$imageNewName);

        return  self::$imgUrl;
    }

    public static function destroy($id){
        self::$category=Category::find($id);
        if(self::$category->image){
            if(file_exists(self::$category->image)){
                unlink(self::$category->image);
                self::$category->delete();
            }
        }
        else{
            self::$category->delete();
        }
     }

    public static  function updates($request){
        self::$category=Category::find($request->id);
        self::$category->name = $request->name;
        self::$category->description = $request->description;
        if( $request->file('image')){
            if(  self::$category->image){
                if(file_exists(  self::$category->image)){
                    unlink(  self::$category->image);
                    self::$category->image =self::saveImage($request);

                }

            }
            else{
                self::$category->image =self::saveImage($request);
            }

        }
        self::$category->status = $request->status;
        self::$category->save();
    }
public function subCategories(){
        return $this->hasMany(SubCategory::class);
}

}
