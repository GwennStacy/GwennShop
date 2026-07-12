@extends('layouts.app')

@section('content')

<div class="relative h-[50vh] md:h-[80vh] w-full flex items-center justify-center overflow-hidden">
    <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover z-0">
        <source src="{{ asset('videos/banner3.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="absolute inset-0 bg-black bg-opacity-40 z-10"></div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 md:mt-24 mb-16 md:mb-20">
    
    <div class="text-center mb-8 md:mb-12">
        <h2 class="text-2xl md:text-4xl font-serif text-gray-900 tracking-wide">
            Shop by Category
        </h2>
        <div class="w-16 h-0.5 bg-black mx-auto mt-3 md:mt-4"></div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-8">
        
        @foreach($categories as $category)
        <div class="relative group overflow-hidden h-[180px] md:h-[350px] cursor-pointer shadow-sm rounded-xl md:rounded-none">
            
            <img src="{{ asset('storage/' . $category->image) }}" 
                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                 alt="{{ $category->name }}">
            
            <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-50 transition-colors duration-500"></div>
            
            <div class="absolute inset-0 flex items-center justify-center p-2">
                <h3 class="bg-black bg-opacity-70 text-white px-4 py-2 md:px-10 md:py-4 text-xs md:text-xl font-serif tracking-[0.1em] md:tracking-[0.2em] uppercase border border-white/20 backdrop-blur-sm transition-all duration-300 group-hover:bg-opacity-90 group-hover:border-white text-center">
                    {{ $category->name }}
                </h3>
            </div>
            
            <a href="/category/{{ $category->slug }}" class="absolute inset-0 z-10"></a>
        </div>
        @endforeach

    </div>
</div>

<div id="shop" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 border-t border-gray-100">
    <div class="flex justify-between items-end mb-8 md:mb-12">
        <div>
            <h2 class="text-xl md:text-3xl font-serif text-gray-900">Curated For You</h2>
            <p class="text-gray-400 mt-1 text-xs md:text-sm">Pieces that define modern elegance.</p>
        </div>
        <a href="#" class="text-xs md:text-sm uppercase tracking-widest border-b border-black pb-1 hover:text-gray-500 hover:border-gray-500 transition-colors">View All</a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-x-3 md:gap-x-8 gap-y-8 md:gap-y-12">
        
        <div class="group relative">
            <div class="w-full bg-gray-100 aspect-w-1 aspect-h-1 overflow-hidden h-48 md:h-96 relative rounded-xl md:rounded-none">
                <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Silk Minimalist Jacket" class="w-full h-full object-cover object-center group-hover:opacity-90 transition-opacity">
                
                <div class="absolute bottom-3 left-0 right-0 px-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0 hidden md:block">
                    <button class="w-full bg-white text-black py-3 text-xs uppercase tracking-widest font-semibold shadow-lg hover:bg-black hover:text-white transition-colors">
                        Quick Add
                    </button>
                </div>
            </div>
            <div class="mt-3 md:mt-6 flex justify-between items-start">
                <div>
                    <h3 class="text-xs md:text-sm text-gray-900 font-medium truncate max-w-[120px] md:max-w-none">
                        <a href="#">Silk Minimalist Jacket</a>
                    </h3>
                    <p class="mt-0.5 text-[10px] md:text-sm text-gray-500">Outerwear</p>
                </div>
                <p class="text-xs md:text-sm font-semibold text-gray-900">$245.00</p>
            </div>
        </div>

        <div class="group relative">
            <div class="w-full bg-gray-100 aspect-w-1 aspect-h-1 overflow-hidden h-48 md:h-96 relative rounded-xl md:rounded-none">
                <img src="https://images.unsplash.com/photo-1584273143981-41c073dfe8f8?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Leather Tote Bag" class="w-full h-full object-cover object-center group-hover:opacity-90 transition-opacity">
                <div class="absolute bottom-3 left-0 right-0 px-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0 hidden md:block">
                    <button class="w-full bg-white text-black py-3 text-xs uppercase tracking-widest font-semibold shadow-lg hover:bg-black hover:text-white transition-colors">
                        Quick Add
                    </button>
                </div>
            </div>
            <div class="mt-3 md:mt-6 flex justify-between items-start">
                <div>
                    <h3 class="text-xs md:text-sm text-gray-900 font-medium truncate max-w-[120px] md:max-w-none"><a href="#">Leather Tote Bag</a></h3>
                    <p class="mt-0.5 text-[10px] md:text-sm text-gray-500">Accessories</p>
                </div>
                <p class="text-xs md:text-sm font-semibold text-gray-900">$180.00</p>
            </div>
        </div>

        <div class="group relative">
            <div class="w-full bg-gray-100 aspect-w-1 aspect-h-1 overflow-hidden h-48 md:h-96 relative rounded-xl md:rounded-none">
                <img src="https://images.unsplash.com/photo-1539533113208-f6df8cc8b543?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Essential Cotton Coat" class="w-full h-full object-cover object-center group-hover:opacity-90 transition-opacity">
                <div class="absolute bottom-3 left-0 right-0 px-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0 hidden md:block">
                    <button class="w-full bg-white text-black py-3 text-xs uppercase tracking-widest font-semibold shadow-lg hover:bg-black hover:text-white transition-colors">
                        Quick Add
                    </button>
                </div>
            </div>
            <div class="mt-3 md:mt-6 flex justify-between items-start">
                <div>
                    <h3 class="text-xs md:text-sm text-gray-900 font-medium truncate max-w-[120px] md:max-w-none"><a href="#">Essential Cotton Coat</a></h3>
                    <p class="mt-0.5 text-[10px] md:text-sm text-gray-500">Outerwear</p>
                </div>
                <p class="text-xs md:text-sm font-semibold text-gray-900">$320.00</p>
            </div>
        </div>

        <div class="group relative">
            <div class="w-full bg-gray-100 aspect-w-1 aspect-h-1 overflow-hidden h-48 md:h-96 relative rounded-xl md:rounded-none">
                <img src="https://images.unsplash.com/photo-1509942774463-acf339cf87d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Classic Sunglasses" class="w-full h-full object-cover object-center group-hover:opacity-90 transition-opacity">
                <span class="absolute top-2 left-2 md:top-4 md:left-4 bg-black text-white text-[8px] md:text-[10px] tracking-widest uppercase px-2 py-0.5 md:px-3 md:py-1">Sold Out</span>
            </div>
            <div class="mt-3 md:mt-6 flex justify-between items-start">
                <div>
                    <h3 class="text-xs md:text-sm text-gray-400 font-medium truncate max-w-[120px] md:max-w-none">Classic Sunglasses</h3>
                    <p class="mt-0.5 text-[10px] md:text-sm text-gray-300">Accessories</p>
                </div>
                <p class="text-xs md:text-sm font-semibold text-gray-400">$95.00</p>
            </div>
        </div>

    </div>
