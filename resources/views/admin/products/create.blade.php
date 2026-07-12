<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen font-sans">

    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="p-6 text-2xl font-bold tracking-widest border-b border-gray-800">
            LUMIÈRE ADMIN
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="/admin/products" class="block text-gray-400 hover:text-white px-4 py-2 rounded">Products</a>
            <a href="/" class="block text-gray-400 hover:text-white px-4 py-2 rounded">View Live Store</a>
        </nav>
    </aside>
    

    <main class="flex-1 p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Add New Product</h1>
            <p class="text-gray-500 mt-2">Fill in the details below to add a product to the database.</p>
        </div>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <strong class="font-bold">Whoops! Something went wrong.</strong>
                <ul class="list-disc pl-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/admin/products" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow w-full">
            @csrf 
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-black">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price ($)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-black">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity In Stock</label>
                    <input type="number" name="quantity" value="{{ old('quantity') }}" required min="0" class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-black">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-shadow" required>
                    <option value="" disabled selected>Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}" {{ old('category') == $category->name ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6 p-4 border border-gray-200 rounded bg-gray-50">
                <h3 class="text-sm font-bold text-gray-800 mb-4">Product Images</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Main Image (Required)</label>
                        <input type="file" name="image" accept="image/*" required class="w-full text-sm border border-gray-300 rounded p-2 bg-white focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Sub Image 1 (Optional)</label>
                        <input type="file" name="image_2" accept="image/*" class="w-full text-sm border border-gray-300 rounded p-2 bg-white focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Sub Image 2 (Optional)</label>
                        <input type="file" name="image_3" accept="image/*" class="w-full text-sm border border-gray-300 rounded p-2 bg-white focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4" required class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-black">{{ old('description') }}</textarea>
            </div>
                
            <div class="mb-8 flex items-center">
                <input type="checkbox" name="is_featured" id="is_featured" {{ old('is_featured') ? 'checked' : '' }} class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                    Feature on Homepage
                </label>
            </div>

            <button type="submit" class="w-full bg-black text-white font-bold py-3 rounded hover:bg-gray-800 transition">
                Save Product
            </button>
        </form>
    </main>

</body>
</html>