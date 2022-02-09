<?php

namespace modules\Orders\Repositories;

use App\Http\Resources\OrderResource;
use App\Http\Traits\ApiDesignTrait;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use modules\OrderProduct\Models\OrderProduct;
use modules\Orders\Interfaces\OrderInterface;
use modules\Orders\Models\Order;

class OrderRepository implements OrderInterface
{

    use ApiDesignTrait;

    /**
     * @OA\Post(
     * path="/api/create/orders",
     * summary="new Order",
     * description="store new order",
     * operationId="store",
     * tags={"orders"},
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Store new product",
     *    @OA\JsonContent(
     *          required={"shipping", "total", "customer_id", "payment_id"},
     *               @OA\Property(property="shipping", type="integer", example = "5"),
     *               @OA\Property(property="total", type="double", example = "111.00"),
     *              @OA\Property(property="customer_id", type="integer", example = "1"),
     *              @OA\Property(property="payment_id", type="integer", example = "1"),
     *           ),
     *      ),
     *          @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         @OA\JsonContent(
     *              @OA\Property(property="orders", type="object", ref="order"),
     *          )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="invalid input",
     *    @OA\JsonContent(
     *       @OA\Property(property="error", type="string", example="order can't be created try later")
     *        )
     *     )
     * )
     *
     */



    public function createOrder($request)
    {
//        dd('aa');
        // TODO: Implement updateVendor() method.
//            dd($request->all());
//        $customer = auth('sanctum')->user();
//        $order = Order::create([
//            'status' => $request->status,
//            'shipping' => $request->shipping,
//            'total' => $request->total,
//            'customer_id' => $request->customer_id,
//            'payment_id' => $request->payment_id,
//        ]);
//        return $this->apiResponse(200, 'Order created successfully', null, $order);


        $customer_order = Order::where('customer_id', auth()->user()->id)->first();
//        dd($customer_order);
        $customer_id = auth()->user()->id;
//        dd(Redis::get('cart_'.$customer_id));
//        dd($customer_order);
//        dd($customer_id);
        $cart = Redis::get('cart_'.$customer_id);
//        dd('aa');
        $cart_items = json_decode($cart, true);
//        dd('cart_'.$customer_id);
//        dd($cart_items);
        $productDetails = [];
        foreach($cart_items as $itemDetail){
            $requestItem = explode(',', $itemDetail);
            $productDetails[] = $requestItem;
        }
//        dd('aa');
//        dd($productDetails);
//        dd($cart_items);

        $total = 0;
        for($i = 0; $i < count($productDetails); $i++){
            $total += $productDetails[$i][1] * $productDetails[$i][2];
        }
//        dd($total);

        if($customer_order->status == 0) {
//            dd('ss');
            $customer_order->delete();
        }
        return $this->createProductOrder($productDetails, $total, $request);
//        dd('aa');
//        dd('qq');
        // return $this->ApiResponse(200,"Your Have an Order Not Paid Yet",null,$user_order);
    }


    public function createProductOrder($productDetails, $totalPrice, Request $request){
//        dd('zz');
        $order = Order::create([
            'customer_id' =>auth()->user()->id,
            'total' => $totalPrice,
            'status' => 0,
            'shipping' => $request->shipping,
            'payment_id' => $request->payment_id,
        ]);
        for ($i = 0; $i<count($productDetails); $i++){
            $productOrder = DB::table('order_product')->insert([
                'order_id' =>$order->id,
                'product_id' => $productDetails[$i][0],
                'price' =>$productDetails[$i][1],
                'quantity' =>$productDetails[$i][2],
            ]);
        }
        return $this->ApiResponse(200,"Order Created",null,$order);

    }




    /**
     * @OA\Get(
     *      path="/api/orders",
     *      operationId="get all customers",
     *      tags={"orders"},
     *      summary="Get list of customers",
     *      description="Returns list of customers",
     *     security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="All customers",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */

    public function allOrders()
    {
        // TODO: Implement allVendors() method.
        $orders = Order::orderBy('id', 'DESC')->get();
        return $this->ApiResponse(200, 'All Orders', null, $orders);
    }


    /**
     * @OA\Get(
     *      path="/api/orders/show",
     *      operationId="show specific order",
     *      tags={"orders"},
     *      summary="show specific order",
     *      description="show specific order",
     *     security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass customer credentials",
     *          @OA\JsonContent(
     *              required={"order_id"},
     *              @OA\Property(property="order_id", type="integer", format="order_id", example="1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="orders",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *        @OA\Response(
     *          response=400,
     *          description="Validation Error"
     *      )
     *     )
     */

