@extends('layouts.admin')

@section('content')
    <div class="container admin_orders z-index-1">
        <h1 class="mb-3 text-30px">Заказы</h1>
        <div class="row cart__items">
            <div class="col-md-3 left">
                <form action="{{ route('admin.orders') }}" method="GET">
                    <div class="form-group">
                        <label for="status">Статус:</label>
                        <select name="status" id="status" class="form-control">
                            <option value=""
                                {{ $status !== 'Новый' && $status !== 'Подтвержден' && $status === 'Отменен' ? 'selected' : '' }}>
                                Все</option>
                            <option value="Новый" {{ $status === 'Новый' ? 'selected' : '' }}>Новый</option>
                            <option value="Подтвержден" {{ $status === 'Подтвержден' ? 'selected' : '' }}>
                                Подтвержденный</option>
                            <option value="Отменен" {{ $status === 'Отменен' ? 'selected' : '' }}>Отмененный
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Фильтр</button>
                </form>
            </div>
            <div class="col-md-8 right ms-5">
                @foreach ($orders as $order)
                    <div class="busket-card row white-bg br-15px mb-4 me-4 w-100 text-25px">
                        <div class="d-flex flex-column justify-content-around p-4">
                            <div class="d-flex">
                                <p class="me-3">№{{ $order->id }}</p>
                                <p>ФИО: <strong>{{ $order->user->surname }} {{ $order->user->name }}
                                        {{ $order->user->patronymic }}</strong>
                                </p>
                            </div>
                            <p>{{ $order->created_at }} (+0 GMT)</p>
                            <div class="d-flex justify-content-between flex-column">

                                <p class="border_strong m-4 ms-0 mb-3 mt-0">Предметы:
                                    @foreach ($order->items as $item)
                                        <strong>{{ $item->product->name }} x {{ $item->quantity }}</strong>
                                    @endforeach
                                </p>
                                <p class="border_strong m-4 ms-0">Сумма:
                                    <strong>{{ $order->items->sum(function ($cart) {return $cart->product->price * $cart->quantity;}) }}
                                        руб.</strong>
                                </p>
                                <p class="">Статус
                                    @if ($order->status == 'Подтвержден')
                                        <strong class="btn btn-success m-auto text-25px">{{ $order->status }}</strong>
                                    @elseif($order->status == 'Отменен')
                                        <strong class="btn btn-danger m-auto text-25px">{{ $order->status }}</strong>
                                    @elseif($order->status !== 'Отменен' && $order->status !== 'Подтвержден')
                                        <strong class="btn btn-primary m-auto text-25px">Новый</strong>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <div class="d-flex">
                                    <a href="{{ route('admin.viewOrder', $order->id) }}"
                                        class="w-50 ms-0 me-auto btn btn-primary mb-1 text-25px me-auto">Подробнее</a>

                                    @if ($order->status == 'Новый')
                                        <div class="d-flex">
                                            <form method="POST" action="{{ route('admin.cancelOrder', $order->id) }}"
                                                class="m-auto">
                                                @csrf
                                                <button type="submit" class="btn btn-danger text-25px">Отменить</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.confirmOrder', $order->id) }}"
                                                class="m-auto">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-success text-25px">Подтвердить</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
