<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        $productId = $request->input('product_id');
        $favorites = session()->get('favorites', []);

        if (in_array($productId, $favorites)) {
            // Remove from favorites
            $favorites = array_diff($favorites, [$productId]);
            $status = 'removed';
        } else {
            // Add to favorites
            $favorites[] = $productId;
            $status = 'added';
        }

        session()->put('favorites', $favorites);

        return response()->json([
            'success' => true,
            'status' => $status,
            'favorites_count' => count($favorites)
        ]);
    }

    public function index()
    {
        $favoritesIds = session()->get('favorites', []);
        
        if (empty($favoritesIds)) {
            $products = collect();
        } else {
            $products = Product::whereIn('id', $favoritesIds)->get();
        }

        return view('favorites.index', compact('products'));
    }
}