</div>

<!-- Seamless Products Section (Like Caps in Image) -->
<div class="w-full bg-white py-16 md:py-24 relative overflow-hidden mt-8 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-12 md:gap-16 lg:gap-24 items-center justify-items-center">
            
            @if(isset($seamlessImages) && $seamlessImages->count() > 0)
                @foreach($seamlessImages as $index => $image)
                    <div class="group relative cursor-pointer w-full max-w-[320px] {{ $index === 3 ? 'sm:col-start-2 sm:mt-8' : '' }}">
                        <img src="/seamless-image/{{ $image->id }}" 
                             alt="{{ $image->title }}" 
                             class="w-full h-auto object-contain mix-blend-multiply hover:scale-110 transition-transform duration-700 ease-out drop-shadow-2xl">
                    </div>
                @endforeach
            @else
                <!-- Fallback Hardcoded Seamless Images -->
                <div class="group relative cursor-pointer w-full max-w-[320px]">
                    <img src="https://images.unsplash.com/photo-1588850561407-ed78c282e89b?auto=format&fit=crop&w=600&q=80" 
                         alt="Navy Cap" 
                         class="w-full h-auto object-contain mix-blend-multiply hover:scale-110 transition-transform duration-700 ease-out drop-shadow-2xl">
                </div>
                <div class="group relative cursor-pointer w-full max-w-[320px]">
                    <img src="https://images.unsplash.com/photo-1556306535-0f09a536f01f?auto=format&fit=crop&w=600&q=80" 
                         alt="Brown Cap" 
                         class="w-full h-auto object-contain mix-blend-multiply hover:scale-110 transition-transform duration-700 ease-out drop-shadow-2xl">
                </div>
                <div class="group relative cursor-pointer w-full max-w-[320px]">
                    <img src="https://images.unsplash.com/photo-1521369909029-1221764df3c5?auto=format&fit=crop&w=600&q=80" 
                         alt="Green Cap" 
                         class="w-full h-auto object-contain mix-blend-multiply hover:scale-110 transition-transform duration-700 ease-out drop-shadow-2xl">
                </div>
                <div class="group relative cursor-pointer w-full max-w-[320px] sm:col-start-2 sm:mt-8">
                    <img src="https://images.unsplash.com/photo-1534349762230-e0cadf78f5da?auto=format&fit=crop&w=600&q=80" 
                         alt="Plaid Cap" 
                         class="w-full h-auto object-contain mix-blend-multiply hover:scale-110 transition-transform duration-700 ease-out drop-shadow-2xl">
                </div>
            @endif

        </div>
    </div>
</div>
@endsection