@extends('frontend.layouts.master')

@section('title', 'Padilla Gowns and Barongs || Contact Us')

@section('main-content')
    <!-- Breadcrumbs -->
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
                            <h3>Write us a message @auth @else<span style="font-size:12px;" class="text-danger">[You
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
                                                placeholder="Enter your name" value="{{ Auth::user()->name }}" readonly>
                                        @else
                                            <input name="name" id="name" type="text"
                                                placeholder="Enter your name">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Your Subject<span>*</span></label>
                                        <input name="subject" type="text" id="subject" placeholder="Enter Subject">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Your Email<span>*</span></label>
                                        @if (Auth::check())
                                            <input name="email" type="email" id="email"
                                                placeholder="Enter email address" value="{{ Auth::user()->email }}"
                                                readonly>
                                        @else
                                            <input name="email" type="email" id="email"
                                                placeholder="Enter email address">
                                        @endif
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
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group message">
                                        <label>Your Message<span>*</span></label>
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

<!-- Map Section -->
<div class="map-section">
    <div id="myMap">
        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14130.857353934944!2d85.36529494999999!3d27.6952226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sne!2snp!4v1595323330171!5m2!1sne!2snp" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> -->
    </div>
</div>
<!--/ End Map Section -->

<!-- Start Shop Newsletter  -->
@include('frontend.layouts.newsletter')
<!-- End Shop Newsletter -->

<!-- Contact Success Modal -->
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
            <div class="modal-body d-flex justify-content-center align-items-center">
                <p class="text-success" style="font-size: 24px; text-align: center;">
                    Your message is successfully sent...
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Contact Error Modal -->
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
                <p class="text-warning" style="font-size: 24px; text-align: center;">
                    Something went wrong.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .modal-dialog {
        width: 40%;
        /* Reduce the width of the modal */
        max-width: 100%;
        /* Ensure it is responsive */
        margin: auto;
    }

    .modal-content {
        border-radius: 10px;
        /* Optional: Adds a bit of rounded corners */
    }

    .modal-body p {
        font-size: 24px;
        /* Increase the font size of the message */
        text-align: center;
        /* Center the message */
    }

    .modal-header h2 {
        text-align: center;
        /* Center the header text */
        width: 100%;
        /* Ensure the header is centered across the modal */
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/contact.js') }}"></script>

<script>
    // Manually close modals if they don't close automatically
    $('.modal').on('click', '.close', function() {
        $(this).closest('.modal').modal('hide');
    });
</script>
@endpush
