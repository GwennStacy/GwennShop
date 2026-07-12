<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Upload Banner</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen font-sans">

    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="p-6 text-2xl font-bold tracking-widest border-b border-gray-800">
            LUMIÈRE ADMIN
        </div>
        <nav class="flex-1 px-4 space-y-2 text-sm font-medium mt-4">
            <a href="/admin/products" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Products</a>
            <a href="/admin/categories" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Categories</a>
            <a href="/admin/orders" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">Orders</a>
            <a href="/admin/banners" class="block px-4 py-3 text-white bg-gray-800 rounded transition-colors">Banners</a>
            <a href="/" target="_blank" class="block px-4 py-3 mt-8 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors border-t border-gray-700">View Live Store</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-serif text-gray-900 tracking-wide">Upload Banner</h1>
            <a href="/admin/banners" class="text-gray-500 hover:text-gray-900 transition-colors">&larr; Back to Banners</a>
        </div>

        <div class="bg-white p-8 rounded-lg shadow max-w-2xl">
            <form action="/admin/banners" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>
                    <input type="file" name="image" required class="w-full px-4 py-2 border rounded focus:ring-black focus:border-black">
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-2">Recommended size: 1200x400 pixels or similar wide format.</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-black text-white px-6 py-2 rounded shadow hover:bg-gray-800 transition-colors">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
