@extends('layouts.app')

@section('content')
    <div id="people" style="height: 30px;">
    <h3>{{$name}}</h3>
    </div>
    <hr>
    
    <div id="chatbox">
        <div id="messages"></div>
        <form>
            {{ csrf_field() }}
            <div class="input-group mb-3">
                <input type="hidden" id="owner" value="{{$user->id}},{{$user2}}">
                <input type="text" class="form-control" id="message" autocomplete="off" placeholder="Type message...">
                <input type="submit" class="btn btn-primary" value="Send">
            </div>
        </form>
    </div>
@endsection

@section('chart')
    <script>
        var from = null, start = 0;
        var str = $('#owner').val();
        var users = str.split(',');

        $(document).ready(function(){
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN':$("meta[name='csrf-token']").attr('content')
                }
            });

            load();

            $('form').submit(function(e){
                $.ajax({
                    url: "chatMessages",
                    method: 'POST',
                    data: {user1: users[0],
                            user2: users[1],
                            message: $('#message').val()},
                    success: function(result){
                    }
                });
                $('#message').val('');
                return false;
            });
        });

        function load(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN':$("meta[name='csrf-token']").attr('content')
                }
            });

            $.ajax({
                url: "retrieveMessages",
                method: 'POST',
                data: {user1: users[0],
                        user2: users[1],
                        start: start},
                success: function(result){
                    result.forEach(element => {
                        start = element.id;
                        $('#messages').append(renderMessage(element, users[0]));
                    });
                    
                    load();
                }
            });
        }

        function renderMessage(message, owner){
            if(message['From'] == owner){
                return `<div class="owner"><b>${message['message']}</b><br><div class="date">${message['created_at']}</div></div><br>`
            }else{
                return `<div class="opposite"><b>${message['message']}</b><br><div class="date">${message['created_at']}</div></div><br>`
            }
        }
    </script>
@endsection