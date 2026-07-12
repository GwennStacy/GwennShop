<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeamlessImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeamlessImageController extends Controller
{
    public function index()
    {
        $seamlessImages = SeamlessImage::latest()->get();
        return view('admin.seamless_images.index', compact('seamlessImages'));
    }

    public function create()
    {
        return view('admin.seamless_images.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'title' => 'nullable|string|max:255',
        ]);

        $imagePath = $request->file('image')->store('seamless_images', 'public');

        SeamlessImage::create([
            'image' => $imagePath,
            'title' => $request->title,
            'is_active' => true,
        ]);

        return redirect('/admin/seamless-images')->with('success', 'Image uploaded successfully.');
    }

    public function toggleActive($id)
    {
        $image = SeamlessImage::findOrFail($id);
        $image->is_active = !$image->is_active;
        $image->save();

        return redirect('/admin/seamless-images')->with('success', 'Image status updated.');
    }

    public function destroy($id)
    {
        $image = SeamlessImage::findOrFail($id);
        
        if (Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return redirect('/admin/seamless-images')->with('success', 'Image deleted successfully.');
    }
}
