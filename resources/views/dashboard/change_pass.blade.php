@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid mt--7">
        <div class="row justify-content-center">
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Change Password</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('add.new.pass')}}" method="post">
                            @csrf
                            <div class="pl-lg-4">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-old-password">Current password <span class="text-danger">*</span></label>
                                            <input
                                                type="password"
                                                id="input-old-password"
                                                name="old_password"
                                                class="form-control @if($errors->has('old_password')) is-invalid @else form-control-alternative @endif"
                                                placeholder="Old password"
                                            >
                                            @if($errors->has('old_password'))
                                                <div class="invalid-feedback">
                                                    {{$errors->first('old_password')}}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-new-password">New password <span class="text-danger">*</span></label>
                                            <input
                                                type="password"
                                                id="input-new-password"
                                                name="password"
                                                class="form-control @if($errors->has('password')) is-invalid @else form-control-alternative @endif"
                                                placeholder="New password">
                                            @if($errors->has('password'))
                                                <div class="invalid-feedback">
                                                    {{$errors->first('password')}}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class="form-control-label" for="confirm-new-password">Confirm new password <span class="text-danger">*</span></label>
                                            <input type="password" id="confirm-new-password" name="password_confirmation" class="form-control form-control-alternative" placeholder="Confirm new password">
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                       <div class="form-group text-center">
                                           <button type="submit" class="btn btn-warning my-4">Change</button>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="footer">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-xl-6">

                </div>

            </div>
        </footer>
    </div>
@endsection
