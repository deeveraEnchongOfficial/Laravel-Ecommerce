@extends('frontend.layouts.master')

@section('title', 'Checkout page')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Checkout -->
    <section class="shop checkout section">
        <div class="container">
            {{-- @php
                dd($selectedItemsArray);
            @endphp --}}
            <form class="form" method="POST" action="{{ route('cart.order') }}">
                @csrf
                <div class="row">

                    <div class="col-lg-8 col-12">
                        <div class="checkout-form">
                            <h2>Make Your Checkout Here</h2>
                            <p>Please register in order to checkout more quickly</p>
                            <!-- Form -->
                            <div class="row">
                                <input type="hidden" name="selected_items" value="{{ implode(',', $selectedItemsArray) }}">
                                <input type="hidden" name="coupon" value="{{ number_format(session('coupon')['id']) }}">
                                <input type="hidden" name="shipping" value="{{ Auth()->user()->municipality_name }}">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>First Name<span>*</span></label>
                                        <input type="text" name="first_name" placeholder=""
                                            value="{{ Auth()->user()->first_name }}" readonly>
                                        @error('first_name')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Last Name<span>*</span></label>
                                        <input type="text" name="last_name" placeholder=""
                                            value="{{ Auth()->user()->last_name }}" readonly>
                                        @error('last_name')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Email Address<span>*</span></label>
                                        <input type="email" name="email" placeholder=""
                                            value="{{ Auth()->user()->email }}" readonly>
                                        @error('email')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Phone Number <span>*</span></label>
                                        <input type="number" name="phone" placeholder="" required
                                            value="{{ Auth()->user()->phone_number }}">
                                        @error('phone')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Province <span>*</span></label>
                                        <input type="text" name="address1" placeholder=""
                                            value="{{ Auth()->user()->address }}">
                                        @error('address1')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <input type="text" name="post_code" placeholder=""
                                            value="{{ old('post_code') }}">
                                        @error('post_code')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Active Location <span>*</span></label>
                                        <input type="text" name="address1" placeholder=""
                                            value="{{ Helper::getActiveLocation() == 'Setup your Location' ? 'Setup Your Location on Locations Dashboard' : Helper::getActiveLocation() }}" readOnly>
                                        @error('address1')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                        <small>Setup location? <a href="{{ route('user-profile') }}"><u>here</u></a></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group d-none">
                                        <label>Address Line 2</label>
                                        <input type="text" name="address2" placeholder="" value="{{ old('address2') }}">
                                        @error('address2')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group d-none">
                                        <label>Address Line 2</label>
                                        <input type="number" name="shipping" placeholder="" value="{{ Helper::getShippingPrice(Auth()->user()->id) }}">
                                        @error('address2')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <!--/ End Form -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="order-details">
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2>CART TOTALS</h2>
                                <div class="content">
                                    <ul>
                                        <li class="order_subtotal"
                                            data-price="{{ Helper::totalCartPrice2nd($selectedItemsArray) }}">Cart
                                            Subtotal<span>₱{{ number_format(Helper::totalCartPrice2nd($selectedItemsArray), 2) }}</span>
                                        </li>
                                        {{-- {{Auth()->user()->address}} --}}
                                        <li class="shipping">
                                            Shipping Cost
                                            @if(Helper::getActiveLocation(Auth()->user()->id) === 'Setup your Location')
                                            <span>Setup Your Location</span>
                                        @else
                                            <span>{{Helper::fetchDistanceMatrixWithUnit(Auth()->user()->id)}} - ₱{{Helper::getShippingPrice(Auth()->user()->id)}}</span>
                                        @endif
                                            {{-- <span>{{Helper::fetchDistanceMatrixWithUnit()}} - ₱{{Helper::getShippingPrice()}}</span> --}}
                                        </li>
                                        @if (session('coupon'))
                                            {{-- <li class="coupon_price" data-price="{{ session('coupon')['value'] }}">You {{number_format(session('coupon')['id'])}} Save<span>₱{{number_format(session('coupon')['value'],2)}}</span></li> --}}
                                            <li class="coupon_price" data-price="{{ session('coupon')['value'] }}">You
                                                Save<span>₱{{ number_format(session('coupon')['value'], 2) }}</span></li>
                                        @endif
                                        @php
                                            // dd(Helper::getShippingPrice());
                                            // dd(Helper::getActiveLocation());
                                            $total_amount = Helper::totalCartPrice();
                                            if (!$selectedItemsArray[0] == '') {
                                                $total_amount = Helper::totalCartPrice2nd($selectedItemsArray);
                                                // dd($total_amount);
                                            } else {
                                                $total_amount = Helper::totalCartPrice();
                                            }
                                            // dd($total_amount);
                                            if (session('coupon')) {
                                                $total_amount = $total_amount - session('coupon')['value'];
                                            }
                                            $total_amount = $total_amount  + Helper::getShippingPrice(Auth()->user()->id);
                                            // $total_amount = $total_amount;
                                        @endphp
                                        @if (session('coupon'))
                                            <li class="last" id="order_total_price">
                                                Total<span>₱{{ number_format($total_amount, 2) }}</span></li>
                                        @else
                                            <li class="last" id="order_total_price">
                                                Total<span>₱{{ number_format($total_amount, 2) }}</span></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <!--/ End Order Widget -->
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2>Payments</h2>
                                <div class="content">
                                    <div class="checkbox">
                                        {{-- <label class="checkbox-inline" for="1"><input name="updates" id="1" type="checkbox"> Check Payments</label> --}}
                                        <form-group>
                                            <input name="payment_method" type="radio" value="cod" checked> <label> Cash
                                                On Delivery</label><br>
                                            <!-- <input name="payment_method"  type="radio" value="paypal"> <label> PayPal</label> -->
                                        </form-group>

                                    </div>
                                </div>
                            </div>
                            <!--/ End Order Widget -->
                            <!-- Payment Method Widget -->
                            <div class="single-widget payement">
                                <!-- <div class="content">
                                            <img src="{{ 'backend/img/payment-method.png' }}" alt="#">
                                        </div> -->
                            </div>
                            <!--/ End Payment Method Widget -->
                            <!-- Button Widget -->
                            <div class="single-widget get-button">
                                <div class="content">
                                    <div class="button">
                                        @if(Helper::getActiveLocation() === 'Setup your Location')
                                            <button type="submit" class="btn" disabled>Setup Your Location</button>
                                        @else
                                            <button type="submit" class="btn">Place Order</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--/ End Button Widget -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!--/ End Checkout -->

    <!-- Start Shop Newsletter  -->
    <section class="shop-newsletter section">
        <div class="container">
            <div class="inner-top">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <!-- Start Newsletter Inner -->
                        <div class="inner">
                            <h4>Newsletter</h4>
                            <p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
                            <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
                                <input name="EMAIL" placeholder="Your email address" required="" type="email">
                                <button class="btn">Subscribe</button>
                            </form>
                        </div>
                        <!-- End Newsletter Inner -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Newsletter -->
@endsection
@push('styles')
    <style>
        li.shipping {
            display: inline-flex;
            width: 100%;
            font-size: 14px;
        }

        li.shipping .input-group-icon {
            width: 100%;
            margin-left: 10px;
        }

        .input-group-icon .icon {
            position: absolute;
            left: 20px;
            top: 0;
            line-height: 40px;
            z-index: 3;
        }

        .form-select {
            height: 30px;
            width: 100%;
        }

        .form-select .nice-select {
            border: none;
            border-radius: 0px;
            height: 40px;
            background: #f6f6f6 !important;
            padding-left: 45px;
            padding-right: 40px;
            width: 100%;
        }

        .list li {
            margin-bottom: 0 !important;
        }

        .list li:hover {
            background: #F7941D !important;
            color: white !important;
        }

        .form-select .nice-select::after {
            top: 14px;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('frontend/js/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("select.select2").select2();
        });
        $('select.nice-select').niceSelect();
    </script>
    <script>
        function showMe(box) {
            var checkbox = document.getElementById('shipping').style.display;
            // alert(checkbox);
            var vis = 'none';
            if (checkbox == "none") {
                vis = 'block';
            }
            if (checkbox == "block") {
                vis = "none";
            }
            document.getElementById(box).style.display = vis;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.shipping select[name=shipping]').change(function() {
                let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
                let subtotal = parseFloat($('.order_subtotal').data('price'));
                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                // alert(coupon);
                $('#order_total_price span').text('₱' + (subtotal + cost - coupon).toFixed(2));
            });

        });
    </script>
@endpush
