@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Редактировать товар</h1>

        <form method="post" action="{{ route('admin.updateProduct', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Название товара</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
            </div>

            <div class="form-group">
                <label for="description">Описание товара</label>
                <textarea class="form-control" id="description" name="description" rows="5">{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Цена товара</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}">
            </div>

            <div class="form-group">
                <label for="category">Категория товара</label>
                <select class="form-control" id="category" name="category">
                    @foreach ($category as $cat)
                        <option value="{{ $cat->id }}" {{ $cat->id == $product->category ? 'selected' : '' }}>
                            {{ $cat->name_category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Колличество товара на складе</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}">
            </div>

            <div class="form-group">
                <label for="size">Размер</label>
                <input type="text" class="form-control" id="size" name="size" value="{{ $product->size }}">
            </div>

            <div class="form-group mt-3">
                <label for="image">Изображение товара</label>
                <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection
