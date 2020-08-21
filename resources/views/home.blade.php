@extends('layouts.app')

@section('content')
<div class="container">
    <center>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <br>
        <h2>Search Product</h2>
        <br>
        {!! Form::open(['action' => 'HomeController@search', 'method' => 'GET']) !!}
            {{ Form::text('search', '', ['class' => 'form-control', 'style' => 'width:75%;']) }}
            <br>
            {{ Form::submit('Search', ['class' => 'btn btn-success']) }}
        {!! Form::close() !!}
        <hr>
        <h2>Supply, Demand, and Price here!</h2>
        <a href="/agriculture" class="btn btn-info">Agriculture</a>
    </center>
</div>
@endsection
