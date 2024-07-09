<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otherImage extends Model
{
    use HasFactory;
//    private static $otherImage,$otherImages,$image,$imageNewName,$directory,$imgUrl,$imageExtension;
//
//    private static function getImageUrl($image){
//        self::$imageExtension=$image->getClientOriginalExtension();
//        self::$imageNewName = rand(1, 500000).'.'.self::$imageExtension;
//        self::$directory='admin/product-other-image/category/';
//        $image->move(self::$directory,self::$imageNewName);
//        self::$imgUrl= self::$directory.self::$imageNewName;
//        return  self::$imgUrl;
//
//    }
//    public static function newOtherImage($images, $id){
//        foreach ($images as  $image){
//            self::$otherImage =new otherImage();
//            self::$otherImage ->product_id=$id;
//            self::$otherImage ->image =self::getImageUrl($image);
//            self::$otherImage->save();
//
//        }
//    }
//
//    public static function updateOtherImage($images, $id)
//    {
//        self::deleteOtherImage($id);
//        self::newOtherImage($images, $id);
//    }
//
//    public static function deleteOtherImage($id)
//    {
//        self::$otherImages = OtherImage::where('product_id', $id)->get();
//        foreach(self::$otherImages as $image)
//        {
//            if (file_exists($image->image))
//            {
//                unlink($image->image);
//            }
//            $image->delete();
//        }
//    }

    private static $otherImage, $otherImages, $image, $imageName, $directory, $imageUrl, $imageExtension;

    public static function getImageUrl($image)
    {
        self::$imageExtension    = $image->getClientOriginalExtension();
        self::$imageName    =  rand(1, 500000).'.'.self::$imageExtension; // 123.jpg
        self::$directory    = 'upload/product-other-images/';
        $image->move(self::$directory, self::$imageName);
        self::$imageUrl     = self::$directory.self::$imageName;
        return self::$imageUrl;
    }


    public static function newOtherImage($images, $id)
    {
        foreach($images as $image)
        {
            self::$otherImage = new OtherImage();
            self::$otherImage->product_id   = $id;
            self::$otherImage->image        = self::getImageUrl($image);
            self::$otherImage->save();
        }
    }

    public static function updateOtherImage($images, $id)
    {
        self::deleteOtherImage($id);
        self::newOtherImage($images, $id);
    }

    public static function deleteOtherImage($id)
    {
        self::$otherImages = OtherImage::where('product_id', $id)->get();
        foreach(self::$otherImages as $image)
        {
            if (file_exists($image->image))
            {
                unlink($image->image);
            }
            $image->delete();
        }
    }
}
