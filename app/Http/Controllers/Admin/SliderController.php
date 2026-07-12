<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::with('category')->latest()->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.sliders.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $imagePath = $request->file('image')->store('sliders', 'public');

        Slider::create([
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'is_active' => true, // Active by default
        ]);

        return redirect('/admin/sliders')->with('success', 'Slider uploaded successfully.');
    }

    public function toggleActive($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->update(['is_active' => !$slider->is_active]);

        $status = $slider->is_active ? 'activated' : 'deactivated';
        return redirect('/admin/sliders')->with('success', "Slider $status successfully.");
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect('/admin/sliders')->with('success', 'Slider deleted successfully.');
    }
}
