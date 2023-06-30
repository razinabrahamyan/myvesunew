@extends('app.layouts.app')

@section('title')
    <h5>Chat</h5>
@endsection
@section('content')
    <div class="container-fluid pt-4 chat_container" id="chat_desc">
        @foreach($messages as $message)
            @if(Auth::user()->id === $message->writer_id)
                <div class="w-100">
                    <div class="w-100 p-1 d-flex justify-content-start">
                        <div class="message_item_div position-relative">
                            <div class="message_text">
                                <p>{{$message->message}}</p>
                            </div>
                            <div class="message_item_right">
                                <div class="position-relative message_image_div_right">
                                    <div class="online_status_div"></div>
                                    <img src="{{asset("uploads/avatar/".$message->writer->avatar)}}" alt="" class="chat_image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div><p class="ml-3 time_div">{{Carbon\Carbon::parse($message->created_at)->format("H:i")}}</p></div>
                </div>
            @else
                <div class="w-100">
                    <div class="w-100 p-1 d-flex justify-content-end">
                        <div class="message_item_div right_message">
                            <div class="position-relative message_image_div">
                                <div class="online_status_div"></div>
                                <img src="{{asset("uploads/avatar/".$message->writer->avatar)}}" alt="" class="chat_image">
                            </div>
                            <div class="float-right message_text">
                                <p>{{$message->message}}</p>
                            </div>
                        </div>
                    </div>
                    <div><p class="text-right mr-3 time_div">{{Carbon\Carbon::parse($message->created_at)->format("H:i")}}</p></div>
                </div>

            @endif
        @endforeach
    </div>
    <input type="hidden" value="{{$is_on_chat_page}}" id="is_on_chat_page">
    <input type="hidden" value="{{$user_id}}" id="user_id">
    <div class="chat_message_div">
        <textarea rows="2" id="chat_input" type="text" placeholder="type your message..."></textarea>
        <button class="chat_btn" id="chat_button" type="submit"><i class="fa fa-paper-plane"></i></button>
    </div>




    <script >
        $(document).ready(function () {
            console.log('fucking shit')
            let socket = io(':8443');
            function scrollBottom(){
                $('html ,body').animate({scrollTop:$(document).height()-$(window).height()});
            }
            function makeDate(date){
                let hour = date.getHours();
                if(hour < 10){
                    hour = '0'+hour;
                }
                let minutes = date.getMinutes();
                if(minutes < 10){
                    minutes = '0'+minutes;
                }
                return hour+':'+minutes;
            }

            function opponentMessage(message){
                return ('<div class="w-100">\n' +
                    '                    <div class="w-100 p-1 d-flex justify-content-end">\n' +
                    '                        <div class="message_item_div right_message">\n' +
                    '                            <div class="position-relative message_image_div">\n' +
                    '                                <div class="online_status_div"></div>\n' +
                    '                                <img src="/uploads/avatar/'+ message["writer"]["avatar"] +'" alt="" class="chat_image">\n' +
                    '                            </div>\n' +
                    '                            <div class="float-right message_text">\n' +
                    '                                <p>'+ message["message"] +'</p>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>\n'+
                    '                    <div><p class="text-right mr-3 time_div">' + makeDate(new Date(message["created_at"]))+ '</p></div>\n' +
                    '                </div>');
            }

            function ownMessage(message){
                return ('<div class="w-100">\n' +
                    '                    <div class="w-100 p-1 d-flex justify-content-start">\n' +
                    '                        <div class="message_item_div position-relative">\n' +
                    '                            <div class="message_text">\n' +
                    '                                <p>'+ message["message"] +'</p>\n' +
                    '                            </div>\n' +
                    '                            <div class="message_item_right">\n' +
                    '                                <div class="position-relative message_image_div_right">\n' +
                    '                                    <div class="online_status_div"></div>\n' +
                    '                                    <img src="{{asset("uploads/avatar/".Auth::user()->avatar)}}" alt="" class="chat_image">\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                    <div><p class="ml-3 time_div">'+ makeDate(new Date(message["created_at"])) +' </p></div>\n' +
                    '                </div>')
            }
            let chat_input = $('#chat_input');
            let wrote_messages = 0;
            let bring = false;
            let user_id = $('#user_id').val();
            let desc = $('#chat_desc');
            let iteration = 1;
            let chat_name = '{{$chat_name}}';
            let chat_id = parseInt('{{$chat_id}}');
            setTimeout(function () {
                $('.footer').slideUp(600);
                $('.chat_message_div').css('display','flex');
                $('.chat_message_div').css('z-index','1');
            },1000);
            $('html, body').fadeIn(function () {
                $('html ,body').animate({scrollTop:$(document).height()-$(window).height()},function(){bring = true;});
            });
            $(window).scroll(function () {
                if($(document).scrollTop() === 0 && bring){
                    let waiting = $('<div class="text-center"><img width="25px" src="{{asset("assets/img/brand/chat_spin.gif")}}" alt=""></div>');
                    desc.prepend(waiting);
                    $.ajax({
                        url:'/app/messages/'+user_id +'/'+iteration +'/'+ wrote_messages,
                        type:'GET',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response['success'] === 'success'){
                                let messages = response['messages'];
                                if(messages.length){
                                    desc.prepend('<div id="position_'+ iteration +'"></div>');
                                    for(let i = 0;i < messages.length;i++){
                                        let message = messages[i];
                                        if(message['writer_id'] === parseInt(user_id)){
                                            let message_item = opponentMessage(message);
                                            desc.prepend(message_item);
                                        }
                                        else{
                                            let message_item = ownMessage(message);
                                            desc.prepend(message_item);
                                        }
                                    }
                                    let posit =
                                    location.href = '#position_'+iteration;
                                    $('html').scrollTop($('html').scrollTop()-137);
                                }
                                else{
                                    desc.prepend('<div class="col-12 text-center">\n' +
                                        '                <div class="alert p-0">\n' +
                                        '                    No more messages\n' +
                                        '                </div>\n' +
                                        '            </div>');
                                    bring = false;
                                }
                                waiting.remove();
                                iteration++;
                            }
                        }
                    });

                }
            });
            socket.on(chat_name, function (message) {
                let new_message = '';
                if(message['message']['writer_id'] === parseInt(user_id)){
                    new_message = opponentMessage(message['message'])
                    $.ajax({
                        url:"{{route('app.seen.message')}}",
                        type:'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {user_id:message['message']['writer_id']}
                    });

                }
                else{
                    new_message = ownMessage(message["message"]);
                    chat_input.val('');
                }
                desc.append(new_message);
                scrollBottom();
                wrote_messages++;
            });
            $('#chat_button').click(function () {
                if (chat_input.val()){
                    let message = chat_input.val();
                    $.ajax({
                        url:"{{route('app.add.message')}}",
                        type:'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {writer_id:"{{Auth::user()->id}}",getter_id:user_id,message:message ,chat_id:chat_id},
                        success: function (response) {
                            if (response['success'] === 'success'){
                                socket.emit('chat.message', response,chat_name);
                            }
                        }
                    });
                }
            });


        })
    </script>
@endsection

