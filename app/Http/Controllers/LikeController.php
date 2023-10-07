<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Like;
class LikeController extends Controller
{
    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }

    public function like(Request $request){
        // dd($request->all());
        if (empty($request->slug)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }
        $product = Product::where('slug', $request->slug)->first();
        // return $product;
        if (empty($product)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }

        $already_wishlist = Like::where('user_id', auth()->user()->id)->where('cart_id',null)->where('product_id', $product->id)->first();
        // return $already_wishlist;
        if($already_wishlist) {
            request()->session()->flash('error','You already placed in like');
            return back();
        }else{

            $like = new Like;
            $like->user_id = auth()->user()->id;
            $like->product_id = $product->id;
            $like->price = ($product->price-($product->price*$product->discount)/100);
            $like->quantity = 1;
            $like->amount=$like->price*$like->quantity;
            if ($like->product->stock >= 0) return back()->with('error','Only Out of Stock can be added to Likes!.');
            $like->save();
        }
        request()->session()->flash('success','Product successfully added to like');
        return back();
    }

    public function wishlistDelete(Request $request){
        $like = Like::find($request->id);
        if ($like) {
            $like->delete();
            request()->session()->flash('success','Like successfully removed');
            return back();
        }
        request()->session()->flash('error','Error please try again');
        return back();
    }
}
