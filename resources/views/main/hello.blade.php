@extends('layout')
@section('content')
    <h2>Привет! Это страница приветствия</h2>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">Дата</th>
      <th scope="col">Название</th>
      <th scope="col">Изображение</th>
      <th scope="col">Краткое описание</th>
      <th scope="col">Описание</th>
    </tr>
  </thead>
  <tbody>
    @foreach($articles as $article)
    <tr>
      <th scope="row">{{$article['date']}}</th>
      <td>{{$article['name']}}</td>
      <td><a href="/gallery/{{$article['full_image']}}"><img src="{{URL::asset('/images/'.$article['preview_image'])}}" alt="" height="280"></a></td>
      <td>{{$article['shortDesc'] ?? ''}}</td>
      <td>{{$article['desc']}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection