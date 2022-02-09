<?php

namespace modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use modules\Orders\Models\Order;
use modules\Orders\Models\OrderProduct;


/**
 *models
 * @OA\Schema(
 *     required={"title","description","price","in_stock","price_after","vendor_id"},
 * @OA\Xml(name="Product"),
 *     @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="description", type="string", readOnly="true",description="Product description", example="Main Characteristics: ......"),
 *     @OA\Property(property="in_stock", type="integer", readOnly="true", example="111"),
 *     @OA\Property(property="price", type="double", readOnly="true", example="111.00"),
 *     @OA\Property(property="price_after", type="double", readOnly="true", example="111.05"),
 *     @OA\Property(property="has_offer", type="boolean", readOnly="true", example="false"),
 *     @OA\Property(property="vendor_id", type="integer", readOnly="true", example="1"),
 * )
 */

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ["title", "price"];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_product');
    }


}
