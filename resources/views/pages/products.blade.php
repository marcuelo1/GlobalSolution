@extends('layouts.app')

@section('content')
    <h2>
        Products
        <a class="btn btn-outline-primary btn-sm" href="products/create">Add Product</a>
    </h2>
    <hr>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Min Order</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{$product->ProductName}}</td>
                    <td>{{$product->Category}}</td>
                    <td>{{$product->Price}}</td>
                    <td>{{$product->MinOrder}}</td>
                    <td><a class="btn btn-info btn-sm" href="/products/{{$product->id}}/edit">Edit</a></td>
                    <td>
                        {!! Form::open(['action' => ['ProductsController@destroy', $product->id], 'method' => 'POST']) !!}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) }}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection