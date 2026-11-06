@extends('layout')
@section('content')
    <h3>Контакты</h3>
    <p>Название: {{$contacts['name']}}</p>
    <p>Адрес: {{$contacts['address']}}</p>
    <p>Телефон: {{$contacts['phone']}}</p>
    <p>Почта: {{$contacts['email']}}</p>
@endsection