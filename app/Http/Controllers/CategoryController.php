<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category=Category::getAllCategory();
        // return $category;
        return view('backend.category.index')->with('categories',$category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats=Category::where('is_parent',1)->orderBy('title','ASC')->get();
        return view('backend.category.create')->with('parent_cats',$parent_cats);
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
            'title'=>'string|required',
            'summary'=>'string|nullable',
            'photo' => [
                'required',
                'file',
                'image',
                'mimes:jpeg,png,gif',
            ],
            'status'=>'required|in:active,inactive',
            'is_parent'=>'sometimes|in:1',
            'parent_id'=>'nullable|exists:categories,id',
        ]);
        $data= $request->all();

        // if ($request->hasFile('photo')) {
        //     $uploadedFile = $request->file('photo');
        //     $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        //     $filePath = $uploadedFile->storeAs('images/category', $filename, 'public');
        //     $data['photo']=$filePath;
        // }

        if ($request->hasFile('photo')) {
            $uploadedFile = $request->file('photo');
            $imageData = base64_encode(file_get_contents($uploadedFile));
            $data['photo'] = $imageData;
        }

        $slug=Str::slug($request->title);
        $count=Category::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['is_parent']=$request->input('is_parent',0);
        // return $data;
        $status=Category::create($data);
        if($status){
            request()->session()->flash('success','Category successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('category.index');


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
        $parent_cats=Category::where('is_parent',1)->get();
        $category=Category::findOrFail($id);
        return view('backend.category.edit')->with('category',$category)->with('parent_cats',$parent_cats);
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
        // return $request->all();
        $category=Category::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|nullable',
            'photo' => 'image|mimes:jpeg,png,gif',
            'status'=>'required|in:active,inactive',
            'is_parent'=>'sometimes|in:1',
            'parent_id'=>'nullable|exists:categories,id',
        ]);
        $data= $request->all();

        // Delete old image if a new image is being uploaded
        // if ($request->hasFile('photo')) {
        //     if (Storage::disk('public')->exists($category->photo)) {
        //         Storage::disk('public')->delete($category->photo);
        //     }

        //     $uploadedFile = $request->file('photo');
        //     $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        //     $filePath = $uploadedFile->storeAs('images/category', $filename, 'public');
        //     $data['photo'] = $filePath;
        // }

        if ($request->hasFile('photo')) {
            $uploadedFile = $request->file('photo');
            $imageData = base64_encode(file_get_contents($uploadedFile));
            $data['photo'] = $imageData;
        }

        $data['is_parent']=$request->input('is_parent',0);
        // return $data;
        $status=$category->fill($data)->save();
        if($status){
            request()->session()->flash('success','Category successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $category=Category::findOrFail($id);

        // Delete the associated image from storage
        if (Storage::disk('public')->exists($category->photo)) {
            Storage::disk('public')->delete($category->photo);
        }

        $status = $category->delete();

        if ($status) {
            request()->session()->flash('success', 'Category successfully deleted');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting category');
        }

        return redirect()->route('category.index');
    }

    public function getChildByParent(Request $request){
        // return $request->all();
        $category=Category::findOrFail($request->id);
        $child_cat=Category::getChildByParentID($request->id);
        // return $child_cat;
        if(count($child_cat)<=0){
            return response()->json(['status'=>false,'msg'=>'','data'=>null]);
        }
        else{
            return response()->json(['status'=>true,'msg'=>'','data'=>$child_cat]);
        }
    }
}
