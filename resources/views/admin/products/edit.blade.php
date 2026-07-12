<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased flex h-screen overflow-hidden">

    <div class="w-64 bg-[#111827] text-white flex flex-col h-screen flex-shrink-0 shadow-lg">
        <div class="p-6 mb-4">
            <h1 class="text-xl font-bold tracking-widest uppercase leading-snug">LUMIÈRE<br>ADMIN</h1>
        </div>
        <nav class="flex-1 px-4 space-y-2 text-sm font-medium">
            <a href="/admin/products" class="block px-4 py-3 text-white bg-gray-800 rounded transition-colors">Products</a>
            <a href="/" target="_blank" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">View Live Store</a>
        </nav>
    </div>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <div class="p-8 lg:p-12 max-w-6xl mx-auto w-full">
            
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Edit Product</h2>
                    <p class="text-gray-500">Update the details below to modify the product in the database.</p>
                </div>
                <a href="/admin/products" class="text-sm font-medium text-gray-600 hover:text-black underline transition-colors">Back to List</a>
            </div>

            <form action="/admin/products/{{ $product->id }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 w-full">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-black">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price ($)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-black">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity In Stock</label>
                        <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" required min="0" class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category" class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-black">
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}" {{ old('category', $product->category) == $category->name ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6 p-6 border border-gray-100 rounded bg-gray-50">
                    <h3 class="text-sm font-bold text-gray-800 mb-4">Product Images</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-2">Main Image (Required)</label>
                            <input type="file" name="image" accept="image/*" class="w-full text-sm border border-gray-300 rounded p-2 bg-white focus:outline-none focus:ring-2 focus:ring-black">
                            @if($product->image) <p class="text-xs text-green-600 mt-2">✓ Current image exists</p> @endif
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-2">Sub Image 1 (Optional)</label>
                            <input type="file" name="image_2" accept="image/*" class="w-full text-sm border border-gray-300 rounded p-2 bg-white focus:outline-none focus:ring-2 focus:ring-black">
                            @if($product->image_2) <p class="text-xs text-green-600 mt-2">✓ Current image exists</p> @endif
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-2">Sub Image 2 (Optional)</label>
                            <input type="file" name="image_3" accept="image/*" class="w-full text-sm border border-gray-300 rounded p-2 bg-white focus:outline-none focus:ring-2 focus:ring-black">
                            @if($product->image_3) <p class="text-xs text-green-600 mt-2">✓ Current image exists</p> @endif
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="5" required class="w-full border border-gray-300 rounded p-3 focus:outline-none focus:ring-2 focus:ring-black">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="flex items-center mb-8">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                    <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                        Feature on Homepage
                    </label>
                </div>

                <button type="submit" class="w-full bg-black text-white py-4 rounded text-sm uppercase tracking-widest font-bold hover:bg-gray-800 transition-colors">
                    Update Product
                </button>
            </form>
            
        </div>
    </div>

</body>
</html>