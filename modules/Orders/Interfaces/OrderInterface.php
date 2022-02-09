<?php
namespace modules\Orders\Interfaces;


interface OrderInterface {

    public function allOrders();
    public function createOrder($request);
    public function orderDetails($request);
    public function updateOrder($request);

    public function softDeleteOrder($request);
    public function restoreOrder($request);


    public function setItemCart($request);
    public function getItemCart($request);



}
