<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = "sub_categories";
    protected $primaryKey = "sub_category_id";
    protected $fillable = [
    
        'sub_category_category_id',
        'sub_category_name',
        'sub_category_image',
    ];

    protected $dates = ['deleted_at'];

    public function findSubCategoryByCategoryId($Id){

        return SubCategory::where('sub_category_category_id',$Id)->get();
    }
}
