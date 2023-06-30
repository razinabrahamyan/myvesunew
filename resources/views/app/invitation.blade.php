@extends('app.layouts.app')

@section('title')
    <h5>INVITATIONS</h5>
@endsection

@section('content')
    <div class="container invitation_items">
        @forelse($passengers as $passenger)
            @if($passenger->id != auth()->user()->id)
                <div class="container-fluid invitation_item pt-2 pb-2 mt-2">
                    <div class="row">
                        <div class="col-3 p-0 text-center align-self-center">
                            <img src="{{asset('uploads/avatar/'.$passenger->avatar)}}" alt="">
                        </div>
                        <div class="col-6 align-self-center px-0">
                           <p class="invitation_name">{{$passenger->first_name}} {{$passenger->last_name}}</p>
                            @if($passenger->passenger()->first())
                           <p>{{$passenger->passenger()->first()->company_name}}</p>
                            @endif
                        </div>
                        <div class="col-3 align-self-center pl-0">
                            <button class="btn btn-default  invitation_button" type="button"
                                    data-inviter="{{auth()->user()->id}}"
                                    {{$passenger->invitation()->where('ride_id', $ride->id)->first() && $passenger->invitation()->where('ride_id', $ride->id)->first()->invited == '1' ? "disabled" : ""}}
                                    data-user_id="{{$passenger->id}}" data-ride_id="{{$ride->id}}">
                                {{$passenger->invitation()->where('ride_id', $ride->id)->first() && $passenger->invitation()->where('ride_id', $ride->id)->first()->invited == '1' ? "Invited" : "Invite"}}
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="col-12 text-center">
                <div class="alert">
                    Available Passengers not found!
                </div>
            </div>
        @endforelse
    </div>

    <script>
        $(document).ready(function () {
            $('.invitation_button').click(function () {
               var invited_button = $(this);

                $.ajax({
                    url: '{{route('app.invite')}}',
                    type: "POST",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:{user_id: $(this).data("user_id"), ride_id: $(this).data("ride_id"), inviter: $(this).data("inviter")},
                    success: function (response) {
                        console.log(response)
                        let alert;
                        let alert_timeout;
                        if(response.status && response.status === "success"){
                            alert = $(".vesu_alert_success");
                            alert.css("display", "block");
                            alert.addClass("animate__fadeInDownBig");
                            alert.html(response.message);
                            invited_button.html('Invited');
                            invited_button.prop('disabled', true);
                        }else{
                            alert = $(".vesu_alert_danger");
                            alert.css("display", "block");
                            alert.addClass("animate__fadeInDownBig");
                            alert.html(response.message)
                        }
                        alert_timeout = setTimeout(function () {
                            alert.hide(400);
                        },2000)
                    }
                });

            })
        })
    </script>

@endsection
