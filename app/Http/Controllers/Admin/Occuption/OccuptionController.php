<?php

namespace App\Http\Controllers\Admin\Occuption;

use Illuminate\Http\Request;
use App\Models\Occuption;
use App\Http\Controllers\Controller;
use App\Http\Utility\commonHelper;

class OccuptionController extends Controller
{
    
    public function index(){

       $occuptionList = Occuption::get(); 
       return view('admin.occupation.view',compact('occuptionList'));
    }

    public function create(){
        return view('admin.occupation.add'); 
    }

    public function store(Request $request){

       // dd($request->all());
        $path = 'occupation';
        $commonHelper = new commonHelper;
        $saveImage= $commonHelper->imageUpload($request->occuptionImage,$path); 

        //save Category
        $occuption = new Occuption;
        $occuption->occuption_name = $request->occuptionName;
        $occuption->occuption_image = $saveImage;
        $occuption->occuption_description = $request->occuptionDesc;
        $occuption->save();


        return redirect('/occupation')->with('success','Category Added successfully.');

    }


    public function edit(Request $request){

        $occuption = Occuption::where('occuption_id',$request->id)->first(); 
        return view('admin.occupation.edit',compact('occuption'));
    }

    public function update(Request $request)
    {
        $path = 'occupation';
        $commonHelper = new commonHelper;
        
        if(!empty($request->occuptionImage)){

            $saveImage= $commonHelper->imageUpload($request->occuptionImage,$path); 
        }else{

            $saveImage= NULL;
        }

        //save Category
        $occuption = Occuption::where('occuption_id',$request->id)->first();
        $occuption->occuption_name = $request->occuptionName;
        isset($saveImage) ? $occuption->occuption_image = $saveImage : '';
        $occuption->occuption_description = $request->occuptionDesc;
        $occuption->save();


        return redirect('/occupation')->with('success','Category Edited successfully.');

    }


    public function delete(Request $request)
    {
        $occuption = Occuption::where('occuption_id',$request->id)->first();
        $occuption->deleted_at = date('Y-m-d H:i:s');
        $occuption->save();
        return redirect('/occupation')->with('error','Category Deleted successfully');
    }


    public function detail(Request $request){

        $occuption = Occuption::where('occuption_id',$request->id)->first();
        return view('admin.occupation.detail',compact('occuption'));
    }

    public function search(Request $request){

      if($request->ajax()){

        $keyword = $request->keyword;

        if(empty($keyword)){
        
          $occuptionList = Occuption::get(); 
       
        }else{

          $occuptionList = Occuption::where(function ($query) use ($keyword) {
              $query->where('occuption_name','like', "%".$keyword ."%");
          })->get();  
        }
         
          
        return view('admin.occupation.search',compact('occuptionList'));
      }
  
    }
}
