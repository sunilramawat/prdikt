@extends('admin.layout.app')
@section('content')


 <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Sub-Occupation </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <div class="box-main-table">
                    <div class="container-fluid">
                        <form method="POST" action="{{ route('suboccupation.update') }}" 
                        enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                
                                <input type="hidden" name="id" value="{{ $subOccupation->sub_occuption_id }}">
                                    
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="lableClass">Name</label>
                                        <input type="text" class="form-control" placeholder="Enter sub-occupation name" name="subOccupationName" id="subOccupationName"
                                        value="{{ $subOccupation->sub_occuption_name }}">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="label">Image</label>
                                        <input type="file" class="form-control" name="subOccupationImage" id="subOccupationImage">

                                         <img src="{{ URL('public/images/suboccupation') }}/{{ $subOccupation->sub_occuption_image }}" alt="" height="100px" width="100px">
                                    </div>


                                </div>
                            </div>
                            <div class="form-group">
                                <label class="lableClass">Select Parent Occupation</label>
                                <select name="occupationId" class="form-control" id="occupationId">
                                    <option value="">Select Occupation</option>
                                    @foreach($occupationList as $occupation)
                                        <option @if($occupation->occuption_id == $subOccupation->sub_occuption_occuption_id) selected @endif
                                        value="{{ $occupation->occuption_id }}">
                                            {{ $occupation->occuption_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>  
                            <div class="form-group">        
                                <div class="row col-lg-12">
                                    <label class="lableClass">Description</label> <span><small> (optional)</small></span>
                                    <textarea class="form-control" name="subOccupationDesc"
                                    placeholder="Sub occupation Description" id="subOccupationDesc">{{ $subOccupation->sub_occuption_description }}</textarea>
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