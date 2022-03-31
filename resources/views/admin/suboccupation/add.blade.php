@extends('admin.layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Add Sub-Occupation </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <div class="box-main-table">
                    <div class="container-fluid">
                        <form method="POST" action="{{ route('suboccupation.store') }}" 
                        enctype="multipart/form-data"id="suboccuptionForm">
                        @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="lableClass">Name</label>
                                        <input type="text" class="form-control" placeholder="Enter sub-occupation name" name="subOccupationName" id="subOccupationName">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="label">Image</label>
                                        <input type="file" class="form-control" name="subOccupationImage" id="subOccupationImage">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="lableClass">Select Parent Occupation</label>
                                <select name="occupationId" class="form-control" id="occupationId">
                                    <option value="">Select Occupation</option>
                                    @foreach($occupationList as $occupation)
                                        <option value="{{ $occupation->occuption_id }}">
                                            {{ $occupation->occuption_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>  
                            <div class="form-group">        
                                <div class="row col-lg-12">
                                    <label class="lableClass">Description</label> <span><small> (optional)</small></span>
                                    <textarea class="form-control" name="subOccupationDesc"
                                    placeholder="Sub occupation Description" id="subOccupationDesc"></textarea>
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
    <script type="text/javascript">
        $("#suboccuptionForm").validate({
            rules: {
                subOccupationName: {
                    required: true,
                },
                subOccupationImage: {
                    required: true,
                    extension: "jpeg,png,jpg"
                },
                occupationId: {
                    required: true, 
                },

                subOccupationDesc: {
                    required: true, 
                },
              
            },
            messages: {
                subOccupationName: {
                    required: "Please enter suboccupation name",
                },
                subOccupationImage: {
                    required: "Please enter suboccupation image",
                },

                occupationId: {
                    required: "Please select parent occupation",
                },
               
                subOccupationDesc:{
                    required: "Please enter suboccupation description",
                }
            },
        })
    </script>

@stop
