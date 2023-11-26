<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Post;
use App\User;
use Auth;
use Session;
use Newsletter;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        return null;
    }
    public function home()
    {
        $banners = Banner::where('status', 'active')->limit(3)->orderBy('id', 'DESC')->get();
        $products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(8)->get();
        $featured=Product::where('status','active')->where('is_featured',1)->orderBy('price','DESC')->limit(2)->get();
        $products_hot = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(10)->get();
        $products_last = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(10)->get();
        $posts = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.index')
                    ->with('posts',$posts)
                    ->with('featured',$featured)
                    ->with('banners', $banners)
                    ->with('products_hot', $products_hot)
                    ->with('products_last', $products_last)
                    ->with('product_lists', $products);

    }
    public function productDetail($slug)
    {
        $product_detail = Product::getProductBySlug($slug);
        return view ('frontend.pages.product_detail')->with('product_detail',$product_detail);
    }
}