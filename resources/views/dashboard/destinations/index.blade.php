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
                            <th scope="col">Address</th>
                            <th scope="col">Created</th>
                            <th scope="col">Updated</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($destinations as $destination)
                            <tr>
                                <td>{{$destination->address}}</td>
                                <td>{{$destination->created_at}}</td>
                                <td>{{$destination->updated_at}}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v set_btn "></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow set_menu">
                                            <a style="color: #ffc107" class="dropdown-item" href="{{route('destination.edit',$destination->id)}}">Edit <i class="ni ni-settings float-right"></i></a>
                                            <form class="delete" action="{{route('destination.delete',$destination->id)}}" method="POST" onsubmit="return confirm('Are you sure?')">
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

                    </nav>
                </div>
            </div>
        </div>
    </div>

@endsection
