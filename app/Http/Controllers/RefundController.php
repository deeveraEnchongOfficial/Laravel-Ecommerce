<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Refund;
use Illuminate\Support\Facades\Auth;
use Notification;
use App\Notifications\StatusNotification;
use App\User;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $refund_list = Refund::all();
        return view('backend.refund.index', ['refund_list' => $refund_list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->id);
        $order = Order::find($request->id);
        // dd($order);

        return view('backend.refund.create', ['order' => $order]);
        // return view('backend.refund.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::find($request->input('order_id'));
        $data = [
            'reason' => $request->input('reason'),
            'refund_amount' => $request->input('refund_amount'),
            'description' => $request->input('description'),
            'user_id' => $order->user_id,
            'order_id' => $request->input('order_id'),
        ];
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $refund = Refund::find($id);
        // dd($refund);
        return view('backend.refund.show')->with('refund', $refund);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function refundStatusUpdate(Request $request, $id)
    {
        // dd($request->input('status'));
        $refund = Refund::find($id);
        $refund->status = $request->input('status');
        $refund->save();

        if($refund->status)
        {
            $users = User::where('id', $refund->user_id)->first();
            $details = [
                'title' => 'Your Item Refund Status is ' . $refund->status,
                // 'actionURL'=> '',
                'actionURL' => route('order.refund.show', $refund->id),
                'fas' => 'fa-file-alt'
                ];
                Notification::send($users, new StatusNotification($details));
                request()->session()->flash('success','');
        }
        return redirect()->back()->with('success', 'Refund status updated successfully');
    }
}
