<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TMC Balikpapan') }} - Login</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/tmc.png" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gradient-to-br from-red-50 via-white to-red-100">
            <div class="w-full max-w-md">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <!-- Logo -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                            <i class="fas fa-sign-in-alt text-red-600 text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Welcome Back!</h2>
                        <p class="text-gray-600 mt-2">Please sign in to your account</p>
                    </div>

                    <!-- Session Status -->
                    @if(session('status'))
                        <div class="mb-4 text-sm text-green-600 bg-green-50 p-3 rounded-lg">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="mb-4 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" x-data="loginForm()">
                        @csrf

                        <!-- Username -->
                        <div class="mb-6">
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-gray-400"></i>Username
                            </label>
                            <input 
                                type="text" 
                                name="username" 
                                id="username" 
                                value="{{ old('username') }}" 
                                required 
                                autofocus 
                                autocomplete="username"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-600 focus:border-transparent transition-colors"
                                placeholder="Enter your username"
                            />
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-gray-400"></i>Password
                            </label>
                            <div class="relative">
                                <input 
                                    :type="showPassword ? 'text' : 'password'" 
                                    name="password" 
                                    id="password" 
                                    required 
                                    autocomplete="current-password"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-600 focus:border-transparent transition-colors"
                                    placeholder="Enter your password"
                                />
                                <button 
                                    type="button"
                                    class="absolute right-3 top-3 text-gray-400 hover:text-gray-600"
                                    @click="showPassword = !showPassword"
                                >
                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between mb-6">
                            <label for="remember_me" class="flex items-center">
                                <input 
                                    id="remember_me" 
                                    type="checkbox" 
                                    class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500"
                                    name="remember"
                                >
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                            
                            @if (Route::has('password.request'))
                                <a class="text-sm text-red-600 hover:text-red-700" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit"
                            class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 focus:ring-4 focus:ring-red-600 focus:ring-opacity-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="loading"
                        >
                            <span x-show="loading" class="inline-flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                            <span x-show="!loading">{{ __('Log in') }}</span>
                        </button>
                    </form>

                    <script>
                        document.addEventListener('alpine:init', () => {
                            Alpine.data('loginForm', () => ({
                                showPassword: false,
                                loading: false
                            }));
                        });
                    </script>
                </div>
            </div>
        </div>

        <!-- Right Side - Image -->
        <div class="hidden lg:block lg:w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('images/bg/tmc.png') }}'), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80')">
            <div class="h-full bg-black bg-opacity-50 flex items-center justify-center">
                <div class="text-center text-white px-12">
                    <img src="{{ asset('images/logo/tmc.png') }}" alt="TMC Logo" class="w-32 h-32 mx-auto mb-6">
                    <h2 class="text-4xl font-bold mb-6">TMC Balikpapan</h2>
                    <p class="text-xl">Traffic Management Center - Smart City Solutions for Better Transportation</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
