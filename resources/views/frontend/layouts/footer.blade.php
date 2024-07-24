<!-- Start Footer Area -->
<footer class="footer">
    <!-- Footer Top -->
    <div class="footer-top section">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-12">
                    <!-- Single Widget -->
                    <div class="single-footer about">
                        @php
                            $settings = DB::table('settings')->get();
                        @endphp
                        <p class="text">
                            @foreach ($settings as $data)
                                {{ $data->short_des }}
                            @endforeach
                        </p>
                        <p class="call">Got Question? Call us 24/7<span><a href="tel:123456789">
                                    @foreach ($settings as $data)
                                        {{ $data->phone }}
                                    @endforeach
                                </a></span></p>
                    </div>
                    <!-- End Single Widget -->
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <!-- Single Widget -->
                    <div class="single-footer links">
                        <h4>Information</h4>
                        <ul>
                            <li><a href="http://35.232.55.107/about-us">About Us</a></li>
                            <li><a href="{{ route('product-high-reviews') }}">Top Reviews</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        </ul>
                    </div>
                    <!-- End Single Widget -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Single Widget -->
                    <div class="single-footer social">
                        <h4>Get In Touch</h4>
                        <!-- Single Widget -->
                        <div class="contact">
                            <ul>
                                <li>
                                    @foreach ($settings as $data)
                                        {{ $data->address }}
                                    @endforeach
                                </li>
                                <li>
                                    @foreach ($settings as $data)
                                        {{ $data->email }}
                                    @endforeach
                                </li>
                                <li>
                                    @foreach ($settings as $data)
                                        {{ $data->phone }}
                                    @endforeach
                                </li>
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                        <!-- <div class="sharethis-inline-follow-buttons"></div> -->
                    </div>
                    <!-- End Single Widget -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Top -->
    <div class="copyright">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="left">
                            <p>Copyright © 2023 Ecommerce System.All Rights Reserved.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="right">
                            <img src="{{ asset('backend/img/payments.png') }}" alt="#">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- /End Footer Area -->

<!-- Jquery -->
{{-- <script src="{{asset('frontend/js/jquery.min.js')}}"></script> --}}
{{-- <script src="{{asset('frontend/js/jquery-migrate-3.0.0.js')}}"></script> --}}
{{-- <script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script> --}}
<!-- Popper JS -->
{{-- <script src="{{asset('frontend/js/popper.min.js')}}"></script> --}}
<!-- Bootstrap JS -->
{{-- <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script> --}}
<!-- Color JS -->
{{-- <script src="{{asset('frontend/js/colors.js')}}"></script> --}}
<!-- Slicknav JS -->
{{-- <script src="{{asset('frontend/js/slicknav.min.js')}}"></script> --}}
<!-- Owl Carousel JS -->
{{-- <script src="{{asset('frontend/js/owl-carousel.js')}}"></script> --}}
<!-- Magnific Popup JS -->
{{-- <script src="{{asset('frontend/js/magnific-popup.js')}}"></script> --}}
<!-- Waypoints JS -->
{{-- <script src="{{asset('frontend/js/waypoints.min.js')}}"></script> --}}
<!-- Countdown JS -->
{{-- <script src="{{asset('frontend/js/finalcountdown.min.js')}}"></script> --}}
<!-- Nice Select JS -->
{{-- <script src="{{asset('frontend/js/nicesellect.js')}}"></script> --}}
<!-- Flex Slider JS -->
{{-- <script src="{{asset('frontend/js/flex-slider.js')}}"></script> --}}
<!-- ScrollUp JS -->
{{-- <script src="{{asset('frontend/js/scrollup.js')}}"></script> --}}
<!-- Onepage Nav JS -->
{{-- <script src="{{asset('frontend/js/onepage-nav.min.js')}}"></script> --}}
{{-- Isotope --}}
{{-- <script src="{{asset('frontend/js/isotope/isotope.pkgd.min.js')}}"></script> --}}
<!-- Easing JS -->
{{-- <script src="{{asset('frontend/js/easing.js')}}"></script> --}}

