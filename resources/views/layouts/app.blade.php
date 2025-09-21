<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Stock Management')</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="icon" href="https://placehold.co/32x32/3685FC/FFFFFF?text=S">

    <style>
        :root {
            --sidebar-width: 250px;
            --navbar-height: 60px;
        }

        body {
            background-color: #f8f9fa;
        }

        /* Sidebar */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            position: fixed;
            top:0;
            left:0;
            z-index: 1040;
            transition: transform 0.3s ease;
            overflow: hidden;
        }

        #sidebar .nav-link.active {
            background-color: #3685FC;
            color: #fff;
        }

        /* Content wrapper */
        #page-content-wrapper {
            margin-left: var(--sidebar-width);
            transition: margin 0.3s;
        }

        /* Floating Navbar */
        #main-navbar {
            height: var(--navbar-height);
            line-height: var(--navbar-height);
            z-index: 1050;
            max-width: 95%;
            margin: 1rem auto;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Mobile / zoom */
        @media(max-width: 991.98px) {
            #sidebar {
                transform: translateX(-100%);
                box-shadow: 2px 0 12px rgba(0,0,0,0.15);
            }

            #sidebar.show {
                transform: translateX(0);
                z-index: 1100;
            }

            #page-content-wrapper {
                margin-left: 0;
            }

            #sidebar-overlay {
                position: fixed;
                inset:0;
                background-color: rgba(0,0,0,0.35);
                z-index: 1050;
                display: none;
            }
            #sidebar-overlay.show {
                display: block;
            }
        }
    </style>

    @yield('styles')
</head>
<body>

<!-- Sidebar -->
@include('layouts.sidebar')

<!-- Sidebar Overlay for mobile -->
<div id="sidebar-overlay"></div>

<!-- Page Content -->
<div id="page-content-wrapper">

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Main Content -->
    <div class="container-fluid py-4">
        @yield('content')
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    document.querySelectorAll('.btn-toggle-sidebar').forEach(btn => {
        btn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    });
});
</script>

@if(session('success') || session('error'))
    @php
        $type = session('success') ? 'success' : 'error';
        $message = session('success') ?? session('error');
    @endphp
    <script>
        Swal.fire({
            title: '{{ ucfirst($type) }}',
            text: '{{ $message }}',
            icon: '{{ $type }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@yield('scripts')
</body>
</html>
    