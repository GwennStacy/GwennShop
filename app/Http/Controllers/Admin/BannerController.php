<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'image' => $imagePath,
            'is_active' => false,
        ]);

        return redirect('/admin/banners')->with('success', 'Banner uploaded successfully.');
    }

    public function activate($id)
    {
        // Deactivate all banners
        Banner::query()->update(['is_active' => false]);

        // Activate the selected one
        $banner = Banner::findOrFail($id);
        $banner->update(['is_active' => true]);

        return redirect('/admin/banners')->with('success', 'Banner set as active successfully.');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect('/admin/banners')->with('success', 'Banner deleted successfully.');
    }
}
