<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->orderBy('created_at', 'desc')->get();
        return view('orders.index', ['orders' => $orders]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string',
        ]);

        if (!Auth::attempt(['email' => Auth::user()->email, 'password' => $request->password])) {
            return back()->withErrors(['password' => 'Неверный пароль']);
        }

        $user = User::find(Auth::id());
        $carts = Cart::where('user_id', Auth::id())->get();


        if (!$carts) {
            return response()->json(['cart' => 'Empty']);
        }

        foreach ($carts as $cart) {
            if ($cart->quantity > $cart->product->quantity) {
                return back()->withErrors(['cart' => "Недостаточно товара '{$cart->product->name}' в наличии"]);
            }
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->save();

        foreach ($carts as $cart) {
            $order->items()->create([
                'product_id' => $cart->product->id,
                'quantity' => $cart->quantity,
                'price' => $cart->product->price,
            ]);
            $cart->delete();
        }

        return redirect()->route('orders.show', ['order' => $order])->with('success', 'Заказ успешно оформлен');
    }

    public function show(Order $order)
    {
        $user = Auth::user();
        if ($user->id !== $order->user_id) {
            abort(403);
        }

        return view('orders.show', ['order' => $order]);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Заказ успешно удален');
    }
}
