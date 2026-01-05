<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recepten Website</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-primary">Recepten</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('news.index') }}" class="text-gray-700 hover:text-primary transition">Nieuws</a>
                    <a href="{{ route('posts.index') }}" class="text-gray-700 hover:text-primary transition">Community</a>
                    <a href="{{ route('faq.index') }}" class="text-gray-700 hover:text-primary transition">FAQ</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-primary transition">Contact</a>
                    
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary transition">Log in</a>
                    <a href="{{ route('register') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-primary-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h2 class="text-5xl font-bold text-gray-900 mb-6">
                    Welkom bij onze <span class="text-primary">Recepten Website</span>
                </h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    Ontdek heerlijke recepten, deel je eigen creaties en word onderdeel van onze kook community.
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto mb-8">
                    <form method="GET" action="{{ route('search') }}" class="flex gap-2">
                        <input 
                            type="text" 
                            name="q" 
                            placeholder="Zoek een persoon of nieuws..."
                            class="flex-1 border-gray-300 focus:border-primary focus:ring-primary rounded-lg shadow-sm text-lg px-6 py-3"
                        >
                        <button type="submit" class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-primary-700 transition shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
                
                <div class="flex justify-center gap-4">
                    @guest
                        <a href="{{ route('register') }}" class="bg-primary text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-primary-700 transition shadow-lg">
                            Start Nu
                        </a>
                        <a href="{{ route('login') }}" class="bg-white text-primary px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-50 transition border-2 border-primary">
                            Inloggen
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition">
                <h3 class="text-xl font-bold text-gray-900 mb-3">Community</h3>
                <p class="text-gray-600">
                    Maak een profiel aan en deel je eigen recepten met andere kookliefhebbers.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition">
                <h3 class="text-xl font-bold text-gray-900 mb-3">Nieuws & Tips</h3>
                <p class="text-gray-600">
                    Blijf op de hoogte van de laatste kooktrends en handige keukentips.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-600">
                <p>© 2026 Recepten Website. Alle rechten voorbehouden.</p>
            </div>
        </div>
    </footer>
</body>
</html>
