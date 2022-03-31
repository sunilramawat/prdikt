@extends('admin.layout.app')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage Users </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <?php /*<div class="box-main-top">
                    <!-- <div class="box-main-title">Users List</div> -->
                    <div class="box-main-top-right">
                        <div class="box-serch-field">
                           <!--  <input type="text" class="box-serch-input" id="search" name="search" placeholder="Search">
                            <i class="fa fa-search" aria-hidden="true"></i> -->
                        </div>
                        <!-- <a href="{{ route('category.create') }}"><button class="btn btn-primary">Add</button></a> -->
                    </div>
                </div>*/?>
                <div class="box-main-table">
                    <div class="table-responsive">

                        <table id="example2" class="table table-bordered admin-table">
                            <thead >
                               <tr>
                                    <th>Sno</th>
                                    
                                    <th>Email</th>
                                    <th>Activity Link</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Created on</th>
                                        
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($usersList as $no => $user)
                                    <tr>
                                        <td> {{ $no+1 }}</td>
                                       
                                        <td> {{ $user->email }} </td>
                                       
                                        <td>
                                            <!-- <a href="{{route('health.useractivity',$user->id)}}" style="cursor:pointer">
                                            <button class="btn btn-success btn-sm">
                                                      Activity
                                            </button>
                                            </a>
                                             --><a href="{{route('log.userlog',$user->id)}}" style="cursor:pointer">
                                            <button class="btn btn-success btn-sm">
                                                      Request Serverd
                                            </button>
                                            </a>
                                        </td>
                                        <td> 
                                            @if($user->status == 0)
                                                <a onClick="ChangeStatus({{$user->id}}, 1)" style="cursor:pointer">
                                                    <button class="btn btn-success btn-sm">
                                                      Active
                                                    </button>
                                                </a>    
                                            @else
                                                <a onClick="ChangeStatus({{$user->id}}, 0)" style="cursor:pointer">

                                                   <button class="btn btn-danger btn-sm">
                                                    Block
                                                    </button>
                                                </a>    
                                            @endif()  
                                        </td>
                                         
                                        
                                        <td>
                                            <a href="{{ route('users.detail',$user->id) }}"><i class="fa fa-eye " aria-hidden="true"></i></a>
                                            
                                            &nbsp;
                                            <a href="{{ route('users.delete',$user->id) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>   
                                        <td> {{ date('d-M-Y',strtotime($user->created_at)) }}</td>

                                    </tr>
                                 @empty
                                    <tr class="text-center">
                                        <td colspan="6">No record found </td>
                                    </tr>
                                @endforelse 
                                
                            </tbody>
                        </table>
                      
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <script type="text/javascript">

        function doSearch(){
            var query=$("#search").val();
            $.ajax({
                url: "{{ route('users.search') }}",
                type: 'GET',
                data: {
                    keyword:query,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('tbody').html(data);
                }
            });
        }

        function ChangeStatus(Id, Status)
        {

            $("#LoadingProgress").fadeIn('fast');
            
            $.ajax({
                url: "{{ URL('/users/change-status') }}/"+Id+"/"+Status,
                type: "GET",
                contentType: false,
                cache: false,
                processData:false,
                success: function( data, textStatus, jqXHR ) {
                    window.location.reload();
                    $("#LoadingProgress").fadeOut('fast');
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                
                }
            });
        }


    </script>
@stop
