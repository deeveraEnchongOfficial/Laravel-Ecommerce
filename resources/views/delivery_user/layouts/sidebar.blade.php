<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #C19A6B;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" style="margin: 35px 0;" href="{{route('delivery_user')}}">
      <div class="sidebar-brand-icon rotate-n-15">
      </div>
      <img src="{{ asset('images/icon/Padilla_gowns_new.png') }}" alt="" width="100%">
      {{-- <div class="sidebar-brand-text mx-1">Padilla Gowns and Barongs</div> --}}
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="{{route('delivery_user')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Shop
        </div>
    <!--Orders -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('delivery_user.order.index')}}">
            <i class="fas fa-shopping-bag"></i>
            <span>Orders</span>
        </a>
    </li>

    <!-- Reviews -->
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{route('delivery_user.productreview.index')}}">
            <i class="fas fa-comments"></i>
            <span>Reviews</span></a>
    </li> --}}


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    {{-- <div class="sidebar-heading">
      Posts
    </div> --}}
    <!-- Comments -->
    {{-- <li class="nav-item">
      <a class="nav-link" href="{{route('delivery_user.post-comment.index')}}">
          <i class="fas fa-comments fa-chart-area"></i>
          <span>Comments</span>
      </a>
    </li> --}}
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
