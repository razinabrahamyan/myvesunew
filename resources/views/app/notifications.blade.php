@extends('app.layouts.app')

@section('title')
    <h5>NOTIFICATIONS</h5>
@endsection

@section('content')
    <div class="container pt-2">
        @forelse($notifications as $notification)
            <div class="container-fluid  px -3 pb-0 pt-3 notification_item mt-3 animate__animated ">
                @if($notification->type !== 'message') <p>{{$notification->content->body}}</p> @endif
                @if($notification->type === 'checkout')

                    <a class="btn btn-default" href="{{$notification->content->redirect_url}}">
                        checkout
                    </a>
                @elseif($notification->type === 'join_attempt')
                    <a class="btn btn-default"
                       href="{{route('app.join.approve',
                        ['ride_id'=>$notification->content->ride_id,'user_id'=>$notification->content->user_id,
                        'answer'=>'approve',
                        'notification_id'=>$notification->id])}}"
                    >
                        approve
                    </a>
                    <a class="btn btn-default"
                       href="{{route('app.join.approve',['ride_id'=>$notification->content->ride_id,'user_id'=>$notification->content->user_id,'answer'=>'cancel','notification_id'=>$notification->id])}}">
                        cancel
                    </a>

                @elseif($notification->type === 'join_approve')
                    <a class="btn btn-default"
                       href="{{route('app.join.passenger',['ride_id'=>$notification->content->ride_id,'notification_id'=>$notification->id,'type'=>'approved'])}}">
                        view
                    </a>
                @elseif($notification->type === 'join_cancel')
                    <a class="btn btn-default"
                       href="{{route('app.join.passenger',['ride_id'=>'1','notification_id'=>$notification->id,'type'=>'canceled'])}}">
                        ok
                    </a>
                @elseif($notification->type === 'invitation')
                    <a class="btn btn-default" href="{{route('app.ride',$notification->content->ride_id)}}">
                        see
                    </a>

                @elseif($notification->type === 'message')
                    <p>{{$notification->content->title}}</p>
                    <p class="notification_message">{{str_limit($notification->content->body, $limit = 60, $end = ' ...')}}</p>
                    <a class="btn btn-default" href="{{route('app.chat',$notification->content->writer_id)}}">
                        answer
                    </a>
                @endif


                <span>{{Carbon\Carbon::parse($notification->created_at)->format("h:i:A")}}</span>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="alert">
                    No notifications!
                </div>
            </div>

        @endforelse
    </div>
@endsection
