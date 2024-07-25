<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner=Banner::orderBy('id','DESC')->paginate(10);
        return view('backend.banner.index')->with('banners',$banner);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            // 'title'=>'string|required|max:50',
            // 'description'=>'string|nullable',
            'photo' => [
                'required',
                'file',
                'image',
                'mimes:jpeg,png,gif',
            ],
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();

        // if ($request->hasFile('photo')) {
        //     $uploadedFile = $request->file('photo');
        //     $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        //     $filePath = $uploadedFile->storeAs('images', $filename, 'public');
        //     $data['photo']=$filePath;
        // }

        if ($request->hasFile('photo')) {
            $uploadedFile = $request->file('photo');
            $imageData = base64_encode(file_get_contents($uploadedFile));
            $data['photo'] = $imageData;
        }

        $slug=Str::slug($request->id);
        $count=Banner::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $slug;
        $status=Banner::create($data);
        if($status){
            request()->session()->flash('success','Banner successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding banner');
        }
        return redirect()->route('banner.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner=Banner::findOrFail($id);
        return view('backend.banner.edit')->with('banner',$banner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $this->validate($request, [
            // 'title' => 'string|required|max:50',
            // 'description' => 'string|nullable',
            'photo' => 'image|mimes:jpeg,png,gif',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();

        // Delete old image if a new image is being uploaded
        // if ($request->hasFile('photo')) {
        //     if (Storage::disk('public')->exists($banner->photo)) {
        //         Storage::disk('public')->delete($banner->photo);
        //     }

        //     $uploadedFile = $request->file('photo');
        //     $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        //     $filePath = $uploadedFile->storeAs('images', $filename, 'public');
        //     $data['photo'] = $filePath;
        // }

        if ($request->hasFile('photo')) {
            $uploadedFile = $request->file('photo');
            $imageData = base64_encode(file_get_contents($uploadedFile));
            $data['photo'] = $imageData;
        }

        $status = $banner->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Banner successfully updated');
        } else {
            request()->session()->flash('error', 'Error occurred while updating banner');
        }

        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        // Delete the associated image from storage
        if (Storage::disk('public')->exists($banner->photo)) {
            Storage::disk('public')->delete($banner->photo);
        }

        $status = $banner->delete();

        if ($status) {
            request()->session()->flash('success', 'Banner successfully deleted');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting banner');
        }

        return redirect()->route('banner.index');
    }
}
