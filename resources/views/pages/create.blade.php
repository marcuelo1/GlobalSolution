@extends('layouts.app')

@section('content')
    {!! Form::open(['action' => 'ProductsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

        <div class="form-group row">
            {{ Form::label('productName', 'Product Name') }}
            {{ Form::text('productName', '', ['class' => 'form-control']) }}
        </div>
        
        <div class="form-group row">
            <div class="col">
                {{ Form::label('productPrice', 'Product Price')}}
                {{ Form::number('productPrice', '', ['class' => 'form-control']) }}
            </div>

            <div class="col">
                {{ Form::label('productPriceUnit', 'Price Per')}}
                {{ Form::select('productPriceUnit', ['m(meter)' => 'm(meter)',
                                                    'mm(millimeter)' => 'mm(millimeter)',
                                                    'cm(centimeter)' => 'cm(centimeter)',
                                                    'dm(decimeter)' => 'dm(decimeter)',
                                                    'in(inch)' => 'in(inch)',
                                                    'ft(foot)' => 'ft(foot)',
                                                    'yf(yard)' => 'yd(yard)',
                                                    'sqm(square meter)' => 'sqm(square meter)',
                                                    'ft2(square foot)' => 'ft2(square foot)',
                                                    'm3(cubic meter)' => 'm3(cubic meter)',
                                                    'l(liter)' => 'l(liter)',
                                                    'ml(mililiter)' => 'ml(mililiter)',
                                                    'in3(cubic inch)' => 'in3(cubic inch)',
                                                    'ft3(cubic foot)' => 'ft3(cubic foot)',
                                                    'cup' => 'cup',
                                                    'gal(gallon)' => 'gal(gallon)',
                                                    'g(grams)' => 'g(grams)',
                                                    'kg(kilograms)' => 'kg(kilograms)',
                                                    'lb(pound)' => 'lb(pound)',
                                                    ], 'm(meter)', ['class' => 'custom-select']) }}
            </div>
        </div>
        
        <div class="form-group row">
            {{ Form::label('productCategory', 'Product Category') }}
            {{ Form::select('productCategory', ['Agriculture' => 'Agriculture', 'Clothing' => 'Clothing', 'Furnitures' => 'Furnitures'], 'Agriculture', ['class' => 'custom-select']) }}
        </div>
        
        <div class="form-group row">
            <div class="col">
                {{ Form::label('productMinOrder', 'Product Min Order') }}
                {{ Form::number('productMinOrder', '', ['class' => 'form-control']) }}
            </div>

            <div class="col">
                {{ Form::label('productMinOrderUnit', 'Unit')}}
                {{ Form::select('productMinOrderUnit', ['m(meter)' => 'm(meter)',
                                                    'mm(millimeter)' => 'mm(millimeter)',
                                                    'cm(centimeter)' => 'cm(centimeter)',
                                                    'dm(decimeter)' => 'dm(decimeter)',
                                                    'in(inch)' => 'in(inch)',
                                                    'ft(foot)' => 'ft(foot)',
                                                    'yf(yard)' => 'yd(yard)',
                                                    'sqm(square meter)' => 'sqm(square meter)',
                                                    'ft2(square foot)' => 'ft2(square foot)',
                                                    'm3(cubic meter)' => 'm3(cubic meter)',
                                                    'l(liter)' => 'l(liter)',
                                                    'ml(mililiter)' => 'ml(mililiter)',
                                                    'in3(cubic inch)' => 'in3(cubic inch)',
                                                    'ft3(cubic foot)' => 'ft3(cubic foot)',
                                                    'cup' => 'cup',
                                                    'gal(gallon)' => 'gal(gallon)',
                                                    'g(grams)' => 'g(grams)',
                                                    'kg(kilograms)' => 'kg(kilograms)',
                                                    'lb(pound)' => 'lb(pound)',
                                                    ], 'm(meter)', ['class' => 'custom-select']) }}

            </div>
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