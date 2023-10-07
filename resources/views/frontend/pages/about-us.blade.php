@extends('frontend.layouts.master')

@section('title','Padilla Gowns and Barongs|| About Us')

@section('main-content')

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index1.html">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="blog-single.html">About Us</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- About Us -->
	<section class="about-us section">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-12">
						<div class="about-content">
							@php
								$settings=DB::table('settings')->get();
							@endphp
							<h3>Welcome To <span>Padilla Gowns and Barongs</span></h3>
                            <p>Padilla Gowns and Barongs, nestled in the heart of San Carlos City, Pangasinan, stands as a premier destination for those in search of impeccable attire. This revered establishment has earned its reputation as one of the finest rental shops in the region, offering an extensive collection of barongs and gowns that seamlessly blend tradition and modernity. Whether it's a traditional Filipino celebration or a grand formal event, Padilla's commitment to quality and style ensures that every customer finds their perfect ensemble. The warm hospitality and personalized service provided by the Padilla family make this boutique a cherished gem, leaving visitors with unforgettable memories and a sense of sartorial satisfaction. For those seeking elegance and sophistication in San Carlos City, Padilla Gowns and Barongs remains the ultimate choice.</p>
							{{-- <p>@foreach($settings as $data) {{$data->description}} @endforeach</p> --}}
							<div class="button">
								<!-- {{-- <a href="{{route('blog')}}" class="btn">Our Blog</a> --}} -->
								<a href="{{route('contact')}}" class="btn primary">Contact Us</a>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="about-img overlay">
							{{-- <div class="button">
								<a href="#" class="video video-popup mfp-iframe"><i class="fa fa-play"></i></a>
							</div> --}}
                            <img src="{{ asset('images/icon/Padilla_gowns.jpg') }}" alt="">
							{{-- <img src="@foreach($settings as $data) {{$data->photo}} @endforeach" alt="@foreach($settings as $data) {{$data->photo}} @endforeach"> --}}
						</div>
					</div>
				</div>
			</div>
	</section>
	<!-- End About Us -->

	<!-- Start Team -->
	{{-- <section id="team" class="team section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-title">
						<h2>Our Expert Team</h2>
						<p>Business consulting excepteur sint occaecat cupidatat consulting non proident, sunt in culpa qui officia deserunt laborum market. </p>
					</div>
				</div>
			</div>

		</div>
	</section> --}}
	<!--/ End Team Area -->

	<!-- Start Shop Services Area -->
	{{-- <section class="shop-services section">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>Free shiping</h4>
						<p>Orders over $100</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>Free Return</h4>
						<p>Within 30 days returns</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>Sucure Payment</h4>
						<p>100% secure payment</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-tag"></i>
						<h4>Best Peice</h4>
						<p>Guaranteed price</p>
					</div>
					<!-- End Single Service -->
				</div>
			</div>
		</div>
	</section> --}}
	<!-- End Shop Services Area -->

	@include('frontend.layouts.newsletter')
@endsection
