@extends('dashboard.layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header  border-0 flash">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0">Rides</h3>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    @if (session('success'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger text-center" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Ride #</th>
                            <th scope="col">Date \ Time</th>
                            <th scope="col">Pick up</th>
                            <th scope="col">Destination</th>
                            <th scope="col">Price</th>
                            <th scope="col">Baby seat</th>
                            <th scope="col">Suitcase</th>
                            <th scope="col">Passengers \<br> Available</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rides as $ride)
                            <tr>
                                <td>
                                    <div class="media align-items-center">
                                        <a href="{{route('ride.view',$ride->id)}}" class="user_avatar rounded-circle mr-3">
                                            <img alt="Image placeholder" src="/uploads/rides/{{$ride->image}}" height="60px">
                                        </a>
                                        <div class="media-body">
                                            # {{$ride->id}}
                                        </div>
                                    </div>
                                </td>
                                <td>{{Carbon\Carbon::parse($ride->date)->format('d-m-Y')}} <br> {{$ride->time}}</td>
                                <td>{{$ride->pick_up}}</td>
                                <td>{{$ride->destination}}</td>
                                <td>{{$ride->price}}</td>
                                <td>
                                    @if($ride->baby_seat == 1)
                                        yes
                                    @else
                                        no
                                    @endif
                                </td>
                                <td>{{$ride->suitcase}}</td>
                                <td>{{$ride->passengers}} \ {{$ride->count}}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v set_btn "></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow set_menu">
                                            <a style="color: #8F5EE8" class="dropdown-item" href="{{route('ride.view', $ride->id)}}">View <i class="fa fa-eye float-right" aria-hidden="true"></i></a>
                                            <a style="color: #ffc107" class="dropdown-item" href="{{route('ride.edit', $ride)}}">Edit <i class="ni ni-settings float-right"></i></a>
                                            <form class="delete" action="{{route('ride.delete', $ride->id)}}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                <input type="hidden" name="_method" value="DELETE">
                                                @csrf
                                                <button type="submit" class="dropdown-item remove_btn">
                                                    Delete<i class="ni ni-fat-remove float-right" style="font-size: 25px;margin-right: 11px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4 ">
                    <nav aria-label="..." class="pagination_nav">
                        {{ $rides->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

@endsection
