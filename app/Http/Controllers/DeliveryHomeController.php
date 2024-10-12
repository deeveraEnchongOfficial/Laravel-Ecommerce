<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\PostComment;
use App\Rules\MatchOldPassword;
use Hash;
use Illuminate\Support\Facades\Storage;
use Notification;
use App\Notifications\StatusNotification;


class DeliveryHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index(){
        return view('delivery_user.index');
    }

    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('delivery_user.users.profile')->with('profile',$profile);
    }

    public function profileUpdate(Request $request,$id){
        // return $request->all();

        $this->validate($request,[
            'photo' => 'image|mimes:jpeg,png,gif',
        ]);

        $user=User::findOrFail($id);
        $data=$request->all();
        if ($request->hasFile('photo')) {
            $uploadedFile = $request->file('photo');
            $imageData = base64_encode(file_get_contents($uploadedFile));
            $data['photo'] = $imageData;
        }

        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated your profile');
        }
        else{
            request()->session()->flash('error','Please try again!');
        }
        return redirect()->back();
    }

    // Order
    public function orderIndex(){
        $orders=Order::orderBy('id','DESC')->where('deliver_by',auth()->user()->id)->paginate(10);
        return view('delivery_user.order.index')->with('orders',$orders);
    }

    public function userOrderDelete($id)
    {
        $order=Order::find($id);
        if($order){
           if($order->status=="processing" || $order->status=='delivered' || $order->status=='reject'){
                return redirect()->back()->with('error','You can not delete this order now');
           }
           else{
                $status=$order->delete();
                if($status){
                    request()->session()->flash('success','Order Successfully deleted');
                }
                else{
                    request()->session()->flash('error','Order can not deleted');
                }
                return redirect()->route('delivery_user.order.index');
           }
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function orderShow($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('delivery_user.order.show')->with('order',$order);
    }

    public function orderEdit($id)
    {
        // $order=Order::find($id);
        // // return $order;
        // return view('delivery_user.order.show')->with('order',$order);
        $order=Order::find($id);
        return view('delivery_user.order.edit')->with('order',$order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function orderUpdate(Request $request, $id)
    {
        // dd($request->all());
        $order=Order::find($id);
        $this->validate($request,[
            'status'=>'required|in:new,processing,shipped,delivered,reject'
        ]);
        $data=$request->all();
        // return $request->status;
        if($request->status=='delivered'){
            foreach($order->cart as $cart){
                $product=$cart->product;
                // return $product;
                $product->stock -=$cart->quantity;
                $product->save();
            }
        }

        if ($request->status != 'new') {

            $status = $request->status;
            $statusText = '';

            switch ($status) {
                case 'processing':
                    $statusText = 'Your order is being processed.';
                    break;

                case 'shipped':
                    $statusText = 'Great news! Your order has been shipped.';
                    break;

                case 'delivered':
                    $statusText = 'Success! Your order has been delivered.';
                    break;

                case 'reject':
                    $statusText = 'Important Update: Your order has been cancelled.';
                    break;

                default:
                    $statusText = 'Unknown Status';
                    break;
            }


            $details=[
                'title' => $statusText,
                'actionURL'=>route('user.order.show',$order->id),
                'fas'=>'fa-file-alt'
            ];
            Notification::send($order->user, new StatusNotification($details));
        }

        $status=$order->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated order');
        }
        else{
            request()->session()->flash('error','Error while updating order');
        }
        return redirect()->route('delivery_user.order.index');
    }

    // Product Review
    public function productReviewIndex(){
        $reviews=ProductReview::getAllUserReview();
        return view('delivery_user.review.index')->with('reviews',$reviews);
    }

    public function productReviewEdit($id)
    {
        $review=ProductReview::find($id);
        // return $review;
        return view('delivery_user.review.edit')->with('review',$review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewUpdate(Request $request, $id)
    {
        $review=ProductReview::find($id);
        if($review){
            $data=$request->all();
            $status=$review->fill($data)->update();
            if($status){
                request()->session()->flash('success','Review Successfully updated');
            }
            else{
                request()->session()->flash('error','Something went wrong! Please try again!!');
            }
        }
        else{
            request()->session()->flash('error','Review not found!!');
        }

        return redirect()->route('delivery_user.productreview.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewDelete($id)
    {
        $review=ProductReview::find($id);
        $status=$review->delete();
        if($status){
            request()->session()->flash('success','Successfully deleted review');
        }
        else{
            request()->session()->flash('error','Something went wrong! Try again');
        }
        return redirect()->route('delivery_user.productreview.index');
    }

    public function userComment()
    {
        $comments=PostComment::getAllUserComments();
        return view('delivery_user.comment.index')->with('comments',$comments);
    }

    public function userCommentDelete($id){
        $comment=PostComment::find($id);
        if($comment){
            $status=$comment->delete();
            if($status){
                request()->session()->flash('success','Post Comment successfully deleted');
            }
            else{
                request()->session()->flash('error','Error occurred please try again');
            }
            return back();
        }
        else{
            request()->session()->flash('error','Post Comment not found');
            return redirect()->back();
        }
    }

    public function userCommentEdit($id)
    {
        $comments=PostComment::find($id);
        if($comments){
            return view('delivery_user.comment.edit')->with('comment',$comments);
        }
        else{
            request()->session()->flash('error','Comment not found');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userCommentUpdate(Request $request, $id)
    {
        $comment=PostComment::find($id);
        if($comment){
            $data=$request->all();
            // return $data;
            $status=$comment->fill($data)->update();
            if($status){
                request()->session()->flash('success','Comment successfully updated');
            }
            else{
                request()->session()->flash('error','Something went wrong! Please try again!!');
            }
            return redirect()->route('delivery_user.post-comment.index');
        }
        else{
            request()->session()->flash('error','Comment not found');
            return redirect()->back();
        }

    }

    public function changePassword(){
        return view('delivery_user.layouts.userPasswordChange');
    }

    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->route('delivery_user')->with('success','Password successfully changed');
    }


}
