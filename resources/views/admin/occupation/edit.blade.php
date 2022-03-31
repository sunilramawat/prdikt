@extends('admin.layout.app')
@section('content')


 <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Category </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <div class="box-main-table">
                    <div class="container-fluid">
                      <form method="POST" action="{{ route('occupation.update') }}" 
	  					enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                        	<input type="hidden" name="id" value="{{ $occuption->occuption_id }}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="lableClass">Name</label>
                                    <input type="text" class="form-control" placeholder="Enter occuption name" name="occuptionName" id="occuptionName" value="{{ $occuption->occuption_name }}">
                                </div>
                                <div class="col-lg-6">
                                    <label class="lableClass">Image</label>
                                    <input type="file" class="form-control" name="occuptionImage" id="occuptionImage">
                                    <br>
                                    <img src="{{ URL('public/images/occupation') }}/{{ $occuption->occuption_image }}" alt="" height="100px">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">        
                            <div class="row col-lg-12">
                                <label class="lableClass">Description</label> &nbsp;<span><small> (optional)</small></span>
                                <textarea class="form-control" name="occuptionDesc"
                                placeholder="Category Description" id="occuptionDesc">{{ $occuption->occuption_description}}</textarea>
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




@endsection