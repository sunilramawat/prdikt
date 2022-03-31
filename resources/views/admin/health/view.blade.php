@extends('admin.layout.app')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage HealthActivity </h1>
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
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Created on</th>
                                    <!-- <th>Status</th -->
                                    <!-- <th>Action</th> -->
                                        
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($healthList as $no => $user)
                                    <tr>
                                        <td> {{ $no+1 }}</td>
                                        <td> {{ $user->email }}</td>
                                        <td> {{ $user->health_activities_start_date}}</td>
                                        <td> {{ $user->health_activities_end_date }} </td>
                                        <td> {{ date('d-M-Y',strtotime($user->created_at)) }}</td>
                                        <!-- <td> 
                                            @if($user->status == 0)
                                                <a onClick="ChangeStatus({{$user->  health_activities_id}}, 1)" style="cursor:pointer">
                                                    <button class="btn btn-success btn-sm">
                                                      Active
                                                    </button>
                                                </a>    
                                            @else
                                                <a onClick="ChangeStatus({{$user->  health_activities_id}}, 0)" style="cursor:pointer">

                                                   <button class="btn btn-danger btn-sm">
                                                    Block
                                                    </button>
                                                </a>    
                                            @endif()  
                                        </td> -->
                                        
                                        <!-- <td>
                                            <a href="{{ route('users.detail',$user->    health_activities_id) }}"><i class="fa fa-eye " aria-hidden="true"></i></a>
                                            &nbsp;
                                            <a href="{{ route('users.edit',$user->  health_activities_id) }}"><i class="fa fa-edit"  aria-hidden="true"></i></a>
                                            &nbsp;
                                            <a href="{{ route('users.delete',$user->    health_activities_id) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>    -->

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
