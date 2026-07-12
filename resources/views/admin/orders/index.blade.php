<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased flex h-screen overflow-hidden">

    <!-- Sidebar ខាងឆ្វេងពណ៌ខ្មៅ -->
    <div class="w-64 bg-[#111827] text-white flex flex-col h-screen flex-shrink-0 shadow-lg">
        <div class="p-6 mb-4">
            <h1 class="text-xl font-bold tracking-widest uppercase leading-snug">LUMIÈRE<br>ADMIN</h1>
        </div>
        <nav class="flex-1 px-4 space-y-2 text-sm font-medium">
            <a href="/admin/products" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Products</a>
            <a href="/admin/categories" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Categories</a>
            <a href="/admin/orders" class="block px-4 py-3 text-white bg-gray-800 rounded transition-colors">Orders</a>
            <a href="/admin/banners" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Banners</a>
            <a href="/admin/sliders" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Category Sliders</a>
            <a href="/admin/seamless-images" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Seamless Images</a>
            
            <a href="/" target="_blank" class="block px-4 py-3 mt-8 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors border-t border-gray-700">View Live Store</a>
        </nav>
    </div>

    <!-- ផ្នែកខាងស្តាំ (Main Content) -->
    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <div class="p-8 lg:p-12 max-w-7xl mx-auto w-full">
            
            <div class="mb-8 flex justify-between items-center">
                <h2 class="text-3xl font-bold text-gray-900">Customer Orders</h2>
            </div>

            <!-- តារាងបង្ហាញការកម្ម៉ង់ (ជាទម្រង់គំរូសិន) -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-500 uppercase tracking-wider">
                            <th class="p-4 font-medium">Order ID</th>
                            <th class="p-4 font-medium">Customer Name</th>
                            <th class="p-4 font-medium">Phone</th>
                            <th class="p-4 font-medium">Total Amount</th>
                            <th class="p-4 font-medium">Status</th>
                            <th class="p-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                  <tbody class="divide-y divide-gray-100 text-sm">
    @forelse($orders as $order)
        <tr class="hover:bg-gray-50 transition-colors">
            <td class="p-4 font-medium text-gray-900">#ORD-00{{ $order->id }}</td>
            <td class="p-4 text-gray-600">{{ $order->first_name }} {{ $order->last_name }}</td>
            <td class="p-4 text-gray-600">{{ $order->phone }}</td>
            <td class="p-4 font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</td>
            <td class="p-4">
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">{{ $order->status }}</span>
            </td>
            <td class="p-4 text-right">
                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View Details</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="p-8 text-center text-gray-500">No orders found yet.</td>
        </tr>
    @endforelse
</tbody>
                </table>
            </div>

        </div>
    </div>

</body>
</html>