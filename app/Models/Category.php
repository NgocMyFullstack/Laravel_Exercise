<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable=['title','slug','summary','photo','status','is_parent','parent_id','added_by'];

    public function parent_info(){
        return $this->hasOne('App\Models\Category','id','parent_id');
    }
    public static function getAllcategory(){
        return Category::orderBy('id','DESC')->with('parent_info')->paginate(10);
    }
    public static function shiftChild($cat_id){
        return Category::whereIn('id',$cat_id)->update(['is_parent'=>1]);
    }
    public static function getChildByParentID($id){
        return Category::where('parent_id',$id)->orderBy('id','ASC')->pluck('title','id');
    }
    public static function child_cat(){ 
        return $this->hasMany('App\Models\Category','id','parent_id','id')->where('status','active');
    }
    public static function getAllParentWithChild(){ 
        return Category::with('child_cat')->where('is_parent',1)->where('status','active')->orderBy('title','ASC')->get();
    }
    public function products(){
        return $this->hasMany('App\Models\Product','id','cat_id','id')->where('status','active');
    }
    public function sub_products(){
        return $this->hasMany('App\Models\Product','id','child_cat','id')->where('status','active');
    }
    public static function getProductByCat($slug){
        return Category::with('products')->where('slug',$slug)->first();
    }
    public static function getProductBySubCat($slug){
        return Category::with('sub_products')->where('slug',$slug)->first();
    }
    public static function countActiveCategory(){
        $data=Category::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }

}
