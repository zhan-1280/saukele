@extends('layouts.app')

@section('content')
    <div class="container product_index pt-3 pb-5 z-index-1">
        <div class="d-flex mb-3 ms-5">
            <a href="{{ url('/catalog') }}" class="text-black none-underline">Каталог</a>
            <img src="/img/arrow-black.svg" alt="-->" class="ms-3 me-3">
            <a href="{{ route('product', $product->id) }}" class="text-black none-underline">{{ $product->name }}</a>
        </div>
        <div class="row">
            <div class="col-md-7">
                <img src="/img/{{ $product->image }}" alt="{{ $product->name }}" class="img-thumbnail w-100 h-100">
            </div>
            <div class="col-md-5 red-bg">
                <div class="poduct__right">
                    <h2 class="text-36px mt-1 text-white mt-5">{{ $product->name }}</h2>
                    <p class="product__price text-25px text-red mt-4 mb-5">{{ $product->price }} руб.</p>
                    <p class="product__size mt-4 text-25px text-white">Размер: <strong
                            class="ms-2">{{ $product->size }}</strong></p>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex flex-column pe-5">
                        @csrf
                        <button type="submit" class="btn__in_cart mt-3">В корзину</button>
                    </form>
                    <p class="text-25px mt-5 text-white">Описание:<br>{{ $product->description }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
