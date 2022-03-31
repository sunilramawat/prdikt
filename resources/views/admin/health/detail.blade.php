@extends('admin.layout.app')
@section('content')

 <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage User </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <div class="box-main-top">
                    <div class="box-main-title">User Details </div>
                   
                </div>
                <div class="box-main-table">
                    <div class="text-center">
             			<div class="profile-img">
	       					<img src="{{ URL('public/images/users') }}/{{ $users->image }}" alt=""
	       					 style="height:100px;width: 100px;">
      					</div>
      					<br>
	  					<div>
	  						<label class="lableClass">{{ $users->name }}</label>
	  					</div>

                        <div class="row">
                            <div class="col-sm-12">
                                <b class="lableClass">Email</b> : {{ $users->email }}
                            </div>
                        </div>  
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <b class="lableClass">Phone</b> : {{ $users->phone }}
                            </div>
                        </div>  
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <b class="lableClass">Status</b> : {{ $users->status == '0' ? 'Active' : 'Blocked'  }}
                            </div>
                        </div>  
                    </div>
                		

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>



@endsection