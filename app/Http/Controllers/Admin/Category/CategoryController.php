<?php

namespace App\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Utility\commonHelper;

class CategoryController extends Controller
{
    
    public function index(){

       $categoryList = Category::get(); 
       return view('admin.category.view',compact('categoryList'));
    }

    public function create(){
        return view('admin.category.add'); 
    }

    public function store(Request $request){

        $path = 'category';
        $commonHelper = new commonHelper;
        $saveImage= $commonHelper->imageUpload($request->categoryImage,$path); 

        //save Category
        $category = new Category;
        $category->category_name = $request->categoryName;
        $category->category_image = $saveImage;
        $category->category_description = $request->categoryDesc;
        $category->save();


        return redirect('/category')->with('success','Category Added successfully.');

    }


    public function edit(Request $request){

        $category = Category::where('category_id',$request->id)->first(); 
        return view('admin.category.edit',compact('category'));
    }

    public function update(Request $request)
    {
        $path = 'category';
        $commonHelper = new commonHelper;
        
        if(!empty($request->categoryImage)){

            $saveImage= $commonHelper->imageUpload($request->categoryImage,$path); 
        }else{

            $saveImage= NULL;
        }

        //save Category
        $category = Category::where('category_id',$request->id)->first();
        $category->category_name = $request->categoryName;
        isset($saveImage) ? $category->category_image = $saveImage : '';
        $category->category_description = $request->categoryDesc;
        $category->save();


        return redirect('/category')->with('success','Category Edited successfully.');

    }


    public function delete(Request $request)
    {
        $category = Category::where('category_id',$request->id)->first();
        $category->deleted_at = date('Y-m-d H:i:s');
        $category->save();
        return redirect('/category')->with('error','Category Deleted successfully');
    }


    public function detail(Request $request){

        $category = Category::where('category_id',$request->id)->first();
        return view('admin.category.detail',compact('category'));
    }

    public function search(Request $request){

      if($request->ajax()){

        $keyword = $request->keyword;

        if(empty($keyword)){
        
          $categoryList =   Category::get();
       
        }else{

          $categoryList = Category::where(function ($query) use ($keyword) {
              $query->where('category_name','like', "%".$keyword ."%");
          })->get();  
        }
         
          
        return view('admin.category.search',compact('categoryList'));
      }
  
    }
}
