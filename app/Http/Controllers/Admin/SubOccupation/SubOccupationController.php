<?php

namespace App\Http\Controllers\Admin\SubOccupation;

use Illuminate\Http\Request;
use App\Models\Occuption;
use App\Models\SubOccupation;
use App\Http\Controllers\Controller;
use App\Http\Utility\commonHelper;

class SubOccupationController extends Controller
{
    
    public function index(){

       $subOccupationList = SubOccupation::leftjoin('occuption','occuption.occuption_id','sub_occuption.sub_occuption_occuption_id')->get(); 

      
       return view('admin.suboccupation.view',compact('subOccupationList'));
    }

    public function create(){

        $occupationList = Occuption::get();
        return view('admin.suboccupation.add',compact('occupationList')); 
    }

    public function store(Request $request){

        $path = 'suboccupation';
        $commonHelper = new commonHelper;
        $saveImage= $commonHelper->imageUpload($request->subOccupationImage,$path); 

        //save Category
        $subOccupation = new SubOccupation;
        $subOccupation->sub_occuption_name = $request->subOccupationName;
        $subOccupation->sub_occuption_occuption_id = $request->occupationId;
        $subOccupation->sub_occuption_image = $saveImage;
        $subOccupation->sub_occuption_description = $request->subOccupationDesc;
        $subOccupation->save();


        return redirect('/suboccupation')->with('success','Sub Category Added successfully.');

    }


    public function edit(Request $request){

        $subOccupation = SubOccupation::where('sub_occuption_id',$request->id)->first(); 
        $occupationList = Occuption::get();
        return view('admin.suboccupation.edit',compact('subOccupation','occupationList'));
    }

    public function update(Request $request)
    {
        $path = 'suboccupation';
        $commonHelper = new commonHelper;

        if(!empty($request->subcategoryImage)){

            $saveImage= $commonHelper->imageUpload($request->subcategoryImage,$path); 
        }else{

            $saveImage= NULL;
        }


        $subOccupation = SubOccupation::where('sub_occuption_id',$request->id)->first(); 
        $subOccupation->sub_occuption_name = $request->subOccupationName;
        $subOccupation->sub_occuption_occuption_id = $request->occupationId;
        isset($saveImage) ? $subOccupation->sub_occuption_image = $saveImage : '';
        $subOccupation->sub_occuption_description = $request->subOccupationDesc;
        $subOccupation->save();


        return redirect('/suboccupation')->with('success','SubCategory Edited successfully.');

    }


    public function delete(Request $request)
    {
        $subOccupation = SubOccupation::where('sub_occuption_id',$request->id)->first(); 
        $subOccupation->deleted_at = date('Y-m-d H:i:s');
        $subOccupation->save();
        return redirect('/suboccupation')->with('error','Sub Category Deleted successfully');
    }


    public function detail(Request $request){

        $subOccupationList = SubOccupation::leftjoin('occuption','occuption.occuption_id','sub_occuption.sub_occuption_id') 
            ->where('sub_occuption.sub_occuption_id',$request->id)
            ->first();
        return view('admin.suboccupation.detail',compact('subOccupationList'));
    }

    public function search(Request $request){

      if($request->ajax()){

        $keyword = $request->keyword;

        if(empty($keyword)){
        
          $subOccupationList = SubOccupation::leftjoin('occuption','occuption.occuption_id','sub_occuption.sub_occuption_id')->get();   
       
        }else{

          $subOccupationList = SubOccupation::leftjoin('occuption','occuption.occuption_id','sub_occuption.sub_occuption_id') 
          ->where(function ($query) use ($keyword) {
              $query->where('sub_occuption_name','like', "%".$keyword ."%");
          })->get();  
        }
         
          
        return view('admin.suboccupation.search',compact('subOccupationList'));
      }
  
    }
}
