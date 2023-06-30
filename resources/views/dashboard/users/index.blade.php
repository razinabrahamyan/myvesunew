@extends('dashboard.layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0 flash">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0">Users</h3>
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
                            <th scope="col">Username</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th scope="row" style="">
                                    <div class="media align-items-center">
                                        <a href="{{route('administrator.edit',$user->id)}}" class="user_avatar rounded-circle mr-3">
                                            <img alt="Image placeholder" src="/uploads/avatar/{{$user->avatar}}">
                                        </a>
                                        <div class="media-body">
                                            <span class="mb-0 text-sm">{{$user->username}}</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    {{$user->first_name}}
                                </td>
                                <td>
                                    {{$user->last_name}}
                                </td>
                                <td>
                                    {{$user->email}}
                                </td>
                                <td>
                                    @if($user->blocked == 1)
                                        <span class="badge badge-dot mr-4">
                                            <i class="bg-warning"></i> Blocked
                                        </span>
                                    @else
                                        <span class="badge badge-dot mr-4">
                                            <i class="bg-success"></i> Active
                                        </span>
                                    @endif
                                </td>
                                <td class="text-left">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v set_btn "></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow set_menu">
                                            <a style="color: #8F5EE8" class="dropdown-item" href="{{route('user.view', $user->id)}}">View <i class="fa fa-eye float-right" aria-hidden="true"></i></a>
                                            <a style="color: #ffc107" class="dropdown-item" href="{{route('user.edit',$user->id)}}">Edit <i class="ni ni-settings float-right"></i></a>
                                            <form class="delete" action="{{route('user.delete', $user->id)}}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                        {{ $users->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

@endsection
