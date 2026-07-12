<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased flex min-h-screen">

    <aside class="w-64 bg-[#111827] text-white flex-shrink-0 flex flex-col">
        <div class="p-6">
            <h1 class="text-2xl font-bold tracking-widest uppercase leading-tight">LUMIÈRE<br>ADMIN</h1>
        </div>
        
        <nav class="mt-6 flex-1 flex flex-col gap-1 px-4">
            <a href="/admin/products" class="px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-md transition-colors">Products</a>
            
            <a href="/admin/categories" class="px-4 py-3 bg-gray-800 text-white rounded-md transition-colors font-medium">Categories</a>
            
            <a href="/admin/orders" class="px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-md transition-colors">Orders</a>
            <a href="/admin/banners" class="px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-md transition-colors">Banners</a>
            <a href="/admin/sliders" class="px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-md transition-colors">Category Sliders</a>
            <a href="/admin/seamless-images" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Seamless Images</a>
            
            <div class="my-4 border-t border-gray-700 mx-2"></div>
            
            <a href="/" target="_blank" class="px-4 py-3 text-gray-400 hover:text-white transition-colors">View Live Store</a>
        </nav>
    </aside>

    <main class="flex-1 p-10">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Manage Categories</h2>
            <a href="/admin/categories/create" class="bg-black text-white px-5 py-2.5 rounded text-sm font-medium hover:bg-gray-800 transition-colors shadow-sm">
                + Add Category
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-widest border-b border-gray-200">
                        <th class="p-4 pl-6">ID</th>
                        <th class="p-4">Image</th>
                        <th class="p-4">Category Name</th>
                        <th class="p-4">Slug</th>
                        <th class="p-4 pr-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @foreach($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 pl-6 text-gray-900 font-medium">#CAT-00{{ $category->id }}</td>
                        <td class="p-4">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" class="w-12 h-12 object-contain bg-white rounded shadow-sm border border-gray-100" alt="{{ $category->name }}">
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center text-gray-400 text-xs font-bold border border-gray-200">NO IMG</div>
                            @endif
                        </td>
                        <td class="p-4 text-gray-700 font-medium">{{ $category->name }}</td>
                        <td class="p-4 text-gray-500">{{ $category->slug }}</td>
                        <td class="p-4 pr-6 text-right space-x-4">
                            <a href="/admin/categories/{{ $category->id }}/edit" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                            
                            <form action="/admin/categories/{{ $category->id }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            @if($categories->isEmpty())
                <div class="p-8 text-center text-gray-500 bg-gray-50/50">No categories found. Click "Add Category" to create one.</div>
            @endif
        </div>
    </main>

</body>
</html>