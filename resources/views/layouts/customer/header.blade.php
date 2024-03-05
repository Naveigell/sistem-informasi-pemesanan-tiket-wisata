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
        <li><a href="{{ route('home.index') }}" class="active">Home</a></li>

        <li><a href="{{ route('ticket.index') }}">Pesan Tiket</a></li>
        <li><a href="{{ route('auth.login.index') }}">Login</a></li>
    </ul>
</nav>