<!-- Active JS -->
{{-- <script src="{{asset('frontend/js/active.js')}}"></script> --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Color JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.4.5/jscolor.min.js"></script>
<!-- Slicknav JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/jquery.slicknav.min.js"></script>
<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<!-- Magnific Popup JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<!-- Waypoints JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<!-- Countdown JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
<!-- Nice Select JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
<!-- Flex Slider JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/jquery.flexslider-min.js"></script>
<!-- ScrollUp JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/scrollup/2.4.1/jquery.scrollUp.min.js"></script>
<!-- Onepage Nav JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-one-page-nav/3.0.0/jquery.nav.min.js"></script>
<!-- Isotope -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>
<!-- Easing JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- Active JS -->
{{-- <script src="path/to/your/active.js"></script> --}}



@stack('scripts')
<script>
    /* =====================================
Template Name: Eshop
Author Name: Naimur Rahman
Author URI: http://www.wpthemesgrid.com/
Description: Eshop - eCommerce HTML5 Template.
Version:1.0
========================================*/
    /*=======================================
    [Start Activation Code]
    =========================================
    	01. Mobile Menu JS
    	02. Sticky Header JS
    	03. Search JS
    	04. Slider Range JS
    	05. Home Slider JS
    	06. Popular Slider JS
    	07. Quick View Slider JS
    	08. Home Slider 4 JS
    	09. CountDown
    	10. Flex Slider JS
    	11. Cart Plus Minus Button
    	12. Checkbox JS
    	13. Extra Scroll JS
    	14. Product page Quantity Counter
    	15. Video Popup JS
    	16. Scroll UP JS
    	17. Nice Select JS
    	18. Others JS
    	19. Preloader JS
    =========================================
    [End Activation Code]
    =========================================*/

    window.onload = () => {
            'use strict';

            if ('serviceWorker' in navigator) {
                navigator.serviceWorker
                    .register('./sw.js');
            }
        }
        (function($) {
            "use strict";
            $(document).on('ready', function() {

                /*====================================
                	Mobile Menu
                ======================================*/
                $('.menu').slicknav({
                    prependTo: ".mobile-nav",
                    duration: 300,
                    animateIn: 'fadeIn',
                    animateOut: 'fadeOut',
                    closeOnClick: true,
                });

                /*====================================
                03. Sticky Header JS
                ======================================*/
                jQuery(window).on('scroll', function() {
                    if ($(this).scrollTop() > 200) {
                        $('.header').addClass("sticky");
                    } else {
                        $('.header').removeClass("sticky");
                    }
                });

                /*=======================
                  Search JS JS
                =========================*/
                $('.top-search a').on("click", function() {
                    $('.search-top').toggleClass('active');
                });

                /*=======================
                  Slider Range JS
                =========================*/
                // $( function() {
                // 	$( "#slider-range" ).slider({
                // 	  range: true,
                // 	  min: 0,
                // 	  max: 1000,
                // 	  values: [ 120, 250 ],
                // 	  slide: function( event, ui ) {
                // 		$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                // 	  }
                // 	});
                // 	$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
                // 	  " - $" + $( "#slider-range" ).slider( "values", 1 ) );
                // } );

                /*=======================
                  Home Slider JS
                =========================*/
                $('.home-slider').owlCarousel({
                    items: 1,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    smartSpeed: 400,
                    animateIn: 'fadeIn',
                    animateOut: 'fadeOut',
                    autoplayHoverPause: true,
                    loop: true,
                    nav: true,
                    merge: true,
                    dots: false,
                    navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
                    responsive: {
                        0: {
                            items: 1,
                        },
                        300: {
                            items: 1,
                        },
                        480: {
                            items: 2,
                        },
                        768: {
                            items: 3,
                        },
                        1170: {
                            items: 4,
                        },
                    }
                });

                /*=======================
                  Popular Slider JS
                =========================*/
                $('.popular-slider').owlCarousel({
                    items: 1,
                    autoplay: true,
                    autoplayTimeout: 1000,
                    smartSpeed: 400,
                    animateIn: 'fadeIn',
                    animateOut: 'fadeOut',
                    autoplayHoverPause: true,
                    loop: true,
                    nav: true,
                    merge: true,
                    dots: false,
                    navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
                    responsive: {
                        0: {
                            items: 1,
                        },
                        300: {
                            items: 1,
                        },
                        480: {
                            items: 2,
                        },
                        768: {
                            items: 3,
                        },
                        1170: {
                            items: 4,
                        },
                    }
                });

                /*===========================
                  Quick View Slider JS
                =============================*/
                $('.quickview-slider-active').owlCarousel({
                    items: 1,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    smartSpeed: 400,
                    autoplayHoverPause: true,
                    nav: true,
                    loop: true,
                    merge: true,
                    dots: false,
                    navText: ['<i class=" ti-arrow-left"></i>', '<i class=" ti-arrow-right"></i>'],
                });

                /*===========================
                  Home Slider 4 JS
                =============================*/
                $('.home-slider-4').owlCarousel({
                    items: 1,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    smartSpeed: 400,
                    autoplayHoverPause: true,
                    nav: true,
                    loop: true,
                    merge: true,
                    dots: false,
                    navText: ['<i class=" ti-arrow-left"></i>', '<i class=" ti-arrow-right"></i>'],
                });

                /*====================================
                14. CountDown
                ======================================*/
                $('[data-countdown]').each(function() {
                    var $this = $(this),
                        finalDate = $(this).data('countdown');
                    $this.countdown(finalDate, function(event) {
                        $this.html(event.strftime(
                            '<div class="cdown"><span class="days"><strong>%-D</strong><p>Days.</p></span></div><div class="cdown"><span class="hour"><strong> %-H</strong><p>Hours.</p></span></div> <div class="cdown"><span class="minutes"><strong>%M</strong> <p>MINUTES.</p></span></div><div class="cdown"><span class="second"><strong> %S</strong><p>SECONDS.</p></span></div>'
                        ));
                    });
                });

                /*====================================
                16. Flex Slider JS
                ======================================*/
                (function($) {
                    'use strict';
                    $('.flexslider-thumbnails').flexslider({
                        animation: "slide",
                        controlNav: "thumbnails",
                    });
                })(jQuery);

                /*====================================
                  Cart Plus Minus Button
                ======================================*/
                var CartPlusMinus = $('.cart-plus-minus');
                CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
                CartPlusMinus.append('<div class="inc qtybutton">+</div>');
                $(".qtybutton").on("click", function() {
                    var $button = $(this);
                    var oldValue = $button.parent().find("input").val();
                    if ($button.text() === "+") {
                        var newVal = parseFloat(oldValue) + 1;
                    } else {
                        // Don't allow decrementing below zero
                        if (oldValue > 0) {
                            var newVal = parseFloat(oldValue) - 1;
                        } else {
                            newVal = 1;
                        }
                    }
                    $button.parent().find("input").val(newVal);
                });

                /*=======================
                  Extra Scroll JS
                =========================*/
                $('.scroll').on("click", function(e) {
                    var anchor = $(this);
                    $('html, body').stop().animate({
                        scrollTop: $(anchor.attr('href')).offset().top - 0
                    }, 900);
                    e.preventDefault();
                });

                /*===============================
                10. Checkbox JS
                =================================*/
                $('input[type="checkbox"]').change(function() {
                    if ($(this).is(':checked')) {
                        $(this).parent("label").addClass("checked");
                    } else {
                        $(this).parent("label").removeClass("checked");
                    }
                });

                /*==================================
                 12. Product page Quantity Counter
                 ===================================*/
                $('.qty-box .quantity-right-plus').on('click', function() {
                    var $qty = $('.qty-box .input-number');
                    var currentVal = parseInt($qty.val(), 10);
                    if (!isNaN(currentVal)) {
                        $qty.val(currentVal + 1);
                    }
                });
                $('.qty-box .quantity-left-minus').on('click', function() {
                    var $qty = $('.qty-box .input-number');
                    var currentVal = parseInt($qty.val(), 10);
                    if (!isNaN(currentVal) && currentVal > 1) {
                        $qty.val(currentVal - 1);
                    }
                });

                /*=====================================
                15.  Video Popup JS
                ======================================*/
                $('.video-popup').magnificPopup({
                    type: 'iframe',
                    removalDelay: 300,
                    mainClass: 'mfp-fade'
                });

                /*====================================
                	Scroll Up JS
                ======================================*/
                $.scrollUp({
                    scrollText: '<span><i class="fa fa-angle-up"></i></span>',
                    easingType: 'easeInOutExpo',
                    scrollSpeed: 900,
                    animation: 'fade'
                });

            });

            /*====================================
            18. Nice Select JS
            ======================================*/
            $('select').niceSelect();

            /*=====================================
             Others JS
            ======================================*/
            // $( function() {
            // 	$( "#slider-range" ).slider({
            // 		range: true,
            // 		min: 0,
            // 		max: 1000,
            // 		values: [ 0, 1000 ],
            // 		slide: function( event, ui ) {
            // 			$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
            // 		}
            // 	});
            // 	$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
            // 	  " - $" + $( "#slider-range" ).slider( "values", 1 ) );
            // } );

            /*=====================================
              Preloader JS
            ======================================*/
            //After 2s preloader is fadeOut
            $('.preloader').delay(2000).fadeOut('slow');
            setTimeout(function() {
                //After 2s, the no-scroll class of the body will be removed
                $('body').removeClass('no-scroll');
            }, 2000); //Here you can change preloader time

        })(jQuery);


    setTimeout(function() {
        $('.alert').slideUp();
    }, 5000);
    $(function() {
        // ------------------------------------------------------- //
        // Multi Level dropdowns
        // ------------------------------------------------------ //
        $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
            event.preventDefault();
            event.stopPropagation();

            $(this).siblings().toggleClass("show");


            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                $('.dropdown-submenu .show').removeClass("show");
            });

        });
    });
</script>
