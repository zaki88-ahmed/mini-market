<?php

namespace modules\Payments\Repositories;

use App\Http\Interfaces\AuthInterface;
use App\Http\Traits\ApiDesignTrait;

use App\Models\Payment;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use modules\Payments\Interfaces\PaymentInterface;

class PaymentRepository implements PaymentInterface
{

    use ApiDesignTrait;



    public function __construct()
    {

    }


    public function create()
    {
        // TODO: Implement login() method.

    }
}
