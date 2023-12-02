<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        return view('backend.order.index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $selectedItemsArray = explode(',', $request->input('selected_items'));
        $this->validate($request, [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'address1' => 'string|required',
            'address2' => 'string|nullable',
            'coupon' => 'nullable|numeric',
            'phone' => 'numeric|required',
            'post_code' => 'string|nullable',
            'email' => 'string|required',
            'shipping' => 'required'
        ]);
        // dd(!$selectedItemsArray[0] == '');
        // return $request->all();

        // dd($selectedItemsArray);
        // empty($selectedItemsArray)

        if (empty(Cart::where('user_id', auth()->user()->id)->where('order_id', null)->first())) {
            request()->session()->flash('error', 'Cart is Empty !');
            return back();
        }
        // $cart=Cart::get();
        // // return $cart;
        // $cart_index='ORD-'.strtoupper(uniqid());
        // $sub_total=0;
        // foreach($cart as $cart_item){
        //     $sub_total+=$cart_item['amount'];
        //     $data=array(
        //         'cart_id'=>$cart_index,
        //         'user_id'=>$request->user()->id,
        //         'product_id'=>$cart_item['id'],
        //         'quantity'=>$cart_item['quantity'],
        //         'amount'=>$cart_item['amount'],
        //         'status'=>'new',
        //         'price'=>$cart_item['price'],
        //     );

        //     $cart=new Cart();
        //     $cart->fill($data);
        //     $cart->save();
        // }

        // $total_prod=0;
        // if(session('cart')){
        //         foreach(session('cart') as $cart_items){
        //             $total_prod+=$cart_items['quantity'];
        //         }
        // }

        // dd($request->shipping);

        $order = new Order();
        $order_data = $request->all();
        $order_data['order_number'] = 'ORD-' . strtoupper(Str::random(10));
        $order_data['user_id'] = $request->user()->id;
        $order_data['shipping_id'] = $request->shipping;
        $shipping = Shipping::where('id', $order_data['shipping_id'])->pluck('price');
        // return session('coupon')['value'];
        // $order_data['sub_total'] = Helper::totalCartPrice();
        // dd($order_data['sub_total']);
        $order_data['sub_total'] = !$selectedItemsArray[0] == '' ? $this->totalCartPrice($selectedItemsArray) : Helper::totalCartPrice();
        // dd($order_data['sub_total']);
        $order_data['quantity'] = Helper::cartCount();
        if (session('coupon')) {
            $order_data['coupon'] = session('coupon')['value'];
            $order_data['coupon_id'] = session('coupon')['id'];
        }
        if ($request->shipping) {
            if (session('coupon')) {
                // $order_data['total_amount'] = Helper::totalCartPrice() + $shipping[0] - session('coupon')['value'];
                $order_data['total_amount'] = !$selectedItemsArray[0] == ''
                                                ? $this->totalCartPrice($selectedItemsArray) + $shipping[0] - session('coupon')['value']
                                                : Helper::totalCartPrice() + $shipping[0] - session('coupon')['value'];
            } else {
                // $order_data['total_amount'] = Helper::totalCartPrice() + $shipping[0];
                $order_data['total_amount'] = !$selectedItemsArray[0] == ''
                                                ? $this->totalCartPrice($selectedItemsArray) + $shipping[0]
                                                : Helper::totalCartPrice() + $shipping[0];
            }
        } else {
            if (session('coupon')) {
                // $order_data['total_amount'] = Helper::totalCartPrice() - session('coupon')['value'];
                $order_data['total_amount'] = !$selectedItemsArray[0] == ''
                                                ? $this->totalCartPrice($selectedItemsArray) - session('coupon')['value']
                                                : Helper::totalCartPrice() - session('coupon')['value'];
            } else {
                // $order_data['total_amount'] = Helper::totalCartPrice();
                $order_data['total_amount'] = !$selectedItemsArray[0] == ''
                                                ? $this->totalCartPrice($selectedItemsArray)
                                                : Helper::totalCartPrice();
            }
        }
        // return $order_data['total_amount'];
        $order_data['status'] = "new";
        if (request('payment_method') == 'paypal') {
            $order_data['payment_method'] = 'paypal';
            $order_data['payment_status'] = 'paid';
        } else {
            $order_data['payment_method'] = 'cod';
            $order_data['payment_status'] = 'Unpaid';
        }
        // dd($order_data);
        $order->fill($order_data);
        $status = $order->save();
        if ($order)
            // dd($order->id);
            $users = User::where('role', 'admin')->first();
        $details = [
            'title' => 'New order created',
            'actionURL' => route('order.show', $order->id),
            'fas' => 'fa-file-alt'
        ];
        Notification::send($users, new StatusNotification($details));
        if (request('payment_method') == 'paypal') {
            return redirect()->route('payment')->with(['id' => $order->id]);
        } else {
            session()->forget('cart');
            session()->forget('coupon');
        }
        // dd($selectedItemsArray[0]);
        // dd($selectedItemsArray[0] == '');
        if (!$selectedItemsArray[0] == '') {
            Cart::where('user_id', auth()->user()->id)->where('order_id', null)->whereIn('id', $selectedItemsArray)->update(['order_id' => $order->id]);
        } else {
            Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);
        }
        // Cart::where('user_id', auth()->user()->id)->where('order_id', null)->whereIn('id', $selectedItemsArray)->update(['order_id' => $order->id]);
        // $totalAmount = Cart::where('user_id', $user_id)
        //     ->where('order_id', null)
        //     ->whereIn('id', $selectedItemsArray)
        //     ->sum('amount');

        $orders = Order::where('user_id', auth()->user()->id)
        ->orderBy('user_id')
        ->get();
        $totalAmount = $orders->sum('total_amount');

        if ($orders->count() > 3 || $totalAmount > 15000) {
            $randomCode = Coupon::inRandomOrder()->limit(1)->value('code');
            $details = [
                'title' => 'Claim your Coupon ' . $randomCode,
                'actionURL' => "",
                'fas' => 'fa-file-alt'
            ];
            $user = Auth::user();
            Notification::send($user, new StatusNotification($details));
        }

        // dd($users);
        request()->session()->flash('success', 'Your product successfully placed in order');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        // return $order;
        return view('backend.order.show')->with('order', $order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return view('backend.order.edit')->with('order', $order);
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
        // dd($request->all());
        $order = Order::find($id);
        // dd($order->user);
        $this->validate($request, [
            'status' => 'required|in:new,processing,shipped,delivered,cancel',
            'deliver_by' => 'required',
        ]);
        $data = $request->all();
        // return $request->status;
        if ($request->status == 'delivered') {
            foreach ($order->cart as $cart) {
                $product = $cart->product;
                // return $product;
                $product->stock -= $cart->quantity;
                $product->save();
            }
        }

        if ($request->status != 'new') {
            $details=[
                'title' => 'The status of your order is ' . $request->status,
                'actionURL'=>route('user.order.show',$order->id),
                'fas'=>'fa-file-alt'
            ];
            Notification::send($order->user, new StatusNotification($details));
        }

        $status = $order->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Successfully updated order');
        } else {
            request()->session()->flash('error', 'Error while updating order');
        }
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $status = $order->delete();
            if ($status) {
                request()->session()->flash('success', 'Order Successfully deleted');
            } else {
                request()->session()->flash('error', 'Order can not deleted');
            }
            return redirect()->route('order.index');
        } else {
            request()->session()->flash('error', 'Order can not found');
            return redirect()->back();
        }
    }

    public function orderTrack()
    {
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request)
    {
        // return $request->all();
        $order = Order::where('user_id', auth()->user()->id)->where('order_number', $request->order_number)->first();
        if ($order) {
            if ($order->status == "new") {
                request()->session()->flash('success', 'Your order has been placed. please wait.');
                return redirect()->route('home');
            } elseif ($order->status == "process") {
                request()->session()->flash('success', 'Your order is under processing please wait.');
                return redirect()->route('home');
            } elseif ($order->status == "delivered") {
                request()->session()->flash('success', 'Your order is successfully delivered.');
                return redirect()->route('home');
            } else {
                request()->session()->flash('error', 'Your order canceled. please try again');
                return redirect()->route('home');
            }
        } else {
            request()->session()->flash('error', 'Invalid order numer please try again');
            return back();
        }
    }

    // PDF generate
    public function pdf(Request $request)
    {
        $order = Order::getAllOrder($request->id);
        // return $order;
        $file_name = $order->order_number . '-' . $order->first_name . '.pdf';
        // return $file_name;
        $pdf = PDF::loadview('backend.order.pdf', compact('order'));
        return $pdf->download($file_name);
    }
    // Income chart
    public function incomeChart(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;
        // dd($year);
        $items = Order::with(['cart_info'])->whereYear('created_at', $year)->where('status', 'delivered')->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
        // dd($items);
        $result = [];
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount = $item->cart_info->sum('amount');
                // dd($amount);
                $m = intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }

    public function yearlyEarningsChart(Request $request)
    {
        $yearlyItems = Order::with(['cart_info'])
            // ->whereYear('created_at', now()->year)
            ->where('status', 'delivered')
            ->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('Y');
            });

        $yearlyResult = [];
        foreach ($yearlyItems as $year => $yearlyCollections) {
            foreach ($yearlyCollections as $item) {
                $amount = $item->cart_info->sum('amount');
                isset($yearlyResult[$year]) ? $yearlyResult[$year] += $amount : $yearlyResult[$year] = $amount;
            }
        }

        $yearlyData = [];
        foreach ($yearlyResult as $year => $earnings) {
            $yearlyData[$year] = number_format($earnings, 2, '.', '');
        }

        return $yearlyData;
    }


    // public function weeklyIncomeChart(Request $request)
    // {
    //     $startOfWeek = now()->startOfWeek();
    //     $endOfWeek = now()->endOfWeek();

    //     $items = Order::with(['cart_info'])
    //         ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
    //         ->where('status', 'delivered')
    //         ->get()
    //         ->groupBy(function ($d) {
    //             return \Carbon\Carbon::parse($d->created_at)->format('W');
    //         });

    //     $result = [];
    //     foreach ($items as $week => $itemCollections) {
    //         foreach ($itemCollections as $item) {
    //             $amount = $item->cart_info->sum('amount');
    //             $weekNum = intval($week);
    //             isset($result[$weekNum]) ? $result[$weekNum] += $amount : $result[$weekNum] = $amount;
    //         }
    //     }

    //     $data = [];
    //     for ($i = 1; $i <= 52; $i++) {
    //         $data['Week ' . $i] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
    //     }
    //     return $data;
    // }

    // public function weeklyIncomeChart(Request $request){
    //     $startOfWeek = now()->startOfWeek();
    //     $endOfWeek = now()->endOfWeek();

    //     $items = Order::with(['cart_info'])
    //         ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
    //         ->where('status', 'delivered')
    //         ->get()
    //         ->groupBy(function($d){
    //             return Carbon::parse($d->created_at)->format('W');
    //         });

    //     $result = [];
    //     foreach($items as $week => $itemCollections){
    //         foreach($itemCollections as $item){
    //             $amount = $item->cart_info->sum('amount');
    //             $weekNum = intval($week);
    //             isset($result[$weekNum]) ? $result[$weekNum] += $amount : $result[$weekNum] = $amount;
    //         }
    //     }

    //     $data = [];
    //     for($i = 1; $i <= 52; $i++){
    //         $data['Week ' . $i] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
    //     }
    //     return $data;
    // }

    public function weeklyIncomeChart(Request $request){
        $year = \Carbon\Carbon::now()->year;

        $items = Order::with(['cart_info'])
            ->whereYear('created_at', $year)
            ->where('status', 'delivered')
            ->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->weekOfYear;
            });

        $result = [];
        foreach($items as $week => $itemCollections){
            foreach($itemCollections as $item){
                $amount = $item->cart_info->sum('amount');
                isset($result[$week]) ? $result[$week] += $amount : $result[$week] = $amount;
            }
        }

        $data = [];
        for ($i = 1; $i <= 52; $i++) {
            $weekStart = \Carbon\Carbon::now()->setISODate($year, $i)->startOfWeek()->format('F d');
            $weekEnd = \Carbon\Carbon::now()->setISODate($year, $i)->endOfWeek()->format('F d');
            $weekRange = $weekStart . ' - ' . $weekEnd;
            $data[$weekRange] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }

        return $data;
    }

    // public function yearlyEarningsChart(Request $request)
    // {
    //     $year = \Carbon\Carbon::now()->year;

    //     $items = Order::with(['cart_info'])
    //         ->whereYear('created_at', $year)
    //         ->where('status', 'delivered')
    //         ->get()
    //         ->groupBy(function ($d) {
    //             return \Carbon\Carbon::parse($d->created_at)->format('F Y'); // Group by month and year
    //         });

    //     $result = [];
    //     foreach ($items as $monthYear => $itemCollections) {
    //         foreach ($itemCollections as $item) {
    //             $amount = $item->cart_info->sum('amount');
    //             isset($result[$monthYear]) ? $result[$monthYear] += $amount : $result[$monthYear] = $amount;
    //         }
    //     }

    //     $data = [];
    //     $months = [
    //         'January', 'February', 'March', 'April', 'May', 'June',
    //         'July', 'August', 'September', 'October', 'November', 'December'
    //     ];

    //     foreach ($months as $month) {
    //         $monthYear = $month . ' ' . $year;
    //         $data[$monthYear] = (!empty($result[$monthYear])) ? number_format((float)($result[$monthYear]), 2, '.', '') : 0.0;
    //     }

    //     return $data;
    // }

    public function dailyEarningsChart(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;
        $month = \Carbon\Carbon::now()->month;

        $items = Order::with(['cart_info'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status', 'delivered')
            ->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('Y-m-d'); // Group by day
            });

        $result = [];
        foreach ($items as $day => $itemCollections) {
            foreach ($itemCollections as $item) {
                $amount = $item->cart_info->sum('amount');
                $result[$day] = $amount;
            }
        }

        return $result;
    }

    public function totalCartPrice( array $selectedItemsArray)
    {
        // Check if the user is authenticated
        if (auth()->check()) {

            $user_id = auth()->user()->id;

            // Calculate the total cart price based on selected items array and user ID
            $totalAmount = Cart::where('user_id', $user_id)
                ->where('order_id', null)
                ->whereIn('id', $selectedItemsArray)
                ->sum('amount');

            return $totalAmount;
        } else {
            // User is not authenticated, return 0 or handle the logic accordingly
            return 0;
        }
    }
}
