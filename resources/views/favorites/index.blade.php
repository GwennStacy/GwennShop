@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 py-8 md:py-16 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl md:text-5xl font-serif text-gray-900 tracking-wide mb-2 md:mb-4">Your Favorites</h1>
            <p class="text-gray-400 max-w-2xl mx-auto text-xs md:text-sm px-2">
                Products you have saved.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex-1">
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-x-3 md:gap-x-8 gap-y-8 md:gap-y-12">
                    
                    @forelse($products as $product)
                        <div class="group relative">
                            <a href="/product/{{ $product->slug }}" class="block">
                                <div class="w-full bg-gray-100 aspect-w-3 aspect-h-4 overflow-hidden h-48 md:h-[350px] relative rounded-xl md:rounded-none">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:opacity-90 transition-opacity">
                                    
                                    <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0 hidden md:block">
                                        <button class="w-full bg-white text-black py-3 text-xs uppercase tracking-widest font-semibold shadow-lg hover:bg-black hover:text-white transition-colors">View Product</button>
                                    </div>
                                </div>
                                
                                <div class="mt-3 md:mt-6 flex justify-between items-start">
                                    <div>
                                        <h3 class="text-xs md:text-sm text-gray-900 font-medium truncate max-w-[130px] md:max-w-none">{{ $product->name }}</h3>
                                        <p class="mt-0.5 text-[10px] md:text-sm text-gray-400">{{ $product->category }}</p>
                                    </div>
                                    <p class="text-xs md:text-sm font-semibold text-gray-900">${{ number_format($product->price, 2) }}</p>
                                </div>
                            </a>

                            <button onclick="toggleFavorite({{ $product->id }})" class="absolute top-2 right-2 p-2 bg-white rounded-full shadow hover:text-red-500 z-10 transition-colors">
                                <svg id="heart-{{ $product->id }}" class="w-5 h-5 fill-red-500 text-red-500" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>
                    @empty
                        <div class="col-span-2 lg:col-span-4 text-center py-12 text-sm text-gray-400">
                            You have no favorite products yet.
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
@endsection
