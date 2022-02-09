<?php


namespace modules\Payments\Controllers;

use App\Http\Traits\ApiDesignTrait;
use App\Http\Traits\ApiResponseTrait;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\{
    Hash, Validator
};
use modules\BaseController;
use modules\Payments\Interfaces\PaymentInterface;


class PaymentController extends BaseController
{
    use ApiDesignTrait;

    private $PaymentInterface;

    public function __construct(PaymentInterface $PaymentInterface)
    {
        $this->PaymentInterface = $PaymentInterface;
    }


    public function create(){

        return $this->PaymentInterface->create();
    }
}
?>
