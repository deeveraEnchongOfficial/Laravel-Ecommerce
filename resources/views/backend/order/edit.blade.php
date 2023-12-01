@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
  <h5 class="card-header">Order Edit</h5>
  <div class="card-body">
    <form action="{{route('order.update',$order->id)}}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="status">Status :</label>
        <select name="status" id="" class="form-control" {{ ($order->status == 'delivered') ? 'disabled' : '' }} >
            <option value="">--Select Status--</option>
            <option value="new" {{ ($order->status == 'new') ? 'selected' : '' }}>New</option>
            <option value="processing" {{ ($order->status == 'processing') ? 'selected' : '' }}>Processing</option>
            <option value="shipped" {{ ($order->status == 'shipped') ? 'selected' : '' }}>Shipped</option>
            <option value="delivered" {{ ($order->status == 'delivered') ? 'selected' : '' }}>Delivered</option>
            <option value="cancel" {{ ($order->status == 'cancel') ? 'selected' : '' }}>Cancel</option>
        </select>
    </div>
      @php
      $delivery_users = DB::table('users')
                        ->where('role', 'delivery_user')
                        ->where('status', 'active')
                        ->get();
      @endphp

      <div class="form-group">
          <label for="status">Deliver By:</label>
          <select name="deliver_by" id="status" class="form-control">
              <option value="">--Select Delivery User--</option>
              @foreach($delivery_users as $user)
                  <option value="{{ $user->id }}" {{(($order->deliver_by) ? 'selected' : '')}}>{{ $user->name }}</option>
              @endforeach
          </select>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
