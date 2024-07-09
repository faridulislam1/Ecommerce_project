<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    Protected $fillable =['name','description','image','status'];
    private static $brand,$image,$imageNewName,$directory,$imgUrl;

    public static function newBrand($request){
        self::$brand = new Brand();
        self::$brand->name = $request->name;
        self::$brand->description = $request->description;
        if($request->file('image')){
            self::$brand->image = self::saveImage($request);


        }
        self::$brand->status = $request->status;
        self::$brand->save();

    }

    private static function saveImage($request){
        self::$image = $request->file('image');
        self::$imageNewName='stu-'.rand().'.' .self::$image->getClientOriginalExtension();
        self::$directory='admin/brand-image/category/';
        self::$imgUrl= self::$directory.self::$imageNewName;
        self::$image->move( self::$directory,self::$imageNewName);

        return  self::$imgUrl;
    }

    public static function destroy($id){
        self::$brand=Brand::find($id);
        if(self::$brand->image){
            if(file_exists(self::$brand->image)){
                unlink(self::$brand->image);
                self::$brand->delete();
            }
        }
        else{
            self::$brand->delete();
        }
    }

    public static  function updates($request){
        self::$brand=Brand::find($request->id);
        self::$brand->name = $request->name;
        self::$brand->description = $request->description;
        if( $request->file('image')){
            if(  self::$brand->image){
                if(file_exists(  self::$brand->image)){
                    unlink(  self::$brand->image);
                    self::$brand->image =self::saveImage($request);

                }

            }
            else{
                self::$brand->image =self::saveImage($request);
            }

        }
        self::$brand->status = $request->status;
        self::$brand->save();
    }
}
