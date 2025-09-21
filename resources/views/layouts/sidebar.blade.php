@php
$menus = [
    ['header' => 'Dashboard'],
    ['label' => 'Dashboard', 'icon' => 'bi-grid-1x2-fill', 'route' => 'dashboard.index'],
    ['header' => 'Inventory'],
    ['label' => 'Master Barang', 'icon' => 'bi-box-seam', 'route' => 'products.index'],
    ['label' => 'Pengelolaan Stok', 'icon' => 'bi-toggles', 'route' => 'transactions.index'],
    ['label' => 'Aktivitas', 'icon' => 'bi-clock-history', 'route' => 'activities.index'],
];
@endphp

<div id="sidebar" class="d-flex flex-column p-3 bg-white vh-100 shadow" style="width: 250px;">
    <!-- Brand / Logo -->
    <a href="{{ route('dashboard.index') }}" class="d-flex align-items-center mb-3 text-decoration-none">
        <img src="{{ asset('images/logo-lem-fox-rds.png') }}" alt="Logo" class="me-2" style="height: 115px;">
        <!-- Jika ingin teks samping logo, bisa ditambahkan di sini -->
    </a>

    <!-- Menu -->
    <ul class="nav nav-pills flex-column mb-auto">
        @foreach($menus as $menu)
            @if(isset($menu['header']))
                <li class="nav-item mt-3 mb-2 px-3">
                    <span class="small text-uppercase text-muted">{{ $menu['header'] }}</span>
                </li>
            @else
                @php
                    $isActive = $menu['route'] && str_starts_with(Route::currentRouteName(), explode('.', $menu['route'])[0]);
                @endphp
                <li class="nav-item">
                    <a href="{{ route($menu['route']) }}" class="nav-link d-flex align-items-center {{ $isActive ? 'active bg-primary text-white' : 'text-dark' }}">
                        <i class="bi {{ $menu['icon'] }} me-2"></i>
                        <span>{{ $menu['label'] }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>

    <!-- User & Logout -->
    <div class="mt-auto p-3 border-top">
        <div class="d-flex align-items-center mb-2">
            <img src="https://placehold.co/40x40/3685FC/FFFFFF?text=R" class="rounded-circle me-2" alt="User">
            <div>
                <p class="fw-semibold mb-0">Admin RDS</p>
                <small class="text-muted">Online</small>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </div>
</div>
