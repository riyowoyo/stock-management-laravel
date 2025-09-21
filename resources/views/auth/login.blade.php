<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | Login</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Clean Background: subtle gradient */
        .bg-login {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            min-height: 100vh;
        }

        /* Input & Button */
        .login-input {
            background-color: #F3F4F6;
            border: 1px solid #D1D5DB;
            color: #111827;
            transition: all 0.2s ease-in-out;
        }
        .login-input:focus {
            background-color: #fff;
            border-color: #ff0000;
            box-shadow: 0 0 0 2px rgba(255, 118, 34, 0.4);
            outline: none;
        }
        .btn-primary {
            background-color: #ff0000;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
            background-color: #ff4242;
        }
    </style>
</head>
<body>
    <!-- Main Container -->
    <div class="bg-login flex items-center justify-center min-h-screen px-4">

        <div class="w-full max-w-sm p-8 space-y-8 bg-white rounded-2xl shadow-xl">

            <!-- Logo & Title -->
            <div class="text-center">
                <img src="{{ asset('images/logo-lem-fox-rds.png') }}" alt="Logo" class="w-32 mx-auto mb-5">
                <h1 class="text- 2xl font-bold text-gray-900">THE ADHESIVES SPECIALIST</h1>
            </div>

            <!-- Alert Error -->
            @if(session('error'))
                <div class="alert alert-danger bg-red-100 text-red-700 px-4 py-2 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700">User</label>
                    <input type="text" id="email" name="email" placeholder="Masukan User Anda" 
                           value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 rounded-lg login-input @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Sandi</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="Masukan Sandi Anda" 
                               required class="w-full px-4 py-3 pr-10 rounded-lg login-input @error('password') border-red-500 @enderror">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="bx bx-hide text-gray-500 hover:text-gray-700 text-xl cursor-pointer"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="w-full px-4 py-3 font-semibold text-white rounded-lg btn-primary">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toggle Password -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const icon = togglePassword.querySelector('i');

            togglePassword.addEventListener('click', function() {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('bx-show', isPassword);
                icon.classList.toggle('bx-hide', !isPassword);
            });
        });
    </script>
</body>
</html>
