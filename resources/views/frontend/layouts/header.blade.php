<header class="header shop">
    <!-- Topbar -->
    <!-- <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">

                    <div class="top-left">

                    </div>

                </div>
                <div class="col-lg-6 col-md-12 col-12">

                    <div class="right-content">
                        <ul class="list-main">
                            {{-- <li><i class="ti-location-pin"></i> <a href="{{ route('order.track') }}">Track Order</a></li> --}}
                            {{-- <li><i class="ti-alarm-clock"></i> <a href="#">Daily deal</a></li> --}}
                            @auth
                                                @if (Auth::user()->role == 'admin')
    <li><i class="ti-user"></i> <a href="{{ route('admin') }}" target="_blank">Dashboard</a></li>
@elseif(Auth::user()->role == 'delivery_user')
    <li><i class="ti-user"></i> <a href="{{ route('delivery_user') }}" target="_blank">Editor Dashboard</a></li>
@else
    <li><i class="ti-user"></i> <a href="{{ route('user') }}" target="_blank">Dashboard</a></li>
    @endif
                                                <li><i class="ti-power-off"></i> <a href="{{ route('user.logout') }}">Logout</a></li>
@else
    <li><i class="ti-power-off"></i><a href="{{ route('login.form') }}">Login /</a> <a href="{{ route('register.form') }}">Register</a></li>
                            @endauth
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div> -->
    <!-- End Topbar -->
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo">
                        @php
                            $settings = DB::table('settings')->get();
                        @endphp
                        <a href="{{ route('home') }}"><img src="{{ asset('images/icon/Padilla_gowns_new.png') }}"
                                alt="logo" width="80" height="80" style="border-radius: 10px;"></a>
                    </div>
                    <!--/ End Logo -->
                    <!-- Search Form -->
                    <div class="search-top">
                        <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                        <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form">
                                <input type="text" placeholder="Search here..." name="search">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                    </div>
                    <!--/ End Search Form -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <select>
                                <option>All Category</option>
                                @foreach (Helper::getAllCategory() as $cat)
                                    <option>{{ $cat->title }}</option>
                                @endforeach
                            </select>
                            <form method="POST" action="{{ route('product.search') }}">
                                @csrf
                                <input name="search" placeholder="Search Products Here....." type="search">
                                <button class="btnn" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="sinlge-bar shopping">
                                @if (Auth::user())
                                    @if (Auth::user()->role == 'admin')
                                        <a href="{{ route('all.notification') }}" class="single-icon"><i
                                                class="fa fa-bell-o"></i>
                                            <span
                                                class="total-count">{{ count(Auth::user()->unreadNotifications) }}</span></a>
                                    @elseif(Auth::user()->role == 'user')
                                        <a href="{{ route('user.all.notification') }}" class="single-icon"><i
                                                class="fa fa-bell-o"></i>
                                            <span class="total-count">0</span></a>
                                    @endif
                                @endif
                                {{-- @if (Auth::user()->role == 'admin')
                                    <a href="{{ route('all.notification') }}" class="single-icon"><i class="fa fa-bell-o"></i>
                                        <span class="total-count">{{ count(Auth::user()->unreadNotifications) }}</span></a>
                                @else
                                    <a href="{{ route('user.all.notification') }}" class="single-icon"><i class="fa fa-bell-o"></i>
                                        <span class="total-count">0</span></a>
                                @endif --}}
                                {{-- <span class="total-count">{{ count(Auth::user()->unreadNotifications) }}</span></a> --}}
                                <!-- Shopping Item -->
                                @auth
                                    <div class="shopping-item">
                                        <div class="dropdown-cart-header">
                                            @if (count(Auth::user()->unreadNotifications) > 5)
                                                <span data-count="5" class="count">5+</span>
                                            @else
                                                <span class="count"
                                                    data-count="{{ count(Auth::user()->unreadNotifications) }}">{{ count(Auth::user()->unreadNotifications) }}
                                                    Items</span>
                                            @endif
                                            @if (Auth::user()->role == 'admin')
                                                <a href="{{ route('all.notification') }}">Show All Notifications</a>
                                            @else
                                                <a href="{{ route('user.all.notification') }}">Show All Notifications</a>
                                            @endif
                                            {{-- <a href="{{ route('user.all.notification') }}">Show All Notifications</a> --}}
                                        </div>
                                        {{-- <ul class="shopping-list">
                                        @foreach (Helper::getAllProductFromWishlist() as $data)
                                        @php
                                        $photo=explode(',',$data->product['photo']);
                                        @endphp
                                        <li>
                                            <a href="{{route('wishlist-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                            <a class="cart-img" href="#"><img src="{{asset($photo[0])}}" alt="{{$photo[0]}}"></a>
                                            <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                            <p class="quantity">{{$data->quantity}} x - <span class="amount">₱{{number_format($data->price,2)}}</span></p>
                                        </li>
                                        @endforeach
                                    </ul> --}}
                                        @foreach (Auth::user()->unreadNotifications as $notification)
                                            @if (Auth::user()->role == 'admin')
                                                <a class="dropdown-item d-flex align-items-center" target="_blank"
                                                    href="{{ route('all.notification', $notification->id) }}">
                                                @else
                                                    <a class="dropdown-item d-flex align-items-center" target="_blank"
                                                        href="{{ route('user.notification', $notification->id) }}">
                                            @endif
                                            {{-- <a class="dropdown-item d-flex align-items-center" target="_blank"
                                                href="{{ route('user.notification', $notification->id) }}"> --}}
                                            <div class="mr-3">
                                                <div class="icon-circle bg-primary">
                                                    <i class="fas {{ $notification->data['fas'] }} text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">
                                                    {{ $notification->created_at->format('F d, Y h:i A') }}</div>
                                                <span
                                                    class="@if ($notification->unread()) font-weight-bold @else small text-gray-500 @endif">{{ $notification->data['title'] }}</span>
                                            </div>
                                            </a>
                                            @if ($loop->index + 1 == 5)
                                                @php
                                                    break;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </div>
                                @endauth
                                <!--/ End Shopping Item -->
                            </div>
                            <div class="sinlge-bar shopping">
                                <!-- Wishlist Link -->
                                <a href="{{ route('wishlist') }}" class="single-icon"><i class="fa fa-heart-o"></i>
                                    <span class="total-count">{{ Helper::wishlistCount() }}</span></a>
                                <!-- Shopping Item -->
                                @auth
                                    <div class="shopping-item">
                                        <div class="dropdown-cart-header">
                                            <span>{{ count(Helper::getAllProductFromWishlist()) }} Items</span>
                                            <a href="{{ route('wishlist') }}">View Wishlist</a>
                                        </div>
                                        <ul class="shopping-list">
                                            @foreach (Helper::getAllProductFromWishlist() as $data)
                                                @php
                                                    $photo = explode(',', $data->product['photo']);
                                                @endphp
                                                <li>
                                                    <a href="{{ route('wishlist-delete', $data->id) }}" class="remove"
                                                        title="Remove this item"><i class="fa fa-remove"></i></a>
                                                    <a class="cart-img" href="#"><img src="{{ asset($photo[0]) }}"
                                                            alt="{{ $photo[0] }}"></a>
                                                    <h4><a href="{{ route('product-detail', $data->product['slug']) }}"
                                                            target="_blank">{{ $data->product['title'] }}</a></h4>
                                                    <p class="quantity">{{ $data->quantity }} x - <span
                                                            class="amount">₱{{ number_format($data->price, 2) }}</span>
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="bottom">
                                            <div class="total">
                                                <span>Total</span>
                                                <span
                                                    class="total-amount">₱{{ number_format(Helper::totalWishlistPrice(), 2) }}</span>
                                            </div>
                                            <a href="{{ route('cart') }}" class="btn animate">Cart</a>
                                        </div>
                                    </div>
                                @endauth
                                <!--/ End Shopping Item -->
                            </div>
                            <div class="sinlge-bar shopping">
                                <!-- Cart Link -->
                                <a href="{{ route('cart') }}" class="single-icon"><i class="ti-bag"></i> <span
                                        class="total-count">{{ Helper::cartCount() }}</span></a>
                                <!-- Shopping Item -->
                                @auth
                                    <div class="shopping-item">
                                        <div class="dropdown-cart-header">
                                            <span>{{ count(Helper::getAllProductFromCart()) }} Items</span>
                                            <a href="{{ route('cart') }}">View Cart</a>
                                        </div>
                                        <ul class="shopping-list">
                                            @foreach (Helper::getAllProductFromCart() as $data)
                                                @php
                                                    $photo = explode(',', $data->product['photo']);
                                                @endphp
                                                <li>
                                                    <a href="{{ route('cart-delete', $data->id) }}" class="remove"
                                                        title="Remove this item"><i class="fa fa-remove"></i></a>
                                                    <a class="cart-img" href="#"><img src="{{ $photo[0] }}"
                                                            alt="{{ $photo[0] }}"></a>
                                                    <h4><a href="{{ route('product-detail', $data->product['slug']) }}"
                                                            target="_blank">{{ $data->product['title'] }}</a></h4>
                                                    <p class="quantity">{{ $data->quantity }} x - <span
                                                            class="amount">₱{{ number_format($data->price, 2) }}</span>
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="bottom">
                                            <div class="total">
                                                <span>Total</span>
                                                <span
                                                    class="total-amount">₱{{ number_format(Helper::totalCartPrice(), 2) }}</span>
                                            </div>
                                            <a href="{{ route('checkout') }}" class="btn animate">Checkout</a>
                                        </div>
                                    </div>
                                @endauth
                                <!--/ End Shopping Item -->
                            </div>
                            <div class="sinlge-bar shopping">
                                <!-- Like Link -->
                                <a href="{{ route('like') }}" class="single-icon"><i class="ti-thumb-up"></i> <span
                                        class="total-count">{{ Helper::likeCount() }}</span></a>
                                <!-- Shopping Item -->
                                @auth
                                    <div class="shopping-item">
                                        <div class="dropdown-cart-header">
                                            <span>{{ count(Helper::getAllProductFromLike()) }} Items</span>
                                            <a href="{{ route('wishlist') }}">View Like</a>
                                        </div>
                                        <ul class="shopping-list">
                                            @foreach (Helper::getAllProductFromLike() as $data)
                                                @php
                                                    $photo = explode(',', $data->product['photo']);
                                                @endphp
                                                <li>
                                                    <a href="{{ route('like-delete', $data->id) }}" class="remove"
                                                        title="Remove this item"><i class="fa fa-remove"></i></a>
                                                    <a class="cart-img" href="#"><img src="{{ asset($photo[0]) }}"
                                                            alt="{{ $photo[0] }}"></a>
                                                    <h4><a href="{{ route('product-detail', $data->product['slug']) }}"
                                                            target="_blank">{{ $data->product['title'] }}</a></h4>
                                                    <p class="quantity">{{ $data->quantity }} x - <span
                                                            class="amount">₱{{ number_format($data->price, 2) }}</span>
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="bottom">
                                            <div class="total">
                                                <span>Total</span>
                                                <span
                                                    class="total-amount">₱{{ number_format(Helper::totalLikePrice(), 2) }}</span>
                                            </div>
                                            <!-- <a href="{{ route('cart') }}" class="btn animate">Cart</a> -->
                                        </div>
                                    </div>
                                @endauth
                                <!--/ End Shopping Item -->
                            </div>
                            <div class="sinlge-bar shopping">
                                <!-- User Links Dropdown -->
                                <div class="dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="userDropdown"
                                        data-toggle="dropdown">
                                        <i class="ti-menu"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                                        <ul class="dropdown border-0 shadow">
                                            @auth
                                                @if (Auth::user()->role == 'admin')
                                                    <li><a class="dropdown-item" href="{{ route('admin') }}"
                                                            target="_blank">Dashboard</a></li>
                                                @elseif(Auth::user()->role == 'delivery_user')
                                                    <li><a class="dropdown-item" href="{{ route('delivery_user') }}"
                                                            target="_blank">Dashboard</a></li>
                                                @else
                                                    <li><a class="dropdown-item" href="{{ route('user') }}"
                                                            target="_blank">Dashboard</a></li>
                                                @endif
                                                <li><a class="dropdown-item" href="{{ route('user.logout') }}"><i
                                                            class="ti-power-off"></i> Logout</a></li>
                                            @else
                                                <li><a class="dropdown-item" href="{{ route('login.form') }}">Login</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('register.form') }}">Register</a></li>
                                            @endauth
                                        </ul>
                                    </div>
                                </div>
                                <!--/ End User Links Dropdown -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{ Request::path() == 'home' ? 'active' : '' }}"><a
                                                    href="{{ route('home') }}">Home</a></li>
                                            <li class="{{ Request::path() == 'about-us' ? 'active' : '' }}"><a
                                                    href="{{ route('about-us') }}">About Us</a></li>
                                            <li class="@if (Request::path() == 'product-grids' || Request::path() == 'product-lists') active @endif"><a
                                                    href="{{ route('product-grids') }}">Products</a><span
                                                    class="new">New</span></li>
                                            {{ Helper::getHeaderCategory() }}
                                            <li
                                                class="{{ Request::path() == 'product-high-reviews' ? 'active' : '' }}">
                                                <a href="{{ route('product-high-reviews') }}">Top Reviews</a>
                                            </li>

                                            <li class="{{ Request::path() == 'contact' ? 'active' : '' }}"><a
                                                    href="{{ route('contact') }}">Contact Us</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>
