<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SeamlessImageController;
// បញ្ជាក់៖ បើ OrderController របស់អ្នកមិននៅក្នុង Folder Admin ទេ សូមប្តូរទៅ App\Http\Controllers\OrderController វិញ
use App\Http\Controllers\Admin\OrderController;


/*
|--------------------------------------------------------------------------
| Public Routes (ទំព័រសម្រាប់អតិថិជនទូទៅ)
|--------------------------------------------------------------------------
*/

// ទំព័រដើម (Homepage)
Route::get('/', function () {
    $categories = Category::all(); 
    $seamlessImages = \App\Models\SeamlessImage::where('is_active', true)->orderBy('id')->get();
    return view('index', compact('categories', 'seamlessImages')); 
});

// Seamless Image Serving Route
Route::get('/seamless-image/{id}', function ($id) {
    $image = \App\Models\SeamlessImage::findOrFail($id);
    $path = storage_path('app/public/' . $image->image);

    if (!file_exists($path)) {
        abort(404);
    }

    $file = file_get_contents($path);
    $type = mime_content_type($path);

    return response($file, 200)->header('Content-Type', $type);
});

// Search Route
Route::get('/search', function (Illuminate\Http\Request $request) {
    $query = $request->input('q');
    $products = Product::where('name', 'like', "%{$query}%")
                ->orWhere('category', 'like', "%{$query}%")
                ->get();
    return view('search', compact('products', 'query'));
});

// ទំព័រ Categories ផ្សេងៗ
Route::get('/women', function () {
    $products = Product::where('category', 'Women')->latest()->get();
    return view('category.women', compact('products'));
});
Route::get('/men', function () { return view('category.men'); });
Route::get('/accessories', function () { return view('category.accessories'); });
Route::get('/sport', function () { return view('category.sport'); });
Route::get('/shoes', function () { return view('category.shoes'); });
Route::get('/anime', function () { return view('category.anime'); });

// Dynamic Category Route (ទំព័រ Category ស្វ័យប្រវត្តិ)
Route::get('/category/{slug}', function ($slug) {
    // ស្វែងរក Category ពី Database តាមរយៈ slug
    $categoryRecord = Category::where('slug', $slug)->first();
    
    // បើមាន Category ក្នុង DB នោះយើងទាញយកផលិតផលតាមឈ្មោះ Category នោះ
    // បើមិនមានទេ យើងព្យាយាមទាញតាម slug ផ្ទាល់
    if ($categoryRecord) {
        $products = Product::where('category', $categoryRecord->name)->latest()->get();
    } else {
        $products = Product::where('category', 'like', "%{$slug}%")->latest()->get();
    }

    // ប្រើប្រាស់ Unified Category View (មាន Slide Banner) សម្រាប់គ្រប់ Category ទាំងអស់
    $sliders = \App\Models\Slider::where('is_active', true)
        ->where(function ($query) use ($categoryRecord) {
            $query->whereNull('category_id');
            if ($categoryRecord) {
                $query->orWhere('category_id', $categoryRecord->id);
            }
        })
        ->orderBy('id')
        ->get();
        
    return view('category.show', compact('products', 'categoryRecord', 'slug', 'sliders'));
});

// ទំព័រលម្អិតរបស់ផលិតផលនីមួយៗ (Product Detail)
Route::get('/product/{slug}', function ($slug) {
    $product = Product::where('slug', $slug)->firstOrFail();
    $similarProducts = Product::where('id', '!=', $product->id)->inRandomOrder()->take(10)->get();
    $bestSellers = Product::where('id', '!=', $product->id)->latest()->take(10)->get();
    $categories = \App\Models\Category::all();
    $banner = \App\Models\Banner::where('is_active', true)->latest()->first();
    return view('product.show', compact('product', 'similarProducts', 'bestSellers', 'categories', 'banner'));
});


/*
|--------------------------------------------------------------------------
| Cart & Checkout Routes (កន្ត្រកទំនិញ និងទូទាត់ប្រាក់)
|--------------------------------------------------------------------------
*/
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Favorite Routes
|--------------------------------------------------------------------------
*/
Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [CartController::class, 'placeOrder']);
// ត្រូវប្រាកដថា Action របស់ Form រត់មកចំមុខងារថ្មីនេះ
Route::post('/aba/checkout', [CartController::class, 'payWithAbaPayway'])->name('aba.checkout');
Route::post('/aba/verify', [CartController::class, 'verifyPayment'])->name('aba.verify');
Route::get('/order-success/{id}', [CartController::class, 'orderSuccess'])->name('order.success');


/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes (ទំព័រសម្រាប់អ្នកគ្រប់គ្រង)
|--------------------------------------------------------------------------
*/
// ប្រើប្រាស់ prefix('admin') ដើម្បីកុំឲ្យសរសេរពាក្យ /admin/ ជាន់គ្នាផ្តេសផ្តាស
Route::prefix('admin')->group(function () {
    
    // --- ផ្នែក Orders ---
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    // --- ផ្នែក Products ---
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}/edit', [ProductController::class, 'edit']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    // --- ផ្នែក Categories ---
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/create', [CategoryController::class, 'create']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    
    // --- ផ្នែក Banners ---
    Route::get('/banners', [BannerController::class, 'index']);
    Route::get('/banners/create', [BannerController::class, 'create']);
    Route::post('/banners', [BannerController::class, 'store']);
    Route::post('/banners/{id}/activate', [BannerController::class, 'activate']);
    Route::delete('/banners/{id}', [BannerController::class, 'destroy']);
    
    // --- ផ្នែក Sliders ---
    Route::get('/sliders', [SliderController::class, 'index']);
    Route::get('/sliders/create', [SliderController::class, 'create']);
    Route::post('/sliders', [SliderController::class, 'store']);
    Route::patch('/sliders/{id}/toggle', [SliderController::class, 'toggleActive']);
    Route::delete('/sliders/{id}', [SliderController::class, 'destroy']);

    // Seamless Images Routes
    Route::get('/seamless-images', [SeamlessImageController::class, 'index']);
    Route::get('/seamless-images/create', [SeamlessImageController::class, 'create']);
    Route::post('/seamless-images', [SeamlessImageController::class, 'store']);
    Route::patch('/seamless-images/{id}/toggle', [SeamlessImageController::class, 'toggleActive']);
    Route::delete('/seamless-images/{id}', [SeamlessImageController::class, 'destroy']);
    
});

Route::get('/banner-image/active', function () {
    $banner = \App\Models\Banner::where('is_active', true)->latest()->first();
    if ($banner && file_exists(storage_path('app/public/' . $banner->image))) {
        return response()->file(storage_path('app/public/' . $banner->image));
    }
    abort(404);
});

Route::get('/slider-image/{id}', function ($id) {
    $slider = \App\Models\Slider::findOrFail($id);
    if ($slider && file_exists(storage_path('app/public/' . $slider->image))) {
        return response()->file(storage_path('app/public/' . $slider->image));
    }
    abort(404);
});

Route::post('/bakong-khqr-checkout', [\App\Http\Controllers\CartController::class, 'payWithBakong'])->name('bakong.checkout');
Route::post('/verify-transaction', [App\Http\Controllers\CartController::class, 'verifyTransaction']);
Route::get('/clear-cart', function() { session()->forget('cart'); return 'កន្ត្រកត្រូវបានសម្អាតជោគជ័យ! សូមត្រឡប់ទៅទំព័រដើមវិញ'; });
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'kh'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch'); // ឈ្មោះនេះហើយដែលវាទាមទារ
use Illuminate\Support\Facades\Session;

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'kh'])) {
        // 💡 ប្រើប្រព័ន្ធ Session ផ្ទាល់របស់ PHP/Laravel ហ្មង ដើម្បីកុំឱ្យវាគាំង
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');
Route::get("/migrate-db", function () {
    try {
        $sql = file_get_contents(base_path("db_export.sql"));
        // Remove UTF-8 BOM if present
        $sql = preg_replace('/^\xEF\xBB\xBF/', '', $sql);
        \Illuminate\Support\Facades\DB::unprepared($sql);
        return "Database migrated successfully!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

