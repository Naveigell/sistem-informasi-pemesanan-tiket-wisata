
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard.index') }}">Pemesanan</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard.index') }}">Psn</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Home</li>
            <li class="@if (request()->routeIs('admin.dashboard.*')) active @endif"><a class="nav-link" href="{{ route('admin.dashboard.index') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
            <li class="menu-header">Additional</li>
            <li class="@if (request()->routeIs('admin.tickets.*')) active @endif"><a class="nav-link" href="{{ route('admin.tickets.index') }}"><i class="fas fa-ticket-alt"></i> <span>Tiket</span></a></li>
            <li class="menu-header">Transaction & Payment</li>
            <li class="@if (request()->routeIs('admin.transactions.*')) active @endif"><a class="nav-link" href="{{ route('admin.transactions.index') }}"><i class="fas fa-credit-card"></i> <span>Pemesanan</span></a></li>
        </ul>
    </aside>
</div>
