<?php
namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
class MessageController extends Controller{
    public function index () {
        $messages=Message::paginate (20);
        return view ('backend.message.index')->with('messages', $messages);
    }
    public function messageFive (){
        $message=Message::whereNull('read_at')->limit (5)->get();
        return response ()->json ($message);
    }
    public function create (){

    }
    public function store (Request $request){
        $this->validate ($request, [
            'name' => 'string | required|min:2',
            'email' => 'email | required',
            'message'=>'required|min:20 | max:200',
            'subject'=>'string|required',
            'phone'=>'numeric | required'
        ]);
        $message-Message::create($request->all());
        $data=array();
        $data['url']=route ('message.show', $message->id);
        $data['date']=$message->created_at->format ('F d, Y h:i A');
        $data['name']=$message->name;
        $data['email']=$message->email;
        $data['phone']=$message->phone;
        $data['message']=$message->message;
        $data['subject']=$message->subject;
        $data['photo']=Auth ()->user ()->photo;
        event (new MessageSent ($data));
        exit();
    }
    public function show (Request $request, $id){
        $message=Message::find($id);
        if ($message) {
            $message->read_at=\Carbon\Carbon::now();
            $message->save();
            return view('backend.message.show') ->with('message', $message);
        }
        else{
            return back();
        }
    }
    public function edit ($id){

    }
    public function update (Request $request, $id){

    }
    public function destroy($id){
        $message=Message::find($id);
        $status=$message->delete();
        if ($status) {
            request ()->session ()->flash ('success', 'Successfully deleted again');
        }
        else{
            request ()->session ()->flash ('error', 'Error occurred please try message');
        }
        return back ();
    }
}