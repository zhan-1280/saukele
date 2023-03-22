@extends('layouts.app')
@section('content')
    <div class="container catalog mb-5 pt-5 z-index-1">
        <h1 class="text-36px ms-5">Каталог товаров</h1>
        <div class="row">
            <div class="col-md-2 left">
                <div class="filters">
                    <form action="{{ route('catalog') }}" method="GET">
                        <div class="form-group">
                            <label for="category">Категория:</label>
                            <select name="category" class="form-control form-category" id="category">
                                <option value="">Все категории</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $category->id == request()->query('category') ? 'selected' : '' }}>
                                        {{ $category->name_category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex flex-column">
                            <label>Сортировка:</label>
                            <div class="ms-2 form-check">
                                <input class="form-check-input" type="radio" name="sort_by" id="sort_by_name"
                                    value="name" {{ request()->query('sort_by') == 'name' ? 'checked' : '' }}>
                                <label class="form-check-label" for="sort_by_name">
                                    По имени
                                </label>
                            </div>
                            <div class="ms-2 form-check">
                                <input class="form-check-input" type="radio" name="sort_by" id="sort_by_price"
                                    value="price" {{ request()->query('sort_by') == 'price' ? 'checked' : '' }}>
                                <label class="form-check-label" for="sort_by_price">
                                    По цене
                                </label>
                            </div>
                            <div class="ms-2 form-check">
                                <input class="form-check-input" type="radio" name="sort_by" id="sort_by_year"
                                    value="year" {{ request()->query('sort_by') == 'year' ? 'checked' : '' }}>
                                <label class="form-check-label" for="sort_by_year">
                                    По году производства
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Применить</button>
                    </form>

                </div>
            </div>
            <div class="col-md-10 right">
                <div class="products">
                    @if ($products->isEmpty())
                        <div class="alert alert-danger w-100 m-0" role="alert">
                            <h2 class="m-0 p-0">Каталог пуст.</h2>
                        </div>
                    @else
                        @foreach ($products as $product)
                            <div class="product">
                                <a href="{{ route('product', $product->id) }}"
                                    class="text-black none-underline product_link">
                                    <img src="/img/{{ $product->image }}" alt="{{ $product->name }}">
                                    <h3 class="mt-3 text-red text-center"><strong>{{ $product->name }}</strong></h3>
                                    <p class="price w-100 text-center text-25px">{{ $product->price }} руб.</p>
                                    <form action="{{ route('cart.add', ['productId' => $product->id]) }}" method="POST"
                                        class="w-100">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100 mt-3 text-25px ">Добавить в
                                            корзину</button>
                                    </form>
                                </a>

                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
