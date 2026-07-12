<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen font-sans">

    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="p-6 text-2xl font-bold tracking-widest border-b border-gray-800">
            LUMIÈRE ADMIN
        </div>
       <nav class="flex-1 px-4 space-y-2 text-sm font-medium">
    
    <a href="/admin/products" class="block px-4 py-3 text-white bg-gray-800 rounded transition-colors">Products</a>
    
    <a href="/admin/categories" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Categories</a>
    
    <!-- យកកូដខាងក្រោមនេះ មក Paste ដាក់នៅត្រង់ចន្លោះនេះ -->
    <a href="/admin/orders" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Orders</a>
    <a href="/admin/banners" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Banners</a>
    <a href="/admin/sliders" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Category Sliders</a>
            <a href="/admin/seamless-images" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Seamless Images</a>

    <a href="/" target="_blank" class="block px-4 py-3 mt-8 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors border-t border-gray-700">View Live Store</a>

</nav>
    </aside>

    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Manage Products</h1>
            <div class="flex items-center gap-4">
                <form action="/admin/products" method="GET" class="flex gap-2">
                    <select name="category" class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800 bg-white" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 transition">Search</button>
                    @if(request('search') || request('category'))
                        <a href="/admin/products" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition">Clear</a>
                    @endif
                </form>
                <a href="/admin/products/create" class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800 transition">
                    + Add New Product
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left border-collapse">
        <div class="p-4 border-t border-gray-100 bg-white">
                {{ $products->links() }}
            </div>
        <thead>
            <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-500 uppercase tracking-wider">
                <th class="p-4 font-medium">Name</th>
                <th class="p-4 font-medium">Category</th>
                <th class="p-4 font-medium">Price</th>
                <th class="p-4 font-medium">Qty</th>
                <th class="p-4 font-medium text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
            @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 font-medium text-gray-900">{{ $product->name }}</td>
                    <td class="p-4 text-gray-600">{{ $product->category }}</td>
                    <td class="p-4 text-gray-600">${{ number_format($product->price, 2) }}</td>
                    <td class="p-4">
                        @if($product->quantity > 0)
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">{{ $product->quantity }}</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Out of Stock</span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="/admin/products/{{ $product->id }}/edit" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">Edit</a>
                            
                            <form action="/admin/products/{{ $product->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition-colors">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-500">No products found. Start by adding one!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
    </main>

</body>
</html>