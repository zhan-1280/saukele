@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Заказ #{{ $order->id }}</h1>
        <p>Дата создания заказа: {{ $order->created_at }} (+0 GMT)</p>
        <p>Статус заказа: {{ $order->status }}</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Количество</th>
                    <th>Цена за единицу</th>
                    <th>Итоговая стоимость</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->quantity * $item->price }}руб.</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="">
                    <td colspan="1">Общая стоимость:</td>
                    <td colspan="2">
                        <p>
                            <strong>
                                {{ $order->items->sum(function ($cart) {return $cart->product->price * $cart->quantity;}) }}
                                руб.
                            </strong>
                        </p>
                    </td>
                    <td>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                        </form>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
