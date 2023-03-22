@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <h1>Мои заказы</h1>
        </div>
        @if (count($orders) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">{{ __('Номер заказа') }}</th>
                        <th class="text-center" scope="col">{{ __('Дата') }}</th>
                        <th class="text-center" scope="col">{{ __('Статус') }}</th>
                        <th class="text-center" scope="col">{{ __('Количество товаров') }}</th>
                        <th class="text-center" scope="col">{{ __('Сумма') }}</th>
                        <th class="text-center" scope="col">{{ __('Действия') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="text-center">{{ $order->id }}</td>
                            <td class="text-center">{{ $order->created_at->format('d.m.Y H:i') }} (+0 GMT)</td>
                            <td class="text-center">{{ $order->status }}</td>
                            <td class="text-center">{{ $order->items->sum('quantity') }}</td>
                            <td class="text-center">
                                {{ $order->items->sum(function ($cart) {return $cart->product->price * $cart->quantity;}) }}
                                руб.</td>
                            <td class="d-flex justify-content-center">
                                @if ($order->status == 'Новый')
                                    <a href="{{ route('orders.show', ['order' => $order->id]) }}" class="btn btn-primary">
                                        {{ __('Просмотреть') }}
                                    </a>
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="ms-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm h-100">Удалить</button>
                                    </form>
                                @else
                                    <a href="{{ route('orders.show', ['order' => $order->id]) }}" class="btn btn-primary">
                                        {{ __('Просмотреть') }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info" role="alert">
                У вас пока нет заказов
            </div>
        @endif
    </div>
@endsection
