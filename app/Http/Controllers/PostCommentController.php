<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
use Notification;
use App\User;
use App\Notifications\StatusNotification;
use App\Models\PostComment;
class PostCommentController extends Controller{
    public function index(){
        $comments=PostComment::getAllComments();
        return view('backend.comment.index')->with('comments', $comments);
    }
    public function create(){

    }
    public function store (Request $request){
        $post_info=Post::getPostBySlug ($request->slug);
        $data=$request->all();
        $data['user_id']=$request->user()->id;
        $data['status']='active';
        $status=PostComment::create($data);
        $user=User::where ('role', 'admin')->get();
        $details=[
            'title' => "New Comment created",
            'actionURL'=>route('blog.detail', $post_info->slug),
            'fas'=>'fas fa-comment'
        ];
        Notification::send($user, new StatusNotification ($details));
        if ($status) {
            request()->session ()->flash ('success', 'Thank you for your comment');
        }
        else{
            request()->session ()->flash ('error', 'Something went wrong! Please try again!!');
        }
        return redirect()->back();
    }
    public function show ($id){}
    public function edit ($id){
        $comments=PostComment::find($id);
        if ($comments) {
            return view('backend.comment.edit')->with('comment'. $comments);
        }
        else{
            request()->session()->flash('error', 'Comment not found');
            return redirect()->back();
        }
    }
    public function update (Request $request, $id){
        $comment=PostComment::find($id);
        if ($comment) {
            $data=$request->all();
            $status=$comment->fill ($data)->update();
            if ($status) {
                request()->session()->flash('success', 'Comment successfully updated');
            }
            else{
                request()->session()->flash('error', 'Something went wrong! Please try again!!');
            }
            return redirect ()->route ('comment.index');
        }
        else{
            request()->session()->flash('error', 'Comment not found');
            return redirect()->back();
        }
    }
    public function destroy($id){
        $comment=PostComment::find($id);
        if ($comment) {
            $status=$comment->delete();
            if ($status) {
                request()->session()->flash('success', 'Post Comment successfully deleted');
            }
            else{
                request()->session()->flash('error', 'Error occurred please try again');
            }
            return back();
        }
        else{
            request()->session()->flash('error', 'Post Comment not found');
            return redirect()->back();
        }
    }
}

    