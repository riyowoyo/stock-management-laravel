<div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white min-vh-100" style="width: 220px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4">📦 Stock App</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('dashboard.index') }}" class="nav-link text-white">
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('products.index') }}" class="nav-link text-white">
                Master Barang
            </a>
        </li>
        <li>
            <a href="{{ route('transactions.index') }}" class="nav-link text-white">
                Pengelolaan Stok
            </a>
        </li>

    </ul>
    <hr>
    <div class="text-center">
        <img src="{{ asset('images/logo-lem-fox-rds.png') }}" alt="Logo" class="img-fluid mt-0  " style="max-width: 150px;">
    </div>
</div>
