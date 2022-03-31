@extends('admin.layout.app')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage Sub-Occupation </h1>
                </div><!-- /.col --> 
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <div class="box-main-top">
                    <div class="box-main-title">Sub-Occupation List</div>
                    <div class="box-main-top-right">
                        <div class="box-serch-field">
                            <input type="text" class="box-serch-input" id="search" name="search" placeholder="Search" onkeyup="doSearch()" >
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </div>
                        <a href="{{ route('suboccupation.create') }}"><button class="btn btn-primary">Add</button></a>
                    </div>
                </div>
                <div class="box-main-table">
                    <div class="table-responsive">

                        <table id="example2" class="table table-bordered admin-table">
                            <thead >
                                <tr>
                                    <th>Sno</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Parent occupation</th>
                                    <th>Created on</th>
                                    <th>Action</th>
                                        
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subOccupationList as $no => $occupation)
                                    <tr>
                                        <td> {{ $no+1 }}</td>
                                        <td> {{ $occupation->sub_occuption_name }}</td>
                                        <td> 
                                            <img src="{{ URL('public/images/suboccupation') }}/{{ $occupation->sub_occuption_image }}" alt="" height="30px" width="30px">


                                        </td>
                                        <td>
                                            {{ $occupation->occuption_name}}
                                        </td>

                                        <td> {{ date('d-M-Y',strtotime($occupation->created_at)) }}</td>


                                        <td>
                                            <a href="{{ route('suboccupation.detail',$occupation->sub_occuption_id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            &nbsp;
                                            <a href="{{ route('suboccupation.edit',$occupation->sub_occuption_id) }}"><i class="fa fa-edit"  aria-hidden="true"></i></a>
                                            &nbsp;
                                            <a href="{{ route('suboccupation.delete',$occupation->sub_occuption_id) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>   

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
                url: "{{ route('suboccupation.search') }}",
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
    </script>
@stop
