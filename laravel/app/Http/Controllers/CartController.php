<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $product = Product::find($id);

        if (!$product) {
            abort(404);
        }

        $quantity = $request->input('quantity', 1);

        if ($quantity > $product->quantity) {
            return redirect()->back();
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            $cart = new Cart([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
            $cart->save();
        }

        return redirect()->route('catalog');
    }


    public function addOnCart(Request $request, $productId)
    {
        // Проверяем, что пользователь авторизован
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $product = Product::find($productId);
        $cart = Cart::where(['user_id' => auth()->id(), 'product_id' => $productId])->first();

        if ($cart) {
            $newQuantity = $cart->quantity + $request->input('quantity', 1);
            if ($newQuantity > $product->quantity) {
                return back()->withErrors(['quantity' => 'Недостаточно товара на складе']);
            }
            $cart->quantity = $newQuantity;
        } else {
            if ($request->input('quantity', 1) > $product->quantity) {
                return back()->withErrors(['quantity' => 'Недостаточно товара на складе']);
            }
            $cart = new Cart();
            $cart->user_id = auth()->id();
            $cart->product_id = $productId;
            $cart->quantity = $request->input('quantity', 1);
        }

        $cart->save();

        return redirect()->back();
    }


    public function removeFromCart(Request $request, $productId)
    {
        // Проверяем, что пользователь авторизован
        if (!Auth::check()) {
            return response()->json(['error' => 'Необходимо авторизоваться']);
        }

        $cart = Cart::where('product_id', $productId)->first();
        $cart->quantity--;
        if ($cart->quantity < 1) {
            $cart->delete();
        } else {
            $cart->save();
        }

        return redirect()->back();
    }

    public function removeAllFromCart($cartId)
    {
        $cart = Cart::find($cartId);

        if (!$cartId) {
            abort(404);
        }

        if ($cart) {
            $cart->delete();
        } else {
            return back()->withErrors(['cart' => "Товар '{$product->name}' не найден в корзине"]);
        }

        return redirect()->route('cart.show');
    }




    public function showCart()
    {
        // Проверяем, что пользователь авторизован
        if (!Auth::check()) {
            return redirect('/login');
        }

        $count = Cart::count(); // получаем количество предметов в корзине с помощью соответствующего пакета, например, cartalyst/cart
        $carts = Cart::where('user_id', Auth::id())->with('product')->get();

        return view('cart', compact('carts', 'count'));
    }
}
