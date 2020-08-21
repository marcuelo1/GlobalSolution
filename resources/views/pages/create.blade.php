@extends('layouts.app')

@section('content')
    {!! Form::open(['action' => 'ProductsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

        <div class="form-group row">
            {{ Form::label('productName', 'Product Name') }}
            {{ Form::text('productName', '', ['class' => 'form-control']) }}
        </div>
        
        <div class="form-group row">
            {{ Form::label('productPrice', 'Product Price')}}
            {{ Form::number('productPrice', '', ['class' => 'form-control']) }}
        </div>
        
        <div class="form-group row">
            {{ Form::label('productCategory', 'Product Category') }}
            {{ Form::select('productCategory', ['Agriculture' => 'Agriculture', 'Clothing' => 'Clothing', 'Furnitures' => 'Furnitures'], 'Agriculture', ['class' => 'custom-select']) }}
        </div>
        
        <div class="form-group row">
            {{ Form::label('productMinOrder', 'Product Min Order') }}
            {{ Form::number('productMinOrder', '', ['class' => 'form-control']) }}
        </div>
        
        <div class="form-group row">
            {{ Form::label('productDescription', 'Product Description') }}
            {{ Form::textarea('productDescription', '', ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::file('image') }}
        </div>

        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}
@endsection