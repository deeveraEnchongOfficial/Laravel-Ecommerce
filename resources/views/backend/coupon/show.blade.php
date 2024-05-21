@extends('backend.layouts.master')

@section('title','Coupon Detail')

@section('main-content')
<div class="card">
<h5 class="card-header">Coupon
     {{-- <a href="{{route('coupon.pdf',$coupon->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a> --}}
  </h5>
  <div class="card-body">
    @if($coupon)
    <table class="table table-striped table-hover">
      @php
          $shipping_charge=DB::table('shippings')->where('id',$coupon->shipping_id)->pluck('price');
      @endphp
      <thead>
        <tr>
            <th>S.N.</th>
            <th>Code</th>
            <th>Type</th>
            <th>Value</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <td>{{$coupon->id}}</td>
            <td>{{$coupon->code}}</td>
            <td>{{$coupon->type}}</td>
            <td>{{$coupon->value}}</td>
            <td>{{$coupon->status}}</td>
            <td>
                <a href="{{route('coupon.edit',$coupon->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                <form method="POST" action="{{route('coupon.destroy',[$coupon->id])}}">
                  @csrf
                  @method('delete')
                      <button class="btn btn-danger btn-sm dltBtn" data-id={{$coupon->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>

        </tr>
      </tbody>
    </table>

    <section class="confirmation_part section_padding">
      <div class="order_boxes">
        <div class="row">
          <div class="col-lg-12 col-lx-4">
            <div class="coupon-info">
              <h4 class="text-center pb-4">COUPON INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Coupon Code</td>
                        <td> : {{$coupon->code}}</td>
                    </tr>
                    <tr class="">
                      <td>Coupon Type</td>
                      <td> : {{$coupon->type}}</td>
                    </tr>
                    <tr class="">
                      <td>Coupon Value</td>
                      <td> : {{$coupon->value}}</td>
                    </tr>
                    <tr class="">
                      <td>Coupon Status</td>
                      <td> : {{$coupon->status}}</td>
                    </tr>
                    <tr>
                      <td>User Claimed</td>
                      <td>
                          @foreach ($orders as $order)
                              : {{$order->user->first_name}} {{$order->user->last_name}}
                              <br>
                          @endforeach
                      </td>
                    </tr>
                    {{-- @php
                    // $auth_user_id = Auth::user()->id;
                    // $orders = \Order::where('user_id', $auth_user_id)
                    //         ->where('coupon_id', $coupon->id)
                    //         ->get();

                        dd($orders);
                    @endphp --}}
              </table>
            </div>
          </div>

        </div>
      </div>
    </section>
    @endif

  </div>
</div>
@endsection

@push('styles')
<style>
    .coupon-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .coupon-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
