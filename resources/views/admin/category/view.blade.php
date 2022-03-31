@extends('admin.layout.app')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage Categories </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <div class="box-main-top">
                    <div class="box-main-title">Categories List</div>
                    <div class="box-main-top-right">
                        <div class="box-serch-field">
                            <input type="text" class="box-serch-input" id="search" name="search" placeholder="Search" onkeyup="doSearch()" >
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </div>
                        <a href="{{ route('category.create') }}"><button class="btn btn-primary">Add</button></a>
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
                                    <th>Created on</th>
                                    <th>Action</th>
                                        
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categoryList as $no => $category)
                                    <tr>
                                        <td> {{ $no+1 }}</td>
                                        <td> {{ $category->category_name }}</td>
                                        <td> 
                                            <div  class="profile-img"> 
                                                <img src="{{ URL('public/images/category') }}/{{ $category->category_image }}" alt="" height="30px" width="30px">
                                            </div>

                                        </td>
                                        <td> {{ date('d-M-Y',strtotime($category->created_at)) }}</td>
                                        <td>
                                            <a href="{{ route('category.detail',$category->category_id) }}"><i class="fa fa-eye " aria-hidden="true"></i></a>
                                            &nbsp;
                                            <a href="{{ route('category.edit',$category->category_id) }}"><i class="fa fa-edit"  aria-hidden="true"></i></a>
                                            &nbsp;
                                            <a href="{{ route('category.delete',$category->category_id) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                url: "{{ route('category.search') }}",
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
