@extends('layouts.app')

@section('content')
    <h2 style="text-align: center;">TOP 3 PRODUCTS WITH THE HIGHEST DEMAND</h2>
    <div id="top3" style="display: none;">{{$top1}},{{$top2}},{{$top3}}</div>
    <div id="chart"><canvas id="myChart" width="400" height="150"></canvas></div>
    <hr>
    <h2>PRODUCTS</h2>
    <label for="myInput">Search Product</label>
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for products.." title="Type in a name">
    <ul id="myUL" class="list-group list-group-flush">
        @foreach ($products as $product)
            <li class="list-group-item"><a href="/../public/agriculture/{{ $product->id }}">{{ $product->ProductName }}</a></li>
        @endforeach
    </ul>
    <br>
@endsection

@section('chart')
    <script>
        function myFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':$("meta[name='csrf-token']").attr('content')
            }
        });

        var tops = $('#top3').text().split(',');
        console.log(tops);

        $.ajax({

            url: "gettopchartdata",
            method: 'POST',
            data: {top1: tops[0],
                    top2: tops[1],
                    top3: tops[2]},
            success: function(result){
                console.log(result);
                var label = result[0], top1 = result[1], top2 = result[2], top3 = result[3], top1name = result[4], top2name = result[5], top3name = result[6];

                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {

                    type: 'line',
                    data: {
                        labels: label,
                        datasets: [
                            {
                                label: 'Top 1: ' + top1name,
                                data: top1,
                                backgroundColor: 'transparent',
                                borderColor: 'rgba(50,205,50)',
                                borderWidth: 1
                            },

                            {
                                label: 'Top 2: ' + top2name,
                                data: top2,
                                backgroundColor: 'transparent',
                                borderColor: 'rgba(139,0,0)',
                                borderWidth: 1
                            },

                            {
                                label: 'Top 3: ' + top3name,
                                data: top3,
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