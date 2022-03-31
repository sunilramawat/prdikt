<?php

namespace App\Http\Controllers\Admin\SubCategory;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Http\Controllers\Controller;
use App\Http\Utility\commonHelper;

class SubCategoryController extends Controller
{
    
    public function index(){

       $subCategoryList = SubCategory::leftjoin('categories','categories.category_id',
            'sub_categories.sub_category_category_id')->get(); 

      
       return view('admin.subcategory.view',compact('subCategoryList'));
    }

    public function create(){

        $categoryList = Category::get();
        return view('admin.subcategory.add',compact('categoryList')); 
    }

    public function store(Request $request){

        $path = 'subcategory';
        $commonHelper = new commonHelper;
        $saveImage= $commonHelper->imageUpload($request->subCategoryImage,$path); 

        //save Category
        $category = new SubCategory;
        $category->sub_category_name = $request->subCategoryName;
        $category->sub_category_category_id = $request->categoryId;
        $category->sub_category_image = $saveImage;
        $category->sub_category_description = $request->subCategoryDesc;
        $category->save();


        return redirect('/subcategory')->with('success','Sub Category Added successfully.');

    }


    public function edit(Request $request){

        $subCategory = SubCategory::where('sub_category_id',$request->id)->first(); 
        $categoryList = Category::get();
        return view('admin.subcategory.edit',compact('subCategory','categoryList'));
    }

    public function update(Request $request)
    {
        $path = 'subcategory';
        $commonHelper = new commonHelper;

        if(!empty($request->subcategoryImage)){

            $saveImage= $commonHelper->imageUpload($request->subcategoryImage,$path); 
        }else{

            $saveImage= NULL;
        }


        $category = SubCategory::where('sub_category_id',$request->id)->first();
        $category->sub_category_name = $request->subcategoryName;
        $category->sub_category_category_id = $request->categoryId;
        isset($saveImage) ? $category->sub_category_image = $saveImage : '';
        $category->sub_category_description = $request->subcategoryDesc;
        $category->save();


        return redirect('/subcategory')->with('success','SubCategory Edited successfully.');

    }


    public function delete(Request $request)
    {
        $category = SubCategory::where('sub_category_id',$request->id)->first();
        $category->deleted_at = date('Y-m-d H:i:s');
        $category->save();
        return redirect('/subcategory')->with('error','Sub Category Deleted successfully');
    }


    public function detail(Request $request){

        $category = SubCategory::leftjoin('categories','categories.category_id',
            'sub_categories.sub_category_category_id')
            ->where('sub_categories.sub_category_id',$request->id)
            ->first();
        return view('admin.subcategory.detail',compact('category'));
    }

    public function search(Request $request){

      if($request->ajax()){

        $keyword = $request->keyword;

        if(empty($keyword)){
        
         $subCategoryList = SubCategory::leftjoin('categories','categories.category_id','sub_categories.sub_category_category_id')->get();   
       
        }else{

          $subCategoryList = SubCategory::leftjoin('categories','categories.category_id','sub_categories.sub_category_category_id')
          ->where(function ($query) use ($keyword) {
              $query->where('sub_category_name','like', "%".$keyword ."%");
          })->get();  
        }
         
          
        return view('admin.subcategory.search',compact('subCategoryList'));
      }
  
    }
}
