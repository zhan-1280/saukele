@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Где нас найти?</h1>
        <div class="d-flex w-100 mt-5 flex-mobile-column ">
            <div class="where__info desktop-dnone">
                <address>Пр. Комарова, 13</address>
                <address><a href="tel:+79620473900">+7(962)047-39-00</a></address>
                <address><a href="mailto:user@user">user@user</a></address>
            </div>
            <img src="{{ url('img/map.jpg') }}" alt="" class="where__map">
            <div class="where__info mobile-dnone">
                <address>Пр. Комарова, 13</address>
                <address><a href="tel:+79620473900">+7(962)047-39-00</a></address>
                <address><a href="mailto:user@user">user@user</a></address>
            </div>
        </div>
    </div>
@endsection
