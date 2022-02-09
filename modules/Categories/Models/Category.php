<?php

namespace modules\Categories\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use modules\Products\Models\Product;

/**
 *
 * @OA\Schema(
 * required={"name"},
 * @OA\Xml(name="Category"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", readOnly="true",  description="Category unique name ", example="Clothes"),
 * @OA\Property(property="parent_id", type="integer", readOnly="true",  description="Category parent name ", example="0"),
 * )
 */

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'parent_id'];
    protected $hidden = ['deleted_at'];


    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

}


