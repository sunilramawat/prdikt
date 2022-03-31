@extends('admin.layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Add Occupation </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <div class="box-main-table">
                    <div class="container-fluid">
                        <form method="POST" action="{{ route('occupation.store') }}" 
                        enctype="multipart/form-data" id="occuptionForm">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="lableClass">Name</label>
                                    <input type="text" class="form-control" placeholder="Enter occupation name" name="occuptionName" id="occuptionName">
                                </div>
                                <div class="col-lg-6">
                                    <label class="lableClass">Image</label>
                                    <input type="file" class="form-control" name="occuptionImage" id="occuptionImage">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">        
                            <div class="row col-lg-12">
                                <label class="lableClass">Description</label> &nbsp;<span><small> (optional)</small></span>
                                <textarea class="form-control" name="occuptionDesc"
                                placeholder="occupation Description" id="occuptionDesc"></textarea>
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
        $("#occuptionForm").validate({
            rules: {
                occuptionName: {
                    required: true,
                },
                occuptionImage: {
                    required: true,
                },
                occuptionDesc: {
                    required: true,
                },
          
            },
            messages: {
                occuptionName: {
                    required: "Please enter occupation name",
                },
                occuptionImage: {
                    required: "Please enter occupation image",
                },

                occuptionDesc: {
                    required: "Please enter occupation description",
                },
               
            },
        })
    </script>

@stop
