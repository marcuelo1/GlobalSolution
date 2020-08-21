@extends('layouts.adminTemplate')

@section('content')
    <h2> {{ strtoupper($category) }} </h2>
    <hr>
    <div class="container">
        {!! Form::open(['action' => 'SDPController@StoreProduct', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

        <div class="form-group">
            {{ Form::label('productName', 'Product Name') }}
            {{ Form::text('productName', '', ['class' => 'custom-select']) }}
        </div>

        <div class="form-group">
            {{ Form::label('info', 'Product Description') }}
            {{ Form::textarea('info', '', ['class' => 'form-control', 'id' => 'summary-ckeditor'])}}
        </div>

        <div class="form-group custom-file">
            {{ Form::label('image', 'Product Image', ['class' => 'custom-file-label']) }}
            {{ Form::file('image', ['class' => 'custom-file-input']) }}
        </div>

        <h4 style="margin-top: 20px;">Add Data for Year 2000</h4>
            
        <div class="form-group">
            {{ Form::label('supply', 'Product Supply') }}
            {{ Form::text('supply', '', ['class' => 'form-control']) }}
        </div>
        
        <div class="form-group">
            {{ Form::label('demand', 'Product Demand') }}
            {{ Form::text('demand', '', ['class' => 'form-control']) }}
        </div>
        
        <div class="form-group">
            {{ Form::label('price', 'Product Price') }}
            {{ Form::text('price', '', ['class' => 'form-control']) }}
        </div>

        {{ Form::text('category', $category, ['style' => 'display:none;']) }}
        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        {!! Form::close() !!}
    </div>

    <br>
@endsection

@section('javascripts')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'info' );
    </script>
@endsection