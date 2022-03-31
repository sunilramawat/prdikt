@extends('admin.layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Add Sub-Category </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <div class="box-main-table">
                    <div class="container-fluid">
                        <form method="POST" action="{{ route('subcategory.store') }}" 
                        enctype="multipart/form-data"id="subcategoryForm">
                        @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="lableClass">Name</label>
                                        <input type="text" class="form-control" placeholder="Enter sub-category name" name="subCategoryName" id="subCategoryName">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="label">Image</label>
                                        <input type="file" class="form-control" name="subCategoryImage" id="subCategoryImage">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="lableClass">Select Parent Category</label>
                                <select name="categoryId" class="form-control" id="categoryId">
                                    <option value="">Select Category</option>
                                    @foreach($categoryList as $category)
                                        <option value="{{ $category->category_id }}">
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>  
                            <div class="form-group">        
                                <div class="row col-lg-12">
                                    <label class="lableClass">Description</label> <span><small> (optional)</small></span>
                                    <textarea class="form-control" name="subCategoryDesc"
                                    placeholder="Sub Category Description" id="subCategoryDesc"></textarea>
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
        $("#subcategoryForm").validate({
            rules: {
                subCategoryName: {
                    required: true,
                },
                subCategoryImage: {
                    required: true,
                    extension: "jpeg,png,jpg"
                },
                categoryId: {
                    required: true,
                   
                },
              
            },
            messages: {
                subCategoryName: {
                    required: "Please enter subcategory name",
                },
                subCategoryImage: {
                    required: "Please enter subcategory image",
                },

                categoryId: {
                    required: "Please select parent category",
                },
               
            },
        })
    </script>

@stop
