<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller{
    public function index()
    {
        $category=Category::getAllCategory();
        return view ('backend.category. index')->with('categories', $category);
    }
    public function create()
    {
        $parent_cats=Category::where ('is_parent', 1)->orderBy ('title', 'ASC')->get();
        return view('backend.category.create')->with('parent_cats', $parent_cats);

    }
    public function store (Request $request){
        $this->validate ($request,[
            'title' => 'string required',
            'summary'=>'string|nullable',
            'photo'=>'string|nullable',
            'status' => 'required in:active, inactive',
            'is_parent' => 'sometimes in: 1',
            'parent_id' => 'nullable lexists:categories, id',
        ]);
        $data= $request->all();
        $slug=Str::slug ($request->title);
        $count=Category::where ('slug', $slug)->count();
        if ($count>0) {
            $slug=$slug.'-'.date('ymdis').'-'.rand (0,999);
        }
        $data['slug']=$slug;
        $data['is_parent']=$request->input ('is_parent', 0);
        $status=Category::create($data);
        if ($status) {
            request ()->session ()->flash ('success', 'Category successfully added');
        }
        else{
            request ()->session ()->flash ('error', 'Error occurred, Please try again!');
        }
        return redirect ()->route ('category. index');
    }
    public function show($id){
        $parent_cats=Category::where ('is_parent', 1)->get();
        $category=Category::findOrFail ($id);
        return view ('backend.category.edit')->with('category', $category) ->with('parent_cats', $parent_cats);

    }
    public function update (Request $request, $id){
        $category=Category::findOrFail ($id);
        $this->validate ($request, [
            'title' => 'string required',
            'summary'=>'string|nullable',
            'photo'=>'string|nullable',
            'parent_id' => 'nullable exists: categories, ie',
            'status'=>'required| in:active, inactive',
            'is_parent'=>'sometimes in:1',
        ]);
        $data= $request->all();
        $data['is_parent']=$request->input ('is_parent', 0);
        $status=$category->fill ($data)->save();
        if ($status) {
            request ()->session ()->flash ('success', 'Category successfully updated');
        }
        else{
            request()->session ()->flash ('error', 'Error occurred, Please try again!');
        }
        return redirect ()->route ('category.index');
    }
    public function destroy($id){
        $category=Category::findOrFail ($id);
        $child_cat_id=Category:: where ('parent_id', $id) ->pluck ('id');
        $status=$category->delete();
        if ($status) {
            if (count ($child_cat_id)>0) {
                Category::shiftChild ($child_cat_id);
            }
            request ()->session ()->flash ('success', 'Category successfully deleted');
        }
        else{
            request ()->session ()->flash ('error', 'Error while deleting category');
        }
        return redirect ()->route ('category.index');
    }
    public function getChildByParent (Request $request) {
        $category=Category::findOrFail ($request->id);
        $child_cat=Category::getChildByParentID ($request->id);
        if (count($child_cat) <=0) {
            return response ()->json (['status' => false, 'msg' => '', 'data'=>null]);
        }
        else{

            return response () ->json (['status' => true, 'msg' => '', 'data'=>$child_cat]);
        }
    }
}
