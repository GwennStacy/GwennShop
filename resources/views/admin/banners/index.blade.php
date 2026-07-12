<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Banners</title>
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
            <h1 class="text-3xl font-serif text-gray-900 tracking-wide">Manage Banners</h1>
            <a href="/admin/banners/create" class="bg-black text-white px-6 py-2 rounded shadow hover:bg-gray-800 transition-colors">Upload New Banner</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preview</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Upload Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($banners as $banner)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('storage/' . $banner->image) }}" class="h-20 object-cover rounded shadow border" alt="Banner Preview">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($banner->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $banner->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                @if(!$banner->is_active)
                                <form action="/admin/banners/{{ $banner->id }}/activate" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900">Set Active</button>
                                </form>
                                @endif
                                
                                <form action="/admin/banners/{{ $banner->id }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            @if($banners->isEmpty())
                <div class="p-8 text-center text-gray-500">
                    No banners uploaded yet.
                </div>
            @endif
        </div>
    </main>
</body>
</html>
