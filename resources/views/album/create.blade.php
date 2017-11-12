
@extends('layouts.app')

@section('content')
  <ul>
    @foreach($errors->all() as $error)
      <li>{{$error}}</li>
      @endforeach
  </ul>
  <h1>Last created album {{$last_album->name or 'unknown'}}</h1>
  <form action="/album/store" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="text" name="name">
    <input type="file" name="photo">
    <input type="submit" name="">
  </form>
@endsection