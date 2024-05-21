@extends('frontend.layouts.master')

@section('title', 'Padilla Gowns and Barongs || Register Page')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Register</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shop Login -->
    <section class="shop login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <h2>Register</h2>
                        <p>Please register in order to checkout more quickly</p>
                        <!-- Form -->
                        <form class="form" method="post" action="{{route('register.submit')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name<span>*</span></label>
                                        <input type="text" name="first_name" placeholder="" required="required" value="{{ old('first_name') }}">
                                        @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name<span>*</span></label>
                                        <input type="text" name="last_name" placeholder="" required="required" value="{{ old('last_name') }}">
                                        @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>User Name<span>*</span></label>
                                        <input type="text" name="name" placeholder="" required="required" value="{{old('name')}}">
                                        @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Your Email<span>*</span></label>
                                        <input type="text" name="email" placeholder="" required="required" value="{{old('email')}}">
                                        @error('email')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Phone Number<span>*</span></label>
                                        <input type="number" name="phone_number" placeholder="" required="required" value="{{old('phone_number')}}">
                                        @error('phone_number')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="municipality_name" class="form-label">Municipality<span>*</span></label>
                                    <div class="form-group">
                                        <select class="form-control" name="municipality_name" id="municipality_name" required="required">
                                            <option value="" selected disabled>Select a municipality</option>

                                            @php
                                                $shippings = \App\Models\Shipping::all();
                                            @endphp

                                            @foreach($shippings as $shipping)
                                                <option value="{{ $shipping->id }}" @if(old('municipality_name') == $shipping->id) selected @endif>
                                                    {{ $shipping->municipality_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('municipality_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Province<span>*</span></label>
                                        <input type="text" name="address" placeholder="" required="required" value="{{old('address')}}">
                                        @error('address')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Your Password<span>*</span></label>
                                        <input type="password" name="password" placeholder="" required="required" value="{{old('password')}}">
                                        @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Confirm Password<span>*</span></label>
                                        <input type="password" name="password_confirmation" placeholder="" required="required" value="{{old('password_confirmation')}}">
                                        @error('password_confirmation')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="checkbox-inline" style="display: flex; align-items: center;">
                                        <input id="terms" name="terms" type="checkbox" style="transform: scale(1);" required>
                                        Terms and Conditions
                                    </label>
                                </div>
                                <div class="col-12">
                                    <div class="form-group login-btn">
                                        <button class="btn" id="registerButton" type="submit">Register</button>
                                        <a href="{{route('login.form')}}" class="btn">Login</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
<!-- Add this modal code at the end of your registration view -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mt-5" role="document">
        <div class="modal-content">
            <!-- Terms and Conditions Content -->
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center mt-5">
                <div class="modal-body text-center mt-5">
                    <p>By registering, you agree to abide by our terms and conditions. Please read them carefully before proceeding.</p>
                    <!-- Add any additional terms and conditions content here -->
                </div>
            </div>

            <!-- Your registration form goes here -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Accecpt</button>
            </div>

            {{-- <form class="form" method="post" action="{{route('register.submit')}}" id="registerForm">
                @csrf
                <!-- Your form fields go here -->

                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary">Register</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form> --}}
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .shop.login .form .btn{
        margin-right:0;
    }
    .btn-facebook{
        background:#39579A;
    }
    .btn-facebook:hover{
        background:#073088 !important;
    }
    .btn-github{
        background:#444444;
        color:white;
    }
    .btn-github:hover{
        background:black !important;
    }
    .btn-google{
        background:#ea4335;
        color:white;
    }
    .btn-google:hover{
        background:rgb(243, 26, 26) !important;
    }
</style>
@endpush

@push('scripts')
<!-- Add these lines to your layout file or master blade file -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('#terms').click(function () {
            $('#termsModal').modal('show'); // Show the terms modal
        });

        // Handle form submission inside the modal
        $('#registerForm').submit(function (e) {
            // You can perform any additional validation or actions here before submitting the form
            // ...

            // The form will submit naturally without preventing it
        });
    });
</script>
{{-- <script>
    $(document).ready(function () {
        // Show the terms modal when the user clicks the register button
        $('form').submit(function (e) {
            e.preventDefault(); // Prevent the form submission
            $('#termsModal').modal('show'); // Show the terms modal
        });
    });
</script> --}}
@endpush
