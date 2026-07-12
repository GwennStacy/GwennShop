@extends('layouts.app')

@section('content')

    <!-- Slide Banner Section -->
    <div class="relative w-full h-[40vh] md:h-[60vh] overflow-hidden bg-black" id="category-slider">
        
        <!-- Slides Container -->
        <div class="flex h-full w-full transition-transform duration-700 ease-in-out" id="slides-wrapper">
            @if(isset($sliders) && $sliders->count() > 0)
                @foreach($sliders as $index => $slider)
                    <div class="min-w-full h-full relative" data-index="{{ $index }}">
                        <img src="/slider-image/{{ $slider->id }}?t={{ time() }}" alt="Slide {{ $index + 1 }}" class="w-full h-full object-cover opacity-70">
                    </div>
                @endforeach
            @else
                <!-- Fallback Hardcoded Slides -->
                <div class="min-w-full h-full relative">
                    <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Slide 1" class="w-full h-full object-cover opacity-70">
                </div>
                <div class="min-w-full h-full relative">
                    <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Slide 2" class="w-full h-full object-cover opacity-70">
                </div>
                <div class="min-w-full h-full relative">
                    <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Slide 3" class="w-full h-full object-cover opacity-70">
                </div>
            @endif
        </div>

        <!-- Banner Content (Static Overlay) -->
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center z-10 px-4">
            <h1 class="text-3xl md:text-6xl font-serif text-white tracking-widest uppercase mb-4 drop-shadow-lg">
                {{ $categoryRecord ? $categoryRecord->name : $slug }} Collection
            </h1>
            <div class="w-24 h-0.5 bg-white mb-6"></div>
            <p class="text-gray-200 max-w-2xl mx-auto text-xs md:text-sm tracking-wide">
                Discover our curated selection of premium apparel and footwear. Minimalist silhouettes tailored from the finest materials.
            </p>
        </div>

        <!-- Navigation Arrows -->
        <button id="prev-slide" class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 transition z-20">
            <i class="fas fa-chevron-left text-2xl md:text-4xl drop-shadow-md"></i>
        </button>
        <button id="next-slide" class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 transition z-20">
            <i class="fas fa-chevron-right text-2xl md:text-4xl drop-shadow-md"></i>
        </button>
    </div>

    <!-- Script for Slider -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const wrapper = document.getElementById('slides-wrapper');
            const slides = wrapper.children;
            const totalSlides = slides.length;
            let currentSlide = 0;

            function goToSlide(index) {
                if (index < 0) index = totalSlides - 1;
                if (index >= totalSlides) index = 0;
                currentSlide = index;
                wrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
            }

            document.getElementById('prev-slide').addEventListener('click', () => goToSlide(currentSlide - 1));
            document.getElementById('next-slide').addEventListener('click', () => goToSlide(currentSlide + 1));

            // Auto-advance every 5 seconds
            setInterval(() => goToSlide(currentSlide + 1), 5000);
        });
    </script>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100">
            <h2 class="text-lg md:text-xl font-serif tracking-widest uppercase">Explore Items</h2>
            <span class="text-xs text-gray-400 uppercase tracking-widest">{{ $products->count() }} Results</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-x-3 md:gap-x-8 gap-y-8 md:gap-y-12">
            
            @forelse($products as $product)
                <div class="group relative">
                    <a href="/product/{{ $product->slug }}" class="block">
                        <div class="w-full bg-gray-100 aspect-w-3 aspect-h-4 overflow-hidden h-48 md:h-[350px] relative rounded-xl md:rounded-none">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:opacity-90 transition-transform duration-700 group-hover:scale-105">
                            
                            <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0 hidden md:block">
                                <button class="w-full bg-white text-black py-3 text-xs uppercase tracking-widest font-semibold shadow-lg hover:bg-black hover:text-white transition-colors">Quick Add</button>
                            </div>
                        </div>
                        
                        <div class="mt-3 md:mt-5 flex justify-between items-start">
                            <div>
                                <h3 class="text-xs md:text-sm text-gray-900 font-medium truncate max-w-[130px] md:max-w-none">{{ $product->name }}</h3>
                                <p class="mt-0.5 text-[10px] md:text-sm text-gray-400">{{ $product->category }}</p>
                            </div>
                            <p class="text-xs md:text-sm font-semibold text-gray-900">${{ number_format($product->price, 2) }}</p>
                        </div>
                    </a>

                    <button onclick="event.preventDefault(); toggleFavorite({{ $product->id }})" class="absolute top-2 right-2 p-2 bg-white rounded-full shadow hover:text-red-500 z-10 transition-colors">
                        <svg class="w-5 h-5 heart-icon-{{ $product->id }} {{ in_array($product->id, session('favorites', [])) ? 'fill-red-500 text-red-500' : 'fill-none text-gray-500' }}" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
            @empty
                <div class="col-span-2 lg:col-span-4 text-center py-20">
                    <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
                    <p class="text-sm text-gray-500 tracking-wide uppercase">No products found in this category yet.</p>
                </div>
            @endforelse

        </div>
    </div>

@endsection