    public function orderDetails($request)
    {
        // TODO: Implement vendorDetails() method.
//        $customer = auth('sanctum')->user();
//        $orders = Order::find($request->order_id)->first();
//        return $this->ApiResponse(200, 'Customer details', null, $orders);

        $customer_order = Order::with(['products'])->where('customer_id', auth()->user()->id)->get();
        return $this->ApiResponse(200, 'Order Details', null, $customer_order);
    }

    /**
     * @OA\Post(
     *      path="/api/orders/edit",
     *      operationId="update customers",
     *      tags={"orders"},
     *      summary="orders",
     *      description="Edit order",
     *     security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass credentials",
     *          @OA\JsonContent(
     *              required={"shipping", "total", "customer_id", "payment_id"},

     *               @OA\Property(property="shipping", type="integer", example = "5"),
     *               @OA\Property(property="total", type="double", example = "111.00"),
     *              @OA\Property(property="customer_id", type="integer", example = "1"),
     *              @OA\Property(property="payment_id", type="integer", example = "1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Order update successfully",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *        @OA\Response(
     *          response=400,
     *          description="Validation Error"
     *      )
     *     )
     */

    public function updateOrder($request)
    {
        // TODO: Implement updateVendor() method.

//        $customer = auth('sanctum')->user();
//        $order = Order::find($request->order_id);
//        $order->update([
//            'order_id' => $request->order_id,
//            'status' => $request->status,
//            'shipping' => $request->shipping,
//            'total' => $request->total,
//            'customer_id' => auth()->user()->id,
//            'payment_id' => $request->payment_id,
//        ]);
//        return $this->apiResponse(200, 'Order updated successfully', null, $order);
    }

    /**
     * @OA\Post(
     *      path="/api/orders/delete",
     *      operationId="delete specific order",
     *      tags={"orders"},
     *      summary="Soft delete customer",
     *      description="Soft delete customer",
     *     security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass customer credentials",
     *          @OA\JsonContent(
     *              required={"order_id"},
     *              @OA\Property(property="order_id", type="integer", format="order_id", example="1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="order deleted successfully",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *        @OA\Response(
     *          response=400,
     *          description="Validation Error"
     *      )
     *     )
     */

    public function softDeleteOrder($request)
    {
        // TODO: Implement softDeleteVendor() method.
//        $order = Order::find($request->order_id);
//        if (is_null($order)) {
//            return $this->ApiResponse(400, 'No Order Found');
//        }
//        $order->delete();
//        return $this->apiResponse(200,'Order deleted successfully');
    }

    /**
     * @OA\Post(
     *      path="/api/orders/restore",
     *      operationId="restore specific order",
     *      tags={"orders"},
     *      summary="Restore delete order",
     *      description="restore order",
     *     security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass customer credentials",
     *          @OA\JsonContent(
     *              required={"order_id"},
     *              @OA\Property(property="order_id", type="integer", format="_id", example="1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="order restored successfully",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *        @OA\Response(
     *          response=400,
     *          description="Validation Error"
     *      )
     *     )
     */

    public function restoreOrder($request)
    {

        // TODO: Implement restoreVendor() method.
//        $order = Order::withTrashed()->find($request->order_id);
//
//        if (!is_null($order->deleted_at)) {
//            $order->restore();
//            return $this->ApiResponse(200,'order restored successfully');
//        }
//        return $this->ApiResponse(200,'order already restored');
    }


    public function setItemCart($request){
        $customer_id = auth()->user()->id;
        $redis = Redis::connection();
        $cart = $request->all();
        $cartData = $cart['item'];
        $cacheValue = $redis->set('cart_'.$customer_id,json_encode($cartData));
//        dd('cart_'.$customer_id);
//        Redis::del('cart_'.$customer_id);
        return $this->ApiResponse(200,'Data',Null,json_decode(Redis::get('cart_'.$customer_id)));
    }

    public function getItemCart($request){
        $customer_id = auth()->user()->id;
        $cartValue = Redis::get('cart_'.$customer_id);
//        dd($cartValue);
//        Redis::del($cartValue);
        return  $this->ApiResponse(200,'Cart Data',null,json_decode($cartValue));
    }




}
