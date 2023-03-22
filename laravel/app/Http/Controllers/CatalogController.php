<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    // public function catalog()
    // {
    //     $sort = request('sort', 'name');
    //     $products = product::orderBy($sort)->get();
    //     return view('catalog', compact('products'));
    // }
    public function catalog(Request $request)
    {
        // Получаем параметры сортировки и фильтрации
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $category = $request->input('category', '');

        // Получаем список товаров с учетом параметров сортировки и фильтрации
        $products = Product::where('quantity', '>', 0)
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->orderBy($sortBy, $sortOrder)
            ->get();

        $categories = Category::all();
        return view('catalog', compact('products', 'category', 'categories', 'sortBy', 'sortOrder'));
    }
}
