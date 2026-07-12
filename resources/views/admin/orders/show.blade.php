@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased flex flex-col lg:flex-row min-h-screen">

    <aside class="w-full lg:w-64 bg-[#111827] text-white flex-shrink-0 flex flex-col">
        <div class="p-4 md:p-6 flex justify-between items-center lg:block">
            <h1 class="text-lg md:text-2xl font-bold tracking-widest uppercase leading-tight">MILE<br class="hidden lg:block">ADMIN</h1>
            <span class="lg:hidden text-xs bg-gray-800 px-2 py-1 rounded border border-gray-700">Mobile Mode</span>
        </div>
        <nav class="flex lg:flex-col gap-1 overflow-x-auto lg:overflow-x-visible px-4 pb-3 lg:pb-0 lg:mt-6 flex-1 text-xs md:text-sm">
            <a href="/admin/products" class="whitespace-nowrap px-3 py-2 md:px-4 md:py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-md transition-colors">Products</a>
            <a href="/admin/categories" class="whitespace-nowrap px-3 py-2 md:px-4 md:py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-md transition-colors">Categories</a>
            <a href="/admin/orders" class="whitespace-nowrap px-3 py-2 md:px-4 md:py-3 bg-gray-800 text-white rounded-md transition-colors font-medium">Orders</a>
            <a href="/admin/banners" class="whitespace-nowrap px-3 py-2 md:px-4 md:py-3 hover:bg-gray-800 text-gray-300 hover:text-white rounded-md transition-colors font-medium">Banners</a>
            <a href="/admin/sliders" class="whitespace-nowrap px-3 py-2 md:px-4 md:py-3 hover:bg-gray-800 text-gray-300 hover:text-white rounded-md transition-colors font-medium">Category Sliders</a>
            <a href="/admin/seamless-images" class="whitespace-nowrap px-3 py-2 md:px-4 md:py-3 hover:bg-gray-800 text-gray-300 hover:text-white rounded-md transition-colors font-medium">Seamless Images</a>
            <div class="hidden lg:block my-4 border-t border-gray-700 mx-2"></div>
            <a href="/" target="_blank" class="whitespace-nowrap px-3 py-2 md:px-4 md:py-3 text-gray-400 hover:text-white transition-colors">Live Store</a>
        </nav>
    </aside>

    <main class="flex-1 p-4 md:p-10">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 md:mb-8">
            <div>
                <h2 class="text-xl md:text-3xl font-bold text-gray-900">Order Details</h2>
                <p class="text-xs md:text-sm text-gray-500 mt-0.5">Order ID: <span class="font-bold text-black">#ORD-00{{ $order->id }}</span></p>
            </div>
            <a href="/admin/orders" class="w-full sm:w-auto text-center bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded text-xs md:text-sm font-medium hover:bg-gray-50 transition-colors shadow-sm">
                &larr; Back to Orders
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-8">
            
            <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-sm md:text-lg font-bold text-gray-900 mb-4 border-b pb-2">Customer Information</h3>
                <div class="space-y-2.5 md:space-y-3 text-xs md:text-sm">
                    <p><span class="text-gray-400 w-20 md:w-24 inline-block">Full Name:</span> <span class="font-medium text-gray-800">{{ $order->first_name }} {{ $order->last_name }}</span></p>
                    <p><span class="text-gray-400 w-20 md:w-24 inline-block">Phone:</span> <span class="font-medium text-gray-800">{{ $order->phone }}</span></p>
                    <p class="flex items-start"><span class="text-gray-400 w-20 md:w-24​flex-shrink-0 inline-block">Address:</span> <span class="font-medium text-gray-800 flex-1">{{ $order->address }}</span></p>
                    <p><span class="text-gray-400 w-20 md:w-24 inline-block">Status:</span> 
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] md:text-xs font-medium bg-yellow-100 text-yellow-800">
                            {{ $order->status }}
                        </span>
                    </p>
                    <div class="border-t pt-3 mt-3">
                        <p class="text-base md:text-lg font-bold text-gray-900">Total Amount: <span class="text-blue-600">${{ number_format($order->total_amount, 2) }}</span></p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-sm md:text-lg font-bold text-gray-900 mb-4 border-b pb-2">Payment Information</h3>
                <div class="space-y-3 md:space-y-4">
                    <div>
                        <p class="text-xs md:text-sm text-gray-400 mb-1">Payment Method:</p>
                        @if($order->payment_method == 'Bank Transfer')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] md:text-xs font-medium bg-blue-100 text-blue-800">
                                Bank Transfer (KHQR)
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] md:text-xs font-medium bg-gray-100 text-gray-800">
                                Cash on Delivery (COD)
                            </span>
                        @endif
                    </div>

                    @if($order->payment_method == 'Bank Transfer')
                        <div class="pt-1">
                            <p class="text-xs md:text-sm text-gray-400 mb-2">Payment Receipt (Screenshot):</p>
                            @if($order->payment_receipt)
                                <a href="{{ asset('storage/' . $order->payment_receipt) }}" target="_blank" class="inline-block">
                                    <img src="{{ asset('storage/' . $order->payment_receipt) }}" alt="Receipt" class="w-32 md:w-48 h-auto object-contain border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                </a>
                                <p class="text-[9px] text-gray-400 mt-1 uppercase tracking-wider">Click image to view full size</p>
                            @else
                                <span class="text-xs text-red-500 font-medium px-2.5 py-1 bg-red-50 rounded border border-red-100 inline-block">No receipt uploaded</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>

</body>
</html>
@endsection