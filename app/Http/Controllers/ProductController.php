<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use App\Notifications\StatusNotification;
use Notification;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::getAllProduct();
        // return $products;
        return view('backend.product.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand = Brand::get();
        $category = Category::where('is_parent', 1)->get();
        // return $category;
        return view('backend.product.create')->with('categories', $category)->with('brands', $brand);
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
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|nullable',
            'description' => 'string|nullable',
            'photo' => [
                'required',
                'file',
                'image',
                'mimes:jpeg,png,gif',
            ],
            'photo2' => [
                'required',
                'file',
                'image',
                'mimes:jpeg,png,gif',
            ],
            'photo3' => [
                'required',
                'file',
                'image',
                'mimes:jpeg,png,gif',
            ],
            'size' => 'nullable',
            'stock' => "required|numeric",
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric'
        ]);

        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        $data['is_featured'] = $request->input('is_featured', 0);
        $size = $request->input('size');
        if ($size) {
            $data['size'] = implode(',', $size);
        } else {
            $data['size'] = '';
        }

        if ($request->hasFile('photo')) {
            $uploadedFile = $request->file('photo');
            $imageData = base64_encode(file_get_contents($uploadedFile));
            $data['photo'] = $imageData;
            $photos[] = $imageData;
        }

        if ($request->hasFile('photo2')) {
            $uploadedFile = $request->file('photo2');
            $imageData = base64_encode(file_get_contents($uploadedFile));
            $data['photo2'] = $imageData;
            $photos[] = $imageData;
        }

        if ($request->hasFile('photo3')) {
            $uploadedFile = $request->file('photo3');
            $imageData = base64_encode(file_get_contents($uploadedFile));
            $data['photo3'] = $imageData;
            $photos[] = $imageData;
        }

        $data['photos'] = implode(',', $photos);

        $status = Product::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'is_featured' => $data['is_featured'],
            'cat_id' => $data['cat_id'],
            'child_cat_id' => $data['child_cat_id'],
            'price' => $data['price'],
            'discount' => $data['discount'],
            'size' => $data['size'],
            'brand_id' => $data['brand_id'],
            'condition' => $data['condition'],
            'stock' => $data['stock'],
            'status' => $data['status'],
            'photo' => $data['photo'],
            'photo2' => $data['photo2'],
            'photo3' => $data['photo3'],
            'slug' => $data['slug'],
            'photos' => $data['photos'],
        ]);
        if ($status) {
            request()->session()->flash('success', 'Product Successfully added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('product.index');
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
        $brand = Brand::get();
        $product = Product::findOrFail($id);
        $category = Category::where('is_parent', 1)->get();
        $items = Product::where('id', $id)->get();
        // return $items;
        return view('backend.product.edit')->with('product', $product)
            ->with('brands', $brand)
            ->with('categories', $category)->with('items', $items);
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
        $product = Product::findOrFail($id);
        // dd($request);
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|nullable',
            'description' => 'string|nullable',
            'photo' => 'image|mimes:jpeg,png,gif',
            'photo2' => 'image|mimes:jpeg,png,gif',
            'photo3' => 'image|mimes:jpeg,png,gif',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric'
        ]);

        $data = $request->all();
        // dd($data);
        $data['is_featured'] = $request->input('is_featured', 0);
        $size = $request->input('size');
        if ($size) {
            $data['size'] = implode(',', $size);
        } else {
            $data['size'] = '';
        }
        // return $data;

        // Delete old image if a new image is being uploaded
        if ($request->hasFile('photo')) {
            $uploadedFile = $request->file('photo');
            $imageData = base64_encode(file_get_contents($uploadedFile));
            $data['photo'] = $imageData;
            $photos[] = $imageData;
        }

        if ($request->hasFile('photo2')) {
            $uploadedFile = $request->file('photo2');
            $imageData = base64_encode(file_get_contents($uploadedFile));
            $data['photo2'] = $imageData;
            $photos[] = $imageData;
        }

        if ($request->hasFile('photo3')) {
            $uploadedFile = $request->file('photo3');
            $imageData = base64_encode(file_get_contents($uploadedFile));
            $data['photo3'] = $imageData;
            $photos[] = $imageData;
        }

        if ( $request->file('photo') || $request->hasFile('photo2') || $request->hasFile('photo3')) {
            $data['photos'] = implode(',', $photos);
        }

        $status = $product->fill($data)->save();

        if ($product->likes && $product['stock'] > 0) {
            // dd($product['stock']);
            // dd($product->likes);

            if ($product->likes->isNotEmpty()) {
                foreach ($product->likes as $like) {
                    $userId = $like->user_id; // Access the user_id property of each Like model

                    // Check if the user with the retrieved user_id exists
                    $user = User::find($userId);

                    // dd($user->notifications->pluck('id')->toArray());

                    if ($user) {
                        $details = [
                            'title' => 'Your Like has stock',
                            'actionURL' => route('like'),
                            'fas' => 'fa-file-alt'
                        ];

                        Notification::send($user, new StatusNotification($details));
                    }
                }
            }
        }

        if ($status) {
            request()->session()->flash('success', 'Product Successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $product = Product::findOrFail($id);

        // Delete the associated image from storage
        if (Storage::disk('public')->exists($product->photo)) {
            Storage::disk('public')->delete($product->photo);
        }

        $status = $product->delete();

        if ($status) {
            request()->session()->flash('success', 'Product successfully deleted');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting product');
        }

        return redirect()->route('product.index');
    }

    public function productSalesChart(Request $request)
    {
        // Example: Get product order count data from the database
        $productOrderCount = Product::withCount('carts')
            ->orderByDesc('carts_count')
            ->limit(5) // Adjust this limit based on how many products you want to display
            ->get();

        $labels = $productOrderCount->pluck('title');
        $orderCount = $productOrderCount->pluck('carts_count');

        return response()->json(['data' => ['labels' => $labels, 'orderCount' => $orderCount]]);
    }
}
