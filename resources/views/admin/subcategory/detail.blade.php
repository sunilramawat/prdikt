@extends('admin.layout.app')
@section('content')

 <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage  Sub-Categories </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <div class="box-main-top">
                    <div class="box-main-title">Sub-Categories Details </div>
                   
                </div>
                <div class="box-main-table">
                    <div class="text-center">
             			<div class="profile-img">
	       					<img src="{{ URL('public/images/subcategory') }}/{{ $category->sub_category_image }}" alt=""
	       					 style="height:100px;width: 100px;">
      					</div>
      					<br>
	  					<div>
	  						<label class="lableClass">{{ $category->sub_category_name }}</label>
	  					</div>
                    </div>
                    <div>
                        <label class="lableClass">Parent Category : </label> &nbsp;{{ $category->category_name }}
                    </div>  
                	<div>
  						<label class="lableClass">Description : </label><br>{{ $category->sub_category_description }}
  					</div>	

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>



@endsection