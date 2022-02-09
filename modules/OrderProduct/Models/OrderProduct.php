<?php
//
//namespace modules\OrderProduct\Models;
//
//
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
//use modules\Customers\Models\Customer;
//use modules\Orders\Models\Order;
//use modules\Payments\Models\Payment;
//use modules\Products\Models\Product;
//use modules\Users\Models\User;
//
//
//
//
//class OrderProduct extends Model
//{
//    use HasFactory;
//
//    protected $table = 'order_product';
//    protected $fillable = ['order_id','product_id','price','quantity'];
//
//    protected $hidden = ['created_at','updated_at'];
//
//    public function order() {
//        return $this->belongsTo(Order::class,'order_id');
//    }
//    public function product() {
//        return $this->belongsTo(Product::class,'product_id');
//    }
////    public function ss() {
////        return 'ss';
////    }
//
//}
