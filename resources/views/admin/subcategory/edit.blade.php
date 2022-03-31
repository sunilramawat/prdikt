@extends('admin.layout.app')
@section('content')


 <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Sub-Category </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <div class="box-main-table">
                    <div class="container-fluid">
                        <form method="POST" action="{{ route('subcategory.update') }}" 
                        enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="row">

                                    <input type="hidden" name="id" value="{{ $subCategory->sub_category_id }}">
                                    <div class="col-lg-6">
                                        <label class="label">Name</label>
                                        <input type="text" class="form-control" placeholder="Enter category name" name="subcategoryName" id="categoryName" value="{{ $subCategory->sub_category_name }}">
                                    </div>
                                    <div class="col-lg-6">
                                       <label class="label">Select Parent Category</label>
                                        <select name="categoryId" class="form-control" id="categoryId">
                                            <option value="">Select Category</option>
                                            @foreach($categoryList as $category)
                                                <option @if($category->category_id == $subCategory->sub_category_category_id) selected @endif value="{{ $category->category_id }}">
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">

                                 <label class="label">Image</label>
                                <input type="file" class="form-control" 
                                name="subcategoryImage" id="categoryImage">
                                <br>
                            
                                <img src="{{ URL('public/images/subcategory') }}/{{ $subCategory->sub_category_image }}" alt="" height="100px" width="100px">

                                
                            </div>
                            <div class="form-group">        
                                <div class="row col-lg-12">
                                    <label class="label">Description</label> <span><small> (optional)</small></span>
                                    <textarea class="form-control" name="subcategoryDesc"
                                    placeholder="Category Description" id="categoryDesc">{{ $subCategory->sub_category_description}}</textarea>
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