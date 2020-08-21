@extends('layouts.app')

@section('content')
    <h2>Results: {{$keyword}}</h2>
    <hr>
    @if (sizeof($products)>0)
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Product Name</th>
            <th scope="col">Price</th>
            <th scope="col">Min Order</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td><a href="products/{{$product->id}}">{{$product->ProductName}}</a></td>
                    <td>{{$product->Price}}</td>
                    <td>{{$product->MinOrder}}</td>
                </tr> 
            @endforeach
        </tbody>
      </table>
    @else
      <h4>No Results Found</h4>
    @endif
@endsection