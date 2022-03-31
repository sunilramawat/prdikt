@extends('admin.layout.app')
@section('content')


 <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Users </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <div class="box-main-table">
                    <div class="container-fluid">
                      <form method="POST" action="{{ route('users.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="col-lg-6">
                                <label class="label">Name</label>
                                <input type="text" class="form-control" placeholder="Enter User Name" name="userName"  value="{{ $user->name }}">
                            </div>
                            
                            <div class="col-lg-6">
                                <label class="label">Phone</label>
                                <input type="text" class="form-control" name="userPhone"
                                value="{{ $user->phone }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">

                            <div class="col-lg-6">
                                <label class="label">Email</label>
                                <input type="email" class="form-control" placeholder="Enter Email Address" name="userEmail"  value="{{ $user->email }}">
                            </div>
                            <div class="col-lg-6">
                                <label class="label">Image</label>
                                <input type="file" class="form-control" name="userImage">
                                <br>
                            
                                <img src="{{ URL('public/images/users') }}/{{ $user->image }}" alt="" height="100px" width="100px">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>

                </form>   
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>	




@endsection