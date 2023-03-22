@extends('layouts.app')

@section('content')
    <div class="container cart z-index-1">
        @if ($carts->isEmpty())
            <div class="card-header">
                <h1 class="mt-3 text-30px">Корзина</h1>
            </div>
            <div class="alert alert-info mb-5" role="alert">
                <h2>Корзина пуста.</h2>
            </div>
        @else
            <div class="row cart__items">
                <div class="col-md-3 left">
                    <div class="card-header mt-3">
                        <h1 class="text-30px">Корзина</h1>
                    </div>
                    <p class="m-0 text-25px">Количество предметов в корзине: <strong>{{ $count }} шт.</strong></p>
                    <p class="m-0 text-25px">Общая стоимость:
                        <strong>{{ $carts->sum(function ($cart) {return $cart->product->price * $cart->quantity;}) }}
                            руб.</strong>
                    </p>
                    <p class="m-0 text-25px"><br>Для того чтобы оформить заказ введите пароль:</p>
                    <form action="{{ route('orders.store') }}" method="POST" class="">
                        @csrf
                        <div class="form-group pe-5 pt-2">
                            <input id="password" type="password" name="password" required class="w-100">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2 text-25px">Сформировать заказ</button>
                    </form>
                </div>
                <div class="col-md-9 right">
                    @foreach ($carts as $cart)
                        <div class="busket-card row white-bg br-15px mb-4 me-4 w-100">
                            <div class="col-md-6 p-3 cart__left">
                                <img src="/img/{{ $cart->product->image }}" alt="black-blue" class="w-100 cart__photo">
                            </div>
                            <div class="col-md-6 p-3 text-black cart__right">
                                <div class="d-flex">
                                    <p class="text-30px mt-3 me-auto"><strong>{{ $cart->Product->name }}</strong></p>
                                    <a href="{{ route('cart.remove.all', ['cartId' => $cart->id]) }}"
                                        class="mt-3 close-button ms-5">
                                        <img class="" src="img/close.svg" alt="">
                                    </a>
                                </div>
                                <div class="d-flex mt-4 mb-3">
                                    <p class="cart__product__size  mt-2 text24px400">Размер:
                                        <strong class="text-black ms-3">{{ $cart->Product->size }}</strong>
                                    </p>
                                </div>
                                <div class="quantity">
                                    <p class="mt-2 text24px400">Количество :</p>
                                    <div class="d-flex quantity_buttons text24px weight700">
                                        <a href="/remove-from-card/{{ $cart->product_id }}" class="btn  minus me-3">-</a>
                                        <p class="m-0">{{ $cart->quantity }} шт.</p>
                                        <a href="/add-on-cart/{{ $cart->product_id }}"
                                            class="btn btn-primary plus ms-3">+</a>
                                    </div>
                                </div>
                                <p class="cart__price mt-5 mt-2">{{ intval($cart->Product->price) * $cart->quantity }} руб.
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

@endsection
