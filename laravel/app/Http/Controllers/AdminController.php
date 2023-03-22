<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function adminIndex()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return view('admin.admin');
        else
            return view('admin.none-admin');
    }

    public function orders(Request $request)
    {
        $status = $request->get('status');

        $orders = Order::query();

        if ($status) {
            $orders->where('status', $status);
        }

        $orders = $orders->orderBy('created_at', 'desc')->paginate(10);

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return view('admin.orders', compact('orders', 'status'));
        else
            return view('admin.none-admin');
    }

    public function viewOrder($id)
    {
        $order = Order::findOrFail($id);

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return view('admin.view_order', compact('order'));
        else
            return view('admin.none-admin');
    }

    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'Отменен';
        $order->save();

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return redirect()->back()->with('success', 'Заказ отменен.');
        else
            return view('admin.none-admin');
    }

    public function confirmOrder($id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'Подтвержден';
        $order->save();

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return redirect()->back()->with('success', 'Заказ подтвержден.');
        else
            return view('admin.none-admin');
    }

    public function products(Request $request)
    {
        $search = $request->get('search');

        $category = DB::table('categories')->get();

        $products = Product::query();

        if ($search) {
            $products->where('name', 'like', '%' . $search . '%');
        }

        $products = $products->orderBy('created_at', 'desc')->paginate(10);

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return view('admin.products', compact('products', 'search', 'category'));
        else
            return view('admin.none-admin');
    }

    public function addProduct(Request $request)
    {
        $product = new Product;

        $product->name = $request->get('name');
        // Сохраняем картинку в папку storage/app/public/images
        $product->image = $request->get('image');
        $product->price = $request->get('price');
        $product->category = $request->get('category');
        $product->quantity = $request->get('quantity');
        $product->description = $request->get('description');
        $product->size = $request->get('size');

        $product->save();

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return redirect()->back()->with('success', 'Товар добавлен.');
        else
            return view('admin.none-admin');
    }



    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $category = DB::table('categories')->get();

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return view('admin.editProduct', compact('product', 'category'));
        else
            return view('admin.none-admin');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->name = $request->get('name');
            $product->description = $request->get('description');
            $product->price = $request->get('price');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = $image->getClientOriginalName();
                $image->storeAs('public/images', $filename);
                $product->image = $filename;
            }

            $product->category = $request->get('category');
            $product->save();

            return redirect()->route('admin.products');
        } else {
            return redirect()->back()->with('error', 'Товар не найден.');
        }
    }



    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return redirect()->back()->with('success', 'Товар удален.');
        else
            return view('admin.none-admin');
    }

    public function categories()
    {
        $categories = Category::all();

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return view('admin.categories', compact('categories'));
        else
            return view('admin.none-admin');
    }

    public function addCategory(Request $request)
    {
        $category = new Category;

        $category->name_category = $request->get('name');
        $category->save();

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return redirect()->back()->with('success', 'Категория добавлена.');
        else
            return view('admin.none-admin');
    }

    public function deleteCategory($id)
    {
        $category  = Category::find($id);
        $category->delete();

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return redirect()->back()->with('success', 'Категория  удален.');
        else
            return view('admin.none-admin');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return view('admin.edit-category', compact('category'));
        else
            return view('admin.none-admin');
    }

    // метод обновления категории в базе данных
    public function updateCategory(Request $request, $id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->name_category = $request->get('name');
            $category->save();
            return redirect()->route('admin.category');
        } else {
            return redirect()->back()->with('error', 'Категория не найдена.');
        }

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role == '2')
            return view('admin.edit-category', compact('category'));
        else
            return view('admin.none-admin');
    }
}
