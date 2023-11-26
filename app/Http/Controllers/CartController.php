<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Wishlist;
use Helper;


class CartController extends Controller
{
   protected $product=null;
   public function _construct(Product $product){
    $this->product=$product;
   }
   public function addToCart(Request $request){
    if(empty($request->slug)){
        request()->session()->flash('error','Invalid Products');
        return back();
    }
    $product=Product::where('slug',$request->slug)->first();
    if(empty($product)){
        request()->session()->flash('error','Invalid Products');
        return back();
    }
    $already_cat=Cart::where('user_id',auth()->user()->id)->where('order_id',null)->where('product_id','$product->id')->first();
    if($already_cat){
        $already_cat->quantity=$already_cat->quantity + 1;
        $already_cat->amount=$product->price+$already_cat->amount;
        if($already_cat->product->stock<$already_cat->quantity||$already_cat->product->stock<=0) 
        return back()->with('error','Stock not sufficient!.');
        $already_cat->save();
    }else{
        $cart=new Cart;
        $cart->user_id = auth()->user()->id;
        $cart->product_id=$product->id;
        $cart->price=($product->price-($product->price*$product->discount)/100);
        $cart->quantity=1;
        $cart->amount=$cart->price*$cart->quantity;
        if($cart->product->stock < $cart->quantity || $cart->product->stock<=0 )
        return back()->with('error','Stock not sufficient!.');
        $cart->save();
        $wishlist=Wishlist::where('user_id',auth()->user()->id)->where('cart_id',null)->update(['cart_id'=>$cart->id]);
    }
    request()->session()->flash('success','Product successfully added to cart');
    return back();
   }
   public function singleAddToCart(Request $request){
    $request->validate([
        'slug' => 'required',
        'quant' =>'required',
    ]);
    $product = Product::where('slug',$request->slug)->first();
    if($product->stock<$request->quant[1]){
        return back()->with('error','Out of stock, you can add other products.';)
    }
    if(($request->quant[1] < 1) || empty($product)){ 
        request()->session()->flash('error','Invalid prodcut');
        return back();
    }
    $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->where('product_id', $product->id)->first();
    if($already_cart){
        $already_cart->quantity = $already_cart->quantity + $request->quant[1];
        $already_cart->amount = ($product->price * $request->quant[1]) + $already_cart->amount;
        if($already_cart->prodcut->stock<$already_cart->quantity || $already_cart->prodcut->stock <= 0)
        return back()->with('error','stock not sufficient!.');
        $already_cart->save();
    }else{
        $cart=new Cart;
        $cart->user_id = auth()->user()->id;
        $cart->product_id=$product->id;
        $cart->price=($product->price-($product->price*$product->discount)/100);
        $cart->quantity= $request->quant[1];
        $cart->amount=($product->price*$request->quantity[1]);
        if($cart->product->stock < $cart->quantity || $cart->product->stock<=0 )
        return back()->with('error','Stock not sufficient!.');
        $cart->save();
    }
    request()->session()->flash('success','Product successfully added to cart.');
    return back();
   }
   public function cartDelete(Request $request){
    $cart = Cart::find($request->id);
    if($cart){ 
        $cart->delete();
        request()->session()->slash('success','Cart successfully removed');
        return back();
    }
    request()->session()->flash('error','Error please try again');
    return back();
   }
   public function cartUpdate(Request $request){
        if($request->quant){
            $error = array();
            $success = '';
            foreach ($request->quant as $k=>$quant){
                $id = $request->qty_id[$k];
                $cart = Cart::find($id);
                if($quant > 0 && $cart){ 
                    if($cart->product->stock < $quant){
                        request()->session()->flash('error','Out of stock');
                        return back();
                    }
                    $cart->quantity = ($cart->product->stock > $quant) ? $quant : $cart->product->stock;
                    if ($cart->product->stock<=0) continue;
                    $after_price=($cart->product->price-($cart->product->price*$cart->product->discount)/100);
                    $cart->amount = $after_price * $quant;
                    $cart->save();
                    $success = 'Cart successfully update!';
                }else{
                    $error[] = 'cart Invalid!';
                }
            }
            return back()->with($error)->with('success',$success);
        }else{
            return back()->with('Cart invalid');
        }
   }
   public function checkout(Request $request){
    return view('frontend.pages.checkout');
   }
}
