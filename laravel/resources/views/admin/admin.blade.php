@extends('layouts.admin')

@section('content')
    <div class="container h-23vh w-100 admin__index">
        <div class="d-flex justify-content-center h-100 w-100 align-center flex_mobile">
            <a href="{{ route('admin.orders') }}" class="btn btn-success m-auto">Просмотр и редактирование заказов</a>
            <a href="{{ route('admin.products') }}" class="btn btn-primary m-auto">Добавление и редактирование товаров в каталоге</a>
            <a href="{{ route('admin.category') }}" class="btn btn-danger m-auto">Добавление и удаление категорий</a>
        </div>
    </div>
@endsection
