<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - Admin</title>
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
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Add New Category</h2>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden max-w-2xl">
            <form action="/admin/categories" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                    <input type="text" name="name" class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-shadow" required placeholder="e.g. Women">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug (URL)</label>
                    <input type="text" name="slug" class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-shadow" required placeholder="e.g. women">
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Image</label>
                    <input type="file" name="image" class="w-full border border-gray-300 p-2.5 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-shadow" required>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                    <button type="submit" class="bg-black text-white px-8 py-3 rounded-md text-sm font-medium hover:bg-gray-800 transition-colors shadow-sm">Save Category</button>
                    <a href="/admin/categories" class="text-gray-600 hover:text-black text-sm font-medium transition-colors">Cancel</a>
                </div>
            </form>
        </div>
    </main>

</body>
</html>