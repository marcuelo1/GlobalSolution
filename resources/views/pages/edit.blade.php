@extends('layouts.app')

@section('content')
    {!! Form::open(['action' => ['ProductsController@update', $product->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

        <div class="form-group row">
            {{ Form::label('productName', 'Product Name') }}
            {{ Form::text('productName', $product->ProductName, ['class' => 'form-control']) }}
        </div>
        
        <div class="form-group row">
            {{ Form::label('productPrice', 'Product Price')}}
            {{ Form::number('productPrice', $product->Price, ['class' => 'form-control']) }}
        </div>
        
        <div class="form-group row">
            {{ Form::label('productCategory', 'Product Category') }}
            {{ Form::select('productCategory', ['Food' => 'Food', 'Furnitures' => 'Furnitures'], $product->Category, ['class' => 'custom-select']) }}
        </div>
        
        <div class="form-group row">
            {{ Form::label('productMinOrder', 'Product Min Order') }}
            {{ Form::number('productMinOrder', $product->MinOrder, ['class' => 'form-control']) }}
        </div>

        <div class="form-group row">
            {{ Form::label('productDescription', 'Product Description') }}
            {{ Form::textarea('productDescription', $product->Description, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::file('image') }}
        </div>
        
        {{ Form::hidden('_method', 'PUT') }}
        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}
@endsection