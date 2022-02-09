<?php


namespace modules\Orders\Controllers;

use App\Http\Traits\ApiDesignTrait;
use App\Http\Traits\ApiResponseTrait;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\{
    Hash, Validator
};
use modules\BaseController;
use modules\Orders\Interfaces\OrderInterface;
use modules\Orders\Models\Order;
use modules\Orders\Requests\OrderFormRequest;


class OrderController extends BaseController
{
    use ApiDesignTrait;

    private $orderInterface;

    public function __construct(OrderInterface $OrderInterface)
    {
        $this->orderInterface = $OrderInterface;
    }


    public function createOrder(OrderFormRequest $request){
//        $this->authorize('store', Order::class);
//        dd($request->all());
        return $this->orderInterface->createOrder($request);
    }

    public function allOrders(){
//        $this->authorize('allOrders', Order::class);
        return $this->orderInterface->allOrders();
//        return('sss');
    }


    public function orderDetails(OrderFormRequest $request){
//        $this->authorize('OrderDetails', Order::class);
        return $this->orderInterface->orderDetails($request);
    }


    public function updateOrder(OrderFormRequest $request){
//        $this->authorize('updateOrder', Order::class);
        return $this->orderInterface->updateOrder($request);
    }



    public function softDeleteOrder(OrderFormRequest $request){
//        $this->authorize('softDeleteOrder', Order::class);
        return $this->orderInterface->softDeleteOrder($request);
    }


    public function restoreOrder(OrderFormRequest $request){
//        $this->authorize('restoreOrder', Order::class);
        return $this->orderInterface->restoreOrder($request);
    }

    public function setItemCart(Request $request){
        return $this->orderInterface->setItemCart($request);
    }

    public function getItemCart(Request $request){
        return $this->orderInterface->getItemCart($request);
    }

}
?>
