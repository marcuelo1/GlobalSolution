@extends('layouts.app')

@section('content')
    <h2>{{$product->ProductName}}</h2>
    <h6>Price: {{$product->Price}} &nbsp;&nbsp;&nbsp; MinOrder: {{$product->MinOrder}}</h6>
    <br>
    <div class="media">
        <img src="/../storage/app/public/images/{{$product->Image}}" class="align-self-center mr-3" style="width: 500px">
    </div>
    <br>
    <h5>Product Description: <br> {{$product->Description}}</h5>
    <hr>
    <h2>Seller Info</h2>
    <ul class="list-group">
        <li class="list-group-item">Name: {{$seller->name}}</li>
        <li class="list-group-item">Location: {{$seller->location}}</li>
    </ul>
    <br>
    @guest
    @else
        @if (Auth::user()->user_pos == 'Buyer')
            <h6>Interested? Contact the Seller Now! <a href="/../public/message/{{$seller->id}}">Click here.</a></h6>
        @endif
    @endguest
@endsection
