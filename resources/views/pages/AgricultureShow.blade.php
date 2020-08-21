@extends('layouts.app')

@section('content')
    <h2 id={{$product->id}}>{{$product->ProductName}}</h2>
    <hr>
    <div id="chart" class="container">
        <canvas id="productSDP" width="400" height="150"></canvas>
    </div>
    <br>
    <hr>
    <h2>INFO</h2>
    <img src="/../storage/app/public/images/{{$product->Image}}" style="width: 500px;">
    <div class="container">
        {!! $product->Info !!}
    </div>
    <br>

@endsection

@section('chart')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':$("meta[name='csrf-token']").attr('content')
            }
        });

        $.ajax({

            url: "getchartdata",
            method: 'POST',
            data: {id:$('h2').attr('id')},
            success: function(result){
                var label = result[0];
                var supply = result[1];
                var demand = result[2];
                var price = result[3];

                var ctx = document.getElementById('productSDP').getContext('2d');
                var myChart = new Chart(ctx, {

                    type: 'line',
                    data: {
                        labels: label,
                        datasets: [
                            {
                                label: 'Supply',
                                data: supply,
                                backgroundColor: 'transparent',
                                borderColor: 'rgba(50,205,50)',
                                borderWidth: 1
                            },

                            {
                                label: 'Demand',
                                data: demand,
                                backgroundColor: 'transparent',
                                borderColor: 'rgba(139,0,0)',
                                borderWidth: 1
                            },

                            {
                                label: 'Price',
                                data: price,
                                backgroundColor: 'transparent',
                                borderColor: 'rgba(189,183,107)',
                                borderWidth: 1
                            }
                        ]
                    },

                    options: {
                        sclaes:{
                            scales:{
                                yAxes: [{beginAtZero: false}],
                                xAxes: [{autoskip: true, maxTicketsLimit: 20}]
                            }
                        },

                        tooltips: {
                            mode: 'index'
                        },

                        legend: {
                            display:true,
                            position: 'top',
                            labels: {
                                fontColor: 'rgba(0,0,0)',
                                fontSize: 16
                            }
                        }
                    }
                });

            }

        });

    </script>
@endsection
