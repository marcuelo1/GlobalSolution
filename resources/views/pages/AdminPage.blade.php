@extends('layouts.adminTemplate')

@section('content')

    {{-- Add Product --}}
    <h3>Select Category to Add Product</h3>
    {{-- Categories --}}
    <div class="list-group">
        <a href="/../public/AdminPage/agricultures" class="list-group-item list-group-item-action active">
            Agriculture
        </a>
    </div>

    <hr>

    {{-- Add Supply Demand Price (SDP) Data to Product --}}
    <h3>Select Category to Add SDP Data to Product</h3>
    {{-- Categories --}}
    <div class="list-group">
        <a href="/../public/AdminPage/addSDP/agricultures" class="list-group-item list-group-item-action active">
            Agriculture
        </a>
    </div>

    <hr>
    
    <h3>Add Admin Account</h3>
    {!! Form::open(['action' => 'SDPController@AddAcc', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        
        <div class="form-group">
            {{ Form::label('Name', 'Name') }}
            {{ Form::text('Name', '', ['class' => 'form-control']) }}
        </div>
        
        <div class="form-group">
            {{ Form::label('Password', 'Password') }}
            {{ Form::password('Password', ['class' => 'form-control']) }}
        </div>
        
        <div class="form-group">
            {{ Form::label('Email', 'Email') }}
            {{ Form::email('Email', '', ['class' => 'form-control']) }}
        </div>
        
        <div class="form-group">
            {{ Form::label('Location', 'Location') }}
            {{ Form::text('Location', '', ['class' => 'form-control']) }}
        </div>

    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}
    <br>
@endsection

    