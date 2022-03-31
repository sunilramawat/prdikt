@extends('admin.layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Add Category </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <div class="box-main-table">
                    <div class="container-fluid">
                        <form method="POST" action="{{ route('category.store') }}" 
                        enctype="multipart/form-data"id="categoryForm">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="lableClass">Name</label>
                                    <input type="text" class="form-control" placeholder="Enter category name" name="categoryName" id="categoryName">
                                </div>
                                <div class="col-lg-6">
                                    <label class="lableClass">Image</label>
                                    <input type="file" class="form-control" name="categoryImage" id="categoryImage">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">        
                            <div class="row col-lg-12">
                                <label class="lableClass">Description</label> &nbsp;<span><small> (optional)</small></span>
                                <textarea class="form-control" name="categoryDesc"
                                placeholder="Category Description" id="categoryDesc"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary " type="submit">Save</button>
                        </div>

                    </form>     
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <script type="text/javascript">
        $("#categoryForm").validate({
            rules: {
            categoryName: {
                required: true,
            },
            categoryImage: {
                required: true,
            },
          
        },
        messages: {
            categoryName: {
                required: "Please enter category name",
            },
            categoryImage: {
                required: "Please enter category image",
            },
           
        },
        })
    </script>

@stop
