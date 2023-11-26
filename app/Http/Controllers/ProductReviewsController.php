<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Notification;
use App\Notifications\StatusNotification;
use App\User;
use App\Models\ProductReview;
class ProductReviewController extends Controller
{
    public function index(){
        $reviews=ProductReview::getAllReview();
        return view('backend.review.index')->with('reviews', $reviews);
    }
    public function create(){
    }
    public function store (Request $request){
        $this->validate ($request, [
            'rate' => 'required|numeric|min:1'
        ]);
        $product_info=Product::getProductBySlug ($request->slug);
        $data=$request->all();
        $data['product_id']=$product_info->id;
        $data['user_id']=$request->user()->id;
        $data['status']='active';
        $status=ProductReview::create($data);
        $user=User::where('role','admin')->get();
        $details=[
            'title' => 'New Product Rating!',
            'actionURL'=>route('product-detail', $product_info->slug),
            'fas'=>'fa-star'
        ];
        Notification::send($user, new StatusNotification ($details));
        if ($status) {
            request()->session()->flash('success', 'Thank you for your feedback');
        }
        else{
            request()->session()->flash('error', 'Something went wrong! Please try again!!');
        }
        return redirect ()->back();
    }
    public function show($id){}
    public function edit($id){
        $review=ProductReview::find($id);
        return view('backend.review.edit')->with('review', $review);
    }
    public function update(Request $request, $id){
        $review=ProductReview::find($id);
        if ($review) {
            $data=$request->all();
            $status=$review->fill ($data)->update();
            if ($status) {
                request()->session()->flash('success', 'Review Successfully  updated');
            }
            else{
                request()->session()->flash ('error', 'Something went wrong!Please try again!!');
            }
        }
        else{
            request()->session()->flash('error', 'Review not found!!');
        }
        return redirect()->route ('review.index');
    }
    public function destroy($id){
        $review=ProductReview::find($id);
        $status=$review->delete();
        if ($status) {
            request()->session()->flash('success', 'Successfully deleted  review');
        }
        else{
            request()->session()->flash ('error', 'Something went wrong! Try again');
        }
        return redirect()->route ('review.index');
    }
}
