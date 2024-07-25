@extends('backend.layouts.master')

@section('title', 'Refund Detail')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Refund
            {{-- <a href="{{route('refund.pdf',$refund->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a> --}}
        </h5>
        <div class="card-body">
            @if ($refund)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Refund Amount.</th>
                            <th>Order Number</th>
                            <th>Client</th>
                            <th>status</th>
                            {{-- <th>Sub Total</th> --}}
                            {{-- <th>Charge</th> --}}
                            {{-- <th>Total Amount</th> --}}
                            {{-- <th>Status</th> --}}
                            {{-- <th>Location Info</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @php
                                $shipping_charge = DB::table('shippings')
                                    ->where('id', $refund->shipping_id)
                                    ->pluck('price');
                            @endphp
                            <td>{{ $refund->id }}</td>
                            <td>{{ $refund->refund_amount }}</td>
                            <td>{{ $refund->order->order_number }}</td>
                            <td>{{ $refund->user->first_name }} {{ $refund->user->last_name }}</td>
                            {{-- <td>{{$refund->status}}</td> --}}
                            @php
                                $refundStatusOptions = ['new', 'Pending', 'Processing', 'Refunded'];
                            @endphp
                            <td>
                                <form method="post" action="{{ route('refund.status.update', $refund->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()">
                                        @foreach ($refundStatusOptions as $option)
                                            <option value="{{ $option }}"
                                                {{ $refund->status == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td>
                                {{-- <a href="{{route('refund.refund.create',$refund->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="refund" data-placement="bottom"><i class="fas fa-edit"></i></a> --}}
                                {{-- <form method="POST" action="{{route('refund.destroy',[$refund->id])}}">
                  @csrf
                  @method('delete')
                      <button class="btn btn-danger btn-sm dltBtn" data-id={{$refund->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </form> --}}
                            </td>

                        </tr>
                    </tbody>
                </table>

                <section class="confirmation_part section_padding">
                    <div class="order_boxes">
                        <div class="row">
                            {{-- @php
                                dd($refund->photo);
                            @endphp --}}
                            <div class="col-lg-12 col-lx-4">
                                @if ($refund->order && $refund->order->cart)
                                    <div class="form-group">
                                        <label for="inputImages" class="col-form-label text-center">Product Image</label>
                                        <div class="row">
                                            @foreach ($refund->order->cart->take(1) as $item)
                                                <div class="col-md-6 mx-auto">
                                                    <div class="row">
                                                        <div class="col-md-6 text-center">
                                                            <img src="data:image/png;base64,{{ $item->product->photo }}"
                                                                alt="Product Image" class="img-fluid" style="width: 200px; height: 200px;">
                                                            <p class="mt-2">({{ $item->product->title }})</p>
                                                            <p class="mt-2">Actual Product Image</p>
                                                        </div>
                                                        <div class="col-md-6 text-center">
                                                            <img src="data:image/png;base64,{{ $refund->photo }}" alt="Refund Image"
                                                                class="img-fluid" style="width: 200px; height: 200px;">
                                                            <p class="mt-2">({{ $item->product->title }})</p>
                                                            <p class="mt-2">Refund Product Image</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                @endif
                                <div class="refund-info">
                                    <h4 class="text-center pb-4">REFUND INFORMATION</h4>
                                    <table class="table">
                                        <tr class="">
                                            <td>Refund ID</td>
                                            <td> : {{ $refund->id }}</td>
                                        </tr>
                                        <tr>
                                            <td>Refund Amount</td>
                                            <td> :₱ {{ number_format($refund->refund_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Order Number</td>
                                            <td> : {{ $refund->order->order_number }}</td>
                                        </tr>
                                        <tr>
                                            <td>Client who want to Refund</td>
                                            <td> : {{ $refund->user->first_name }} {{ $refund->user->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Refund Date</td>
                                            <td> : {{ $refund->created_at->format('D d M, Y') }} at
                                                {{ $refund->created_at->format('g : i a') }} </td>
                                        </tr>
                                        <tr>
                                            <td>Refund Status</td>
                                            <td> : {{ $refund->status }}</td>
                                        </tr>
                                        <tr>
                                            <td>Refund Description</td>
                                            <td> : {{ strip_tags($refund->description) }}</td>
                                        </tr>
                                        {{-- <tr>
                      @php
                          $shipping_charge=DB::table('shippings')->where('id',$refund->shipping_id)->pluck('price');
                      @endphp
                        <td>Shipping Charge</td>
                        <td> : ₱ {{number_format($shipping_charge[0],2)}}</td>
                    </tr> --}}
                                        {{-- <tr>
                        <td>Total Amount</td>
                        <td> : ₱ {{number_format($refund->total_amount,2)}}</td>
                    </tr> --}}
                                        {{-- <tr>
                      <td>Payment Method</td>
                      <td> : @if ($refund->payment_method == 'cod') Cash on Delivery @else Paypal @endif</td>
                    </tr> --}}
                                        {{-- <tr>
                        <td>Payment Status</td>
                        <td> : {{$refund->payment_status}}</td>
                    </tr> --}}
                                        {{-- <tr>
                    <td>Product Ordered</td>
                    <td>
                        @foreach ($refund->cart as $cartItem)
                            : {{$cartItem->product->title}} - Quantity: {{$cartItem->quantity}} : <a href="{{route('product-detail',$cartItem->product->slug)}}" target="_blank">Review This Product</a>
                            <br>
                        @endforeach
                    </td>
                  </tr> --}}
                                    </table>
                                </div>
                            </div>

                            {{-- <div class="col-lg-6 col-lx-4">
            <div class="shipping-info">
              <h4 class="text-center pb-4">SHIPPING INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Full Name</td>
                        <td> : {{$refund->first_name}} {{$refund->last_name}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td> : {{$refund->email}}</td>
                    </tr>
                    <tr>
                        <td>Phone No.</td>
                        <td> : {{$refund->phone}}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td> : {{$refund->address1}}, {{$refund->address2}}</td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td> : {{$refund->country}}</td>
                    </tr>
                    <tr>
                        <td>Post Code</td>
                        <td> : {{$refund->post_code}}</td>
                    </tr>
              </table>
            </div>
          </div> --}}
                        </div>
                    </div>
                </section>
            @endif

        </div>
    </div>
@endsection

@push('styles')
    <style>
        .refund-info,
        .shipping-info {
            background: #ECECEC;
            padding: 20px;
        }

        .refund-info h4,
        .shipping-info h4 {
            text-decoration: underline;
        }
    </style>
@endpush
