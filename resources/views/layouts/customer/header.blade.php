<!-- Header -->
<header id="header">
    <div class="inner">

        <!-- Logo -->
        <a href="{{ route('home.index') }}" class="logo">
            <span class="fa fa-plane"></span> <span class="title">Pesan Tiket Wisata Online</span>
        </a>

        <!-- Nav -->
        <nav>
            <ul>
                <li><a href="#menu">Menu</a></li>
            </ul>
        </nav>

    </div>
</header>

<!-- Menu -->
<nav id="menu">
    <h2>Menu</h2>
    <ul>
        <li><a href="{{ route('home.index') }}" @if(request()->routeIs('home.index')) class="active" @endif>Home</a></li>

        <li><a href="{{ route('tickets.index') }}" @if(request()->routeIs('tickets.index')) class="active" @endif>Pesan Tiket</a></li>
        <li><a href="{{ route('galleries.index') }}" @if(request()->routeIs('galleries.index')) class="active" @endif>Galeri</a></li>
        @if(optional(auth()->user())->isCustomer())
            <li><a href="{{ route('customer.transactions.index') }}" @if(request()->routeIs('customer.transactions.index')) class="active" @endif>Transaksi &nbsp; <i class="fa fa-money"></i></a></li>
            <li><a href="{{ route('profile.create') }}" @if(request()->routeIs('profile.create')) class="active" @endif>Profile &nbsp; <i class="fa fa-user"></i></a></li>
        @endif
        @if(optional(auth()->user())->isCustomer())
            <li><a href="{{ route('auth.logout') }}">Logout</a></li>
        @else
            <li><a href="{{ route('auth.login.index') }}">Login</a></li>
        @endif
    </ul>
</nav>
