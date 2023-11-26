<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Coupon;

class ShippingController extends Controller{
    
    public function index(){
        $shipping=Shipping::orderBy('id', 'DESC')->paginate (10);
        return view('backend. shipping.index')->with('shippings', $shipping);
    }
    public function create(){
        return view ('backend. shipping.create');

    }
    public function store (Request $request){
        $this->validate($request, [
            'type' => 'string | required',
            'price'=>'nullable|numeric',
            'status' => 'required| in: active, inactive'
        ]);
        $data=$request->all();
        $status=Shipping::create($data);
        if ($status) {
            request ()->session ()->flash ('success', 'Shipping successfully created');
        }else{
            request ()->session ()->flash ('error', 'Error, Please try again');
        }
        return redirect ()->route ('shipping.index');
    }
    public function show ($id){}
    public function edit($id){
        $shipping=Shipping::find($id);
        if(!$shipping) {
            request ()->session ()->flash ('error', 'Shipping not found');
        }
        return view ('backend. shipping.edit')->with('shipping', $shipping);
    }
    public function update (Request $request, $id){
        $shipping=Shipping::find($id);
        $this->validate ($request, [
        'type'=>'string | required',
        'price'=>'nullable|numeric',
        'status' => 'required|in:active, inactive'
        ]);
        $data=$request->all();
        return $data;
        $status=$shipping->fill ($data)->save();
        if ($status) {
            request()->session ()->flash ('success', 'Shipping successfullyupdated');
        }
        else{
            request ()->session ()->flash ('error', 'Error, Please try again');
        }
        return redirect ()->route ('shipping.index');
    }
    public function destroy($id){
        $shipping=Shipping::find($id);
        if ($shipping) {
            $status=$shipping->delete();
            if ($status) {
            request()->session ()->flash ('success', 'Shipping successfully deleted');

        }
        else{
            request()->session ()->flash ('error', 'Error, Please try again');
        }
        return redirect ()->route ('shipping.index');
    }
    else{
        request()->session()->flash('error','shipping not found');
        return redirect()->back();
    }
}
}