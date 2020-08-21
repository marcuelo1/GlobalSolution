@extends('layouts.app')

@section('content')
    <h2>Chat List</h2>
    <hr>
    <ul class="list-group list-group-flush">
        @foreach ($chatlist as $item)
        <li class="list-group-item"><a href="/../public/message/{{$item->id}}}">{{$item->name}}</a></li>
        @endforeach
    </ul>
@endsection