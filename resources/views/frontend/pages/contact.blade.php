<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tag -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Title Tag  -->
    <title>@yield('title')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/icon/Padilla_gowns_new.png">
    <!-- Web Font -->
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
        rel="stylesheet">

    {{-- <link rel="stylesheet" href="frontend/css/bootstrap.css')}}"> --}}
    <link rel="stylesheet" href="frontend/css/bootstrap.css">
    <!-- StyleSheet -->
    <link rel="manifest" href="/manifest.json">
    <!-- Bootstrap -->
    {{-- <link rel="stylesheet" href="frontend/css/bootstrap.css')}}"> --}}
    {{-- <link rel="stylesheet" href="../../../../public/frontend/css/bootstrap.css"> --}}
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="frontend/css/magnific-popup.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="frontend/css/font-awesome.css">
    <!-- Fancybox -->
    <link rel="stylesheet" href="frontend/css/jquery.fancybox.min.css">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="frontend/css/themify-icons.css">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="frontend/css/niceselect.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="frontend/css/animate.css">
    <!-- Flex Slider CSS -->
    <link rel="stylesheet" href="frontend/css/flex-slider.min.css">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="frontend/css/owl-carousel.css">
    <!-- Slicknav -->
    <link rel="stylesheet" href="frontend/css/slicknav.min.css">
    <!-- Jquery Ui -->
    <link rel="stylesheet" href="frontend/css/jquery-ui.css">

    <!-- Eshop StyleSheet -->
    <link rel="stylesheet" href="frontend/css/reset.css">
    <link rel="stylesheet" href="frontend/css/style.css">
    <link rel="stylesheet" href="frontend/css/responsive.css">


</head>

<style>
    .modal-dialog .modal-content .modal-header {
        position: initial;
        padding: 10px 20px;
        border-bottom: 1px solid #e9ecef;
    }

    .modal-dialog .modal-content .modal-body {
        height: 100px;
        padding: 10px 20px;
    }

    .modal-dialog .modal-content {
        width: 50%;
        border-radius: 0;
        margin: auto;
    }
</style>

<body class="js">
    <div>

        @include('frontend.layouts.notification')
        <!-- Header -->
        @include('frontend.layouts.header')
        <!--/ End Header -->

        <div class="breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="bread-inner">
                            <ul class="bread-list">
                                <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                                <li class="active"><a href="javascript:void(0);">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->

        <!-- Start Contact -->
        <section id="contact-us" class="contact-us section">
            <div class="container">
                <div class="contact-head">
                    <div class="row">
                        <div class="col-lg-8 col-12">
                            <div class="form-main">
                                <div class="title">
                                    @php
                                        $settings = DB::table('settings')->get();
                                    @endphp
                                    <h4>Get in touch</h4>
                                <h3>Write us a message @auth @else<span style="font-size:12px;"
                                            class="text-danger">[You
                                        need to login first]</span>@endauth
                                </h3>
                            </div>
                            <form class="form-contact form contact_form" method="post"
                                action="{{ route('contact.store') }}" id="contactForm" novalidate="novalidate">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Your Name<span>*</span></label>
                                            @if (Auth::check())
                                                <input name="name" id="name" type="text"
                                                    placeholder="Enter your name" value="{{ Auth::user()->name }}"
                                                    readonly>
                                            @else
                                                <input name="name" id="name" type="text"
                                                    placeholder="Enter your name">
                                            @endif
                                            {{-- <input name="name" id="name" type="text"
                                                placeholder="Enter your name" value="{{ Auth()->user()->name }}" readonly> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Your Subjects<span>*</span></label>
                                            <input name="subject" type="text" id="subject"
                                                placeholder="Enter Subject">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Your Email<span>*</span></label>
                                            @if (Auth::check())
                                                <input name="email" type="email" id="email"
                                                    placeholder="Enter email address"
                                                    value="{{ Auth()->user()->email }}" readonly>
                                            @else
                                                <input name="email" type="email" id="email"
                                                    placeholder="Enter email address">
                                            @endif
                                            {{-- <input name="email" type="email" id="email"
                                                placeholder="Enter email address" value="{{ Auth()->user()->email }}"
                                                readonly> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Your Phone<span>*</span></label>
                                            @if (Auth::check() && Auth()->user()->phone_number != '')
                                                <input id="phone" name="phone" type="number"
                                                    placeholder="Enter your phone"
                                                    value="{{ Auth()->user()->phone_number }}" readonly>
                                            @else
                                                <input id="phone" name="phone" type="number"
                                                    placeholder="Enter your phone">
                                            @endif
                                            {{-- <input id="phone" name="phone" type="number"
                                                placeholder="Enter your phone" value="{{ Auth()->user()->phone_number }}"
                                                readonly> --}}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group message">
                                            <label>your message<span>*</span></label>
                                            <textarea name="message" id="message" cols="30" rows="9" placeholder="Enter Message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group button">
                                            <button type="submit" class="btn ">Send Message</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="single-head">
                            <div class="single-info">
                                <i class="fa fa-phone"></i>
                                <h4 class="title">Call us Now:</h4>
                                <ul>
                                    <li>
                                        @foreach ($settings as $data)
                                            {{ $data->phone }}
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                            <div class="single-info">
                                <i class="fa fa-envelope-open"></i>
                                <h4 class="title">Email:</h4>
                                <ul>
                                    <li><a href="mailto:info@yourwebsite.com">
                                            @foreach ($settings as $data)
                                                {{ $data->email }}
                                            @endforeach
                                        </a></li>
                                </ul>
                            </div>
                            <div class="single-info">
                                <i class="fa fa-location-arrow"></i>
                                <h4 class="title">Our Address:</h4>
                                <ul>
                                    <li>
                                        @foreach ($settings as $data)
                                            {{ $data->address }}
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Contact -->

    <!-- Start Shop Newsletter  -->
    @include('frontend.layouts.newsletter')
    <!-- End Shop Newsletter -->
    <!--================Contact Success  =================-->
    <div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-success">Thank you!</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-success">Your message is successfully sent...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals error -->
    <div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-warning">Sorry!</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-warning">Something went wrong.</p>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.layouts.footer')
</div>

</body>

<script src = "frontend/js/jquery.form.js" ></script>
<script src="frontend/js/jquery.validate.min.js"></script>
<script src="frontend/js/contact.js"></script>

</html>




{{--

@extends('frontend.layouts.master')

@section('title', 'Padilla Gowns and Barongs || Contact Us')

@section('main-content')
    <!-- Breadcrumbs -->

@endsection

@push('styles')
<style>
    .modal-dialog .modal-content .modal-header {
        position: initial;
        padding: 10px 20px;
        border-bottom: 1px solid #e9ecef;
    }

    .modal-dialog .modal-content .modal-body {
        height: 100px;
        padding: 10px 20px;
    }

    .modal-dialog .modal-content {
        width: 50%;
        border-radius: 0;
        margin: auto;
    }
</style>
@endpush
@push('scripts')
<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/contact.js') }}"></script>
@endpush --}}
