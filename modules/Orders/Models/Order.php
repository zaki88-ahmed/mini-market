<?php

namespace modules\Orders\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use modules\Customers\Models\Customer;
use modules\OrderProduct\Models\OrderProduct;
use modules\Payments\Models\Payment;
use modules\Products\Models\Product;
use modules\Users\Models\User;




class Order extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['status', 'shipping', 'total', 'customer_id', 'payment_id'];
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }


    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

//    public function products()
//    {
//        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
//            ->withTimestamps();
//    }

    public function products() {
        return $this->belongsToMany(Product::class,'order_product')
            ->withPivot([
            'quantity'
        ]);
    }


}
