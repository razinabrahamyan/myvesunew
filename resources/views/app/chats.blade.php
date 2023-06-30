@extends('app.layouts.app')

@section('title')
    <h5>Messages</h5>
@endsection

@section('content')
    <div class="container pt-2">
        @foreach($chats as $chat)
            @if($chat->lastMessage)
                <a @if($chat->opponent->id === auth()->user()->id) href="{{route('app.chat',$chat->user->id)}} @else href="{{route('app.chat',$chat->opponent->id)}} @endif">
                    <div class="container-fluid  px -3 pb-0 py-2 notification_item mt-3 animate__animated chat_item">
                        <div class="row">
                            @if($chat->opponent->id === auth()->user()->id)

                                <img class="ml-2"  src="{{asset('uploads/avatar/'.$chat->user->avatar)}}" alt="">
                                <div class="pl-2 chat_name_div" >
                                    <p class="chat_user_name">{{$chat->user->first_name.' '.$chat->user->last_name}}</p>
                                    @if($chat->lastMessage->writer->id === auth()->user()->id)
                                        <p class="seen_message">you: {{str_limit($chat->lastMessage->message, $limit = 25, $end = ' ...')}}</p>
                                    @else
                                        <p @if($chat->lastMessage->seen === '0') class="unseen_message" @else class="seen_message" @endif>{{$chat->lastMessage->writer->first_name.': '}}{{str_limit($chat->lastMessage->message, $limit = 25, $end = ' ...')}}</p>
                                    @endif
                                </div>
                            @else
                                <img class="ml-2" src="{{asset('uploads/avatar/'.$chat->opponent->avatar)}}" alt="">
                                <div class="pl-2 chat_name_div">
                                    <p  class="chat_user_name">{{$chat->opponent->first_name.' '.$chat->opponent->last_name}}</p>
                                    @if($chat->lastMessage->writer->id === auth()->user()->id)
                                        <p class="seen_message">you: {{str_limit($chat->lastMessage->message, $limit = 25, $end = ' ...')}}</p>
                                    @else
                                        <p @if($chat->lastMessage->seen === '0') class="unseen_message" @else  class="seen_message" @endif>{{$chat->lastMessage->writer->first_name.': '}}{{str_limit($chat->lastMessage->message, $limit = 25, $end = ' ...')}}</p>
                                    @endif
                                </div>

                            @endif

                        </div>
                    </div>
                </a>
            @endif

        @endforeach



    </div>
@endsection
