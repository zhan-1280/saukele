@extends('layouts.admin')

@section('content')
    <div class="container admin__view_order z-index-1">
        <div class="row cart__items">
            <div class="col-md-3 left">
                <h1 class="mb-3 text-30px">Заказ №{{ $order->id }}</h1>
                <p>Дата заказа: {{ $order->created_at }} (+0 GMT)</p>
                <p>Статус: @if ($order->status == 'Подтвержден')
                        <a class="btn btn-success m-auto">{{ $order->status }}</a>
                    @elseif($order->status == 'Отменен')
                        <a class="btn btn-danger m-auto">{{ $order->status }}</a>
                    @elseif($order->status !== 'Отменен' && $order->status !== 'Подтвержден')
                        <a class="btn btn-primary m-auto">Новый</a>
                    @endif
                </p>
                <p>ФИО заказчика: <strong>{{ $order->user->surname }} {{ $order->user->name }}
                        {{ $order->user->patronymic }}</strong></p>
                <p>
                    <strong>Итого:
                        {{ $order->items->sum(function ($cart) {return $cart->product->price * $cart->quantity;}) }}
                        руб.</strong>
                </p>
                @if ($order->status == 'Новый')
                    <div class="d-flex">
                        <form method="POST" action="{{ route('admin.cancelOrder', $order->id) }}" class="ms-0">
                            @csrf
                            <button type="submit" class="btn btn-danger">Отменить</button>
                        </form>
                        <form method="POST" action="{{ route('admin.confirmOrder', $order->id) }}" class="ms-5">
                            @csrf
                            <button type="submit" class="btn btn-success">Подтвердить</button>
                        </form>
                    </div>
                @endif
            </div>
            <div class="col-md-8 right ms-5 order__cart_info">
                @foreach ($order->items as $item)
                    <div class="busket-card row white-bg br-15px mb-4 me-4 w-100">
                        <div class="col-md-6">
                            <img src="/img/{{ $item->product->image }}" alt="product-image-{{ $item->id }}"
                                class="w-100"></td>
                        </div>
                        <div class="col-md-6 d-flex justify-content-around flex-column right p-3">
                            <P class="border_strong text-25px">Название товара: <strong>{{ $item->product->name }}</strong></P>
                            <P class="border_strong text-25px">Цена: <strong>{{ intval($item->price) }} руб.</strong></P>
                            <P class="border_strong text-25px">Количество: <strong>{{ $item->quantity }} шт.</strong></P>
                            <p class="border_strong text-25px">Размер: <strong>{{ $item->product->size }}</strong></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
