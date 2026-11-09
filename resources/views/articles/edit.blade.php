@extends('layout')
@section('content')
    <form action="/article/{{$article->id}}" method="post">
        @csrf
        @method('PUT')
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Дата публикации</label>
        <input name="datePublic" type="date" class="form-control" id="" value="{{$article->datePublic}}">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Заголовок</label>
        <input name="title" type="text" class="form-control" id="" value="{{$article->title}}">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Краткое описание</label>
        <input name="shortDesc" type="text" class="form-control" id="" value="{{$article->shortDesc}}">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Описание</label>
        <textarea name="desc" type="text" class="form-control">{{$article->desc}}</textarea>
    </div>


<!--     <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div> -->
    <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
@endsection