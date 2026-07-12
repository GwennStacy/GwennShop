<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.app_title') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        /* Custom Fonts */
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
        /* 💡 បន្ថែមហ្វុងខ្មែរ ពេលប្តូរភាសា */
        .font-khmer { font-family: 'Battambang', 'Hanuman', cursive; }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans antialiased flex flex-col min-h-screen {{ app()->getLocale() == 'kh' ? 'font-khmer' : '' }}">

    <div class="bg-black text-white text-xs text-center py-2 uppercase tracking-widest font-medium">
        {{ __('messages.free_shipping_banner') }}
    </div>

    <nav class="bg-white sticky top-0 z-50 border-b border-gray-100 transition-all duration-300 backdrop-blur-md bg-opacity-90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
               <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-sm font-medium text-gray-900 hover:text-gray-500 transition-colors uppercase tracking-wider">{{ __('messages.new_arrivals') }}</a>
                    <a href="#" class="text-sm font-medium text-gray-900 hover:text-gray-500 transition-colors uppercase tracking-wider">{{ __('messages.collections') }}</a>
                    <a href="#" class="text-sm font-medium text-gray-900 hover:text-gray-500 transition-colors uppercase tracking-wider">{{ __('messages.editorials') }}</a>
                </div>

                <div class="flex-shrink-0 flex items-center justify-center flex-1 md:flex-none">
                    <a href="/" class="text-3xl font-serif font-bold tracking-widest text-black">
                        {{ __('messages.shop_name') }}
                    </a>
                </div>

                <div class="flex items-center space-x-6">
                    <div class="relative group flex items-center">
                        <form action="/search" method="GET" class="flex items-center">
                            <input type="text" name="q" placeholder="Search..." class="w-0 opacity-0 group-hover:w-48 group-hover:opacity-100 focus:w-48 focus:opacity-100 transition-all duration-300 ease-in-out border-b border-gray-300 bg-transparent focus:outline-none focus:border-black text-sm px-2 py-1 mr-1" required>
                            <button type="submit" class="text-gray-900 hover:text-gray-500 transition"><i class="fas fa-search text-lg"></i></button>
                        </form>
                    </div>
                    <button class="text-gray-900 hover:text-gray-500 transition"><i class="far fa-user text-lg"></i></button>
                    
                    <a href="/favorites" class="text-gray-600 hover:text-black transition-colors relative cursor-pointer mr-4" title="Favorites">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span id="favorites-count-badge" class="absolute -top-2 -right-2 bg-black text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center {{ session('favorites') && count(session('favorites')) > 0 ? '' : 'hidden' }}">
                            {{ session('favorites') ? count(session('favorites')) : 0 }}
                        </span>
                    </a>
                    
                    <a href="/cart" class="text-gray-600 hover:text-black transition-colors relative cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        @if(session('cart'))
                            <span class="absolute -top-2 -right-2 bg-black text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <div class="relative group cursor-pointer inline-block z-50 mt-1">
                        <div class="relative flex items-center justify-center p-2 text-black hover:bg-gray-100 rounded-full transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="absolute -top-1 -right-1 bg-black text-white text-[9px] font-bold px-[4px] py-[2px] rounded uppercase shadow-sm">
                                {{ app()->getLocale() }}
                            </span>
                        </div>

                        <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 ease-in-out transform origin-top-right scale-95 group-hover:scale-100">
                            <div class="py-1">
                                <div class="px-4 py-2 text-xs text-gray-400 uppercase tracking-wider border-b border-gray-50">
                                    {{ __('messages.language_label') }}
                                </div>
                                <a href="{{ route('lang.switch', 'kh') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-black transition-colors {{ app()->getLocale() == 'kh' ? 'bg-gray-50 font-bold' : '' }}">
                                    🇰🇭 ភាសាខ្មែរ
                                </a>
                                <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-black transition-colors {{ app()->getLocale() == 'en' ? 'bg-gray-50 font-bold' : '' }}">
                                    🇺🇸 English
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-black text-white pt-16 pb-8 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-serif tracking-widest mb-6">LUMIÈRE</h2>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm mb-6">
                        {{ __('messages.footer_desc') }}
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-pinterest text-xl"></i></a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-xs uppercase tracking-widest text-gray-500 mb-4 font-semibold">{{ __('messages.client_care') }}</h3>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-white transition">{{ __('messages.contact_us') }}</a></li>
                        <li><a href="#" class="hover:text-white transition">{{ __('messages.shipping_returns') }}</a></li>
                        <li><a href="#" class="hover:text-white transition">{{ __('messages.size_guide') }}</a></li>
                        <li><a href="#" class="hover:text-white transition">{{ __('messages.faq') }}</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xs uppercase tracking-widest text-gray-500 mb-4 font-semibold">{{ __('messages.insider_access') }}</h3>
                    <p class="text-sm text-gray-300 mb-4">{{ __('messages.subscribe_desc') }}</p>
                    <form class="flex border-b border-gray-700 pb-2">
                        <input type="email" placeholder="{{ __('messages.email_address') }}" class="bg-transparent w-full text-sm text-white focus:outline-none placeholder-gray-600">
                        <button type="submit" class="text-xs uppercase tracking-widest font-semibold hover:text-gray-300 transition">{{ __('messages.subscribe') }}</button>
                    </form>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} LUMIÈRE. {{ __('messages.all_rights_reserved') }}</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">{{ __('messages.privacy_policy') }}</a>
                    <a href="#" class="hover:text-white transition">{{ __('messages.terms_of_service') }}</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleFavorite(productId) {
            fetch('/favorites/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    const heartIcons = document.querySelectorAll('.heart-icon-' + productId);
                    heartIcons.forEach(icon => {
                        if(data.status === 'added') {
                            icon.classList.remove('fill-none', 'text-gray-500');
                            icon.classList.add('fill-red-500', 'text-red-500');
                        } else {
                            icon.classList.remove('fill-red-500', 'text-red-500');
                            icon.classList.add('fill-none', 'text-gray-500');
                        }
                    });

                    // Update favorites count badge in navbar
                    const badge = document.getElementById('favorites-count-badge');
                    if (badge) {
                        if (data.favorites_count > 0) {
                            badge.textContent = data.favorites_count;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }
                }
            })
            .catch(error => console.error('Error toggling favorite:', error));
        }
    </script>
</body>
</html>