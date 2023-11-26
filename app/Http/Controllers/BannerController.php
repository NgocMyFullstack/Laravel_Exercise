<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = Banner::orderBy('id', 'DESC')->paginate();
        return view('backend.banner.index')->with('banners', $Banner);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required|max:50',
            'desciption'=>'string|nullable',
            'photo'=>'string|required',
            'status'=>'required|in;active,inactive',

        ]);
        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Banner::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        $status = Banner::create($data);
        if ($status) {
            $request()->session()->flash('success', 'Banner successfully create');
        } else {
            $request()->session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('banner.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        $banner =Banner::find($banner->id);
        if (!$banner) {
            request()->session()->flash('error', 'Error, Please try again');
        }
        return view('backend.brand.edit')->with('brand', $banner);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $banner = Banner::find($banner->id);
        $this->validate($request, [
            'title' => 'string|required',

        ]);
        $data = $request->all();
        $status = $banner->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Banner successfully update');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner=Banner::findOrFail($banner->id);
        $status=$banner->delete();
        if ($status) {
            session()->flash('success', 'Banner successfully delete');
        } else {
            session()->flash('error', 'Error, occured while deleting banner');
        }
        return redirect()->route('banner.index');
    }
}
