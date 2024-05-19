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
// use App\Models\Notification;
use App\Notifications\StatusNotification;
use Illuminate\Support\Facades\Auth;
use App\Models\Refund;
use Notification;


class HomeController extends Controller
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
        return view('user.index');
    }

    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('user.users.profile')->with('profile',$profile);
    }

    public function profileUpdate(Request $request,$id){
        // return $request->all();

        $this->validate($request,[
            'photo' => 'image|mimes:jpeg,png,gif',
        ]);

        $user=User::findOrFail($id);
        $data=$request->all();

        // Delete old image if a new image is being uploaded
        if ($request->hasFile('photo')) {
            if (Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $uploadedFile = $request->file('photo');
            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $filePath = $uploadedFile->storeAs('images/profile', $filename, 'public');
            $data['photo'] = $filePath;
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
        $orders=Order::orderBy('id','DESC')->where('user_id',auth()->user()->id)->paginate(10);
        return view('user.order.index')->with('orders',$orders);
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
                return redirect()->route('user.order.index');
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
        // dd($order);
        return view('user.order.show')->with('order',$order);
    }
    // Product Review
    public function productReviewIndex(){
        $reviews=ProductReview::getAllUserReview();
        return view('user.review.index')->with('reviews',$reviews);
    }

    public function productReviewEdit($id)
    {
        $review=ProductReview::find($id);
        // return $review;
        return view('user.review.edit')->with('review',$review);
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

        return redirect()->route('user.productreview.index');
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
        return redirect()->route('user.productreview.index');
    }

    public function userComment()
    {
        $comments=PostComment::getAllUserComments();
        return view('user.comment.index')->with('comments',$comments);
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
            return view('user.comment.edit')->with('comment',$comments);
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
            return redirect()->route('user.post-comment.index');
        }
        else{
            request()->session()->flash('error','Comment not found');
            return redirect()->back();
        }

    }

    public function changePassword(){
        return view('user.layouts.userPasswordChange');
    }

    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->route('user')->with('success','Password successfully changed');
    }

    public function notificationIndex(){
        return view('user.notification.index');
    }

    public function notificationShow(Request $request){
        $notification=Auth()->user()->notifications()->where('id',$request->id)->first();
        if($notification){
            $notification->markAsRead();
            return redirect($notification->data['actionURL']);
        }
    }

    public function notificationDelete($id){
        $notification=\Notification::find($id);
        if($notification){
            $status=$notification->delete();
            if($status){
                request()->session()->flash('success','Notification successfully deleted');
                return back();
            }
            else{
                request()->session()->flash('error','Error please try again');
                return back();
            }
        }
        else{
            request()->session()->flash('error','Notification not found');
            return back();
        }
    }

    public function refundIndex()
    {
        $refund_list = Refund::where('user_id', Auth::user()->id)->get();
        return view('user.refund.index', ['refund_list' => $refund_list]);
    }

    public function refundCreate(Request $request)
    {
        // dd($request->id);
        $order = Order::find($request->id);
        // dd($order);

        return view('user.refund.create', ['order' => $order]);
        // return view('user.refund.create');
    }

    public function refundStore(Request $request)
    {
        $order = Order::find($request->input('order_id'));
        $data = [
            'reason' => $request->input('reason'),
            'refund_amount' => $request->input('refund_amount'),
            'description' => $request->input('description'),
            'photo' => $request->input('photo'),
            'user_id' => $order->user_id,
            'order_id' => $request->input('order_id'),
        ];

        if ($request->hasFile('photo')) {
            $uploadedFile = $request->file('photo');
            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $filePath = $uploadedFile->storeAs('images/refund', $filename, 'public');
            $data['photo'] = $filePath;
        }

        $status=Refund::create($data);
        if($status){

            $users = User::where('role', 'admin')->first();
            $details = [
                'title' => 'New Refund Item',
                // 'actionURL' => route('order.show', $order->id),
                'actionURL' => "",
                'fas' => 'fa-file-alt'
            ];
            Notification::send($users, new StatusNotification($details));
            request()->session()->flash('success','Refund successfully Created');
        }
        else{
            request()->session()->flash('error','Error occurred while adding Refund');
        }
        return redirect()->route('order.refund.index');
    }

    public function refundshow($id)
    {
        $auth_user_id = Auth::user()->id;
        // $refund = Refund::find($id);
        $refund = Refund::where('id', $id)
                ->where('user_id', $auth_user_id)
                ->first();
        // dd($refund);
        return view('user.refund.show')->with('refund', $refund);
    }

    public function refundDelete($id)
    {
        $refund=Refund::find($id);
        if($refund){
            $status=$refund->delete();
            if($status){
                request()->session()->flash('success','Refund successfully deleted');
                return back();
            }
            else{
                request()->session()->flash('error','Error please try again');
                return back();
            }
        }
        else{
            request()->session()->flash('error','Refund not found');
            return back();
        }

    }
}
