@extends('layouts.admin')

@section('content')
    <div class="container admin__category z-index-1">
        <h1 class="mb-3 text-30px">Список категорий</h1>
        <div class="row cart__items">
            <div class="col-md-3 left">
                <h2 class="text-25px">Добавить Категорию</h2>
                <form action="{{ route('admin.addCategory') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="text-25px" for="name">Название категории:</label>
                        <input type="text" name="name" id="name" class="form-control mb-2 text-25px">
                    </div>
                    <button type="submit" class="btn btn-primary text-25px">Добавить</button>
                </form>
            </div>
            <div class="col-md-8 right">
                @foreach ($categories as $category)
                    <div class="busket-card row white-bg br-15px mb-4 me-4 w-100">
                        <div class="d-flex justify-content-around">
                            <p class="text-25px me-3 mt-3"><strong>№{{ $category->id }}</strong></p>
                            <p class="text-25px text24px400 mt-3 name__category">Название категории:
                                <strong class="text-black ms-2">{{ $category->name_category }}</strong>
                            </p>
                            <div class="d-flex align-center flex_mobile">
                                <a href="{{ route('admin.editCategories', ['id' => $category->id]) }}"
                                    class="btn btn-primary me-4 text-25px">Изменить</a>
                                <form action="{{ route('admin.deleteCategories', ['id' => $category->id]) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger text-25px"
                                        onclick="return confirm('Вы уверены?')">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
