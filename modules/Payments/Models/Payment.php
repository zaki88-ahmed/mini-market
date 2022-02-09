<?php

namespace modules\Payments\Models;

use App\Http\Controllers\Api\Modules\Orders\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"status","type","code"},
 * @OA\Xml(name="OrderProduct"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="status", type="boolean", readOnly="true", description=""),
 * @OA\Property(property="type", type="string", readOnly="true", description=""),
 * @OA\Property(property="code", type="string", readOnly="true", description=""),
 * )
 */


class Payment extends Model
{
    use HasFactory;
    protected $fillable = ["type","code","status"];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
