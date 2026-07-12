@extends('layouts.app')

@section('content')
   <div class="bg-gray-50 py-10 border-b border-gray-100">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 text-left">
        <a href="/" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-black transition-colors group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Categories
        </a>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-serif text-gray-900 tracking-wide mb-4">
            Men's Collection
        </h1>
        <p class="text-gray-500 max-w-2xl mx-auto text-sm">
            Elevate your everyday wardrobe. Sharp tailoring, essential basics, and premium outerwear.
        </p>
    </div>
    
</div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="sticky top-28">
                    <h3 class="text-xs uppercase tracking-widest text-gray-900 font-semibold mb-6">Filter By</h3>
                    
                    
                    <div class="mb-8 border-b border-gray-100 pb-6">
                        <h4 class="text-sm text-gray-900 font-medium mb-4">Category</h4>
                        <ul class="space-y-3 text-sm text-gray-500">
                            <li><a href="#" class="hover:text-black transition text-black font-medium">All Men's</a></li>
                            <li><a href="#" class="hover:text-black transition">Tailoring & Suits</a></li>
                            <li><a href="#" class="hover:text-black transition">Shirts & Polos</a></li>
                            <li><a href="#" class="hover:text-black transition">Trousers & Denim</a></li>
                            <li><a href="#" class="hover:text-black transition">Outerwear</a></li>
                        </ul>
                    </div>
                </div>
            </aside>
            

            <div class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                    
                    @forelse($products as $product)
                        <div class="group relative">
                            <a href="/product/{{ $product->slug }}" class="block">
                                <div class="w-full bg-gray-100 aspect-w-3 aspect-h-4 overflow-hidden h-48 md:h-[450px] relative rounded-xl md:rounded-none">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:opacity-90 transition-opacity">
                                    
                                    <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0 hidden md:block">
                                        <button class="w-full bg-white text-black py-3 text-xs uppercase tracking-widest font-semibold shadow-lg hover:bg-black hover:text-white transition-colors">Quick Add</button>
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
                        </div>
                    @empty
                        <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-12 text-sm text-gray-400">
                            No products found in this category yet.
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
@endsection