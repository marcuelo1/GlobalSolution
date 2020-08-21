
    <div style="width: 50%">
        {!! Form::open(['action' => 'SDPController@Agriculture', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

            <div class="form-group row">
                {{ Form::label('productName', 'Product Name') }}
                {{ Form::select('productName', $products, '', ['class' => 'custom-select']) }}
            </div>
            
            <hr>

            <h2>Add Data for Year {{date('Y')}}</h2>
            
            <div class="form-group row">
                {{ Form::label('supply', 'Product Supply') }}
                {{ Form::number('supply', '', ['class' => 'form-control']) }}
            </div>
            
            <div class="form-group row">
                {{ Form::label('demand', 'Product Demand') }}
                {{ Form::number('demand', '', ['class' => 'form-control']) }}
            </div>
            
            <div class="form-group row">
                {{ Form::label('price', 'Product Price') }}
                {{ Form::number('price', '', ['class' => 'form-control']) }}
            </div>

            <div class="form-group row">
                {{ Form::label('info', 'Product Name') }}
                {{ Form::textarea('info', '', ['class' => 'form-control', 'id' => 'summary-ckeditor'])}}
            </div>

            <div class="form-group">
                {{ Form::file('image') }}
            </div>

            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        {!! Form::close() !!}
    </div>
    
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'info' );
    </script>