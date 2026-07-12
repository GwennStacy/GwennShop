<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Show the dashboard with all products
   public function index(Request $request)
    {
        $query = \App\Models\Product::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(10)->appends($request->all());
        $categories = \App\Models\Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    // Show the form to create a new product
   public function create()
    {
        // ត្រូវថែមបន្ទាត់នេះ ដើម្បីទាញយក Category ទាំងអស់ពី Database
        $categories = \App\Models\Category::all();

        // រួចបញ្ជូនវាទៅកាន់ View
        return view('admin.products.create', compact('categories'));
    }
    // Save the new product to the database
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:products,name',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:0', // ឆែកចំនួនស្តុក
        'description' => 'required|string',
        'category' => 'required|string',
        'image' => 'required|image|max:2048',
        'image_2' => 'nullable|image|max:2048',
        'image_3' => 'nullable|image|max:2048',
    ]);

    // រៀបចំការ Save រូបភាព
    $imagePath = $request->file('image')->store('products', 'public');
    
    $image2Path = null;
    if ($request->hasFile('image_2')) {
        $image2Path = $request->file('image_2')->store('products', 'public');
    }

    $image3Path = null;
    if ($request->hasFile('image_3')) {
        $image3Path = $request->file('image_3')->store('products', 'public');
    }

    Product::create([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'price' => $request->price,
        'quantity' => $request->quantity,
        'description' => $request->description,
        'category' => $request->category,
        'image' => $imagePath,
        'image_2' => $image2Path,
        'image_3' => $image3Path,
        'is_featured' => $request->has('is_featured'),
    ]);

    return redirect('/admin/products')->with('success', 'Product created successfully!');
}
// កូដសម្រាប់បញ្ជាឲ្យលុបផលិតផល និងរូបភាពចេញពីប្រព័ន្ធ
public function destroy($id)
{
    $product = \App\Models\Product::findOrFail($id);
    
    // បើសិនជាមានរូបភាព Upload ត្រូវលុបវាចេញពីកុំព្យូទ័រផងដែរ ដើម្បីកុំឲ្យធ្ងន់ម៉ាស៊ីន
    if ($product->image && str_starts_with($product->image, 'products/')) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
    }
    if ($product->image_2 && str_starts_with($product->image_2, 'products/')) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_2);
    }
    if ($product->image_3 && str_starts_with($product->image_3, 'products/')) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_3);
    }

    $product->delete();

    return redirect('/admin/products')->with('success', 'Product deleted successfully!');
}
// ១. បង្ហាញទំព័រ Edit ជាមួយទិន្នន័យចាស់
    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // ២. Update ទិន្នន័យថ្មីចូល Database
    public function update(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);

        $request->validate([
            // $id នៅទីនេះគឺដើម្បីប្រាប់ប្រព័ន្ធកុំឲ្យលោត Error បើយើងប្រើឈ្មោះដដែល
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'category' => 'required|string',
            'image' => 'nullable|image|max:2048', // ដាក់ nullable ព្រោះគេអាចនឹងមិនប្តូររូប
            'image_2' => 'nullable|image|max:2048',
            'image_3' => 'nullable|image|max:2048',
        ]);

        // ឆែកមើលបើសិនជាមានការ Upload រូបភាពថ្មី យើងនឹងលុបរូបចាស់ចោល រួច Save រូបថ្មី
        if ($request->hasFile('image')) {
            if ($product->image && str_starts_with($product->image, 'products/')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('image_2')) {
            if ($product->image_2 && str_starts_with($product->image_2, 'products/')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_2);
            }
            $product->image_2 = $request->file('image_2')->store('products', 'public');
        }

        if ($request->hasFile('image_3')) {
            if ($product->image_3 && str_starts_with($product->image_3, 'products/')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_3);
            }
            $product->image_3 = $request->file('image_3')->store('products', 'public');
        }

        // Update ទិន្នន័យផ្សេងៗទៀត
        $product->name = $request->name;
        $product->slug = \Illuminate\Support\Str::slug($request->name);
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->category = $request->category;
        $product->is_featured = $request->has('is_featured');
        
        $product->save();

        return redirect('/admin/products')->with('success', 'Product updated successfully!');
    }
}