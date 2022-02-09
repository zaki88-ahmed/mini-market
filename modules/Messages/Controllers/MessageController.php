<?php
namespace modules\Messages\Controllers;


use App\Http\Traits\ApiDesignTrait;
use Illuminate\Support\Facades\Request;
use modules\BaseController;
use modules\Messages\Interfaces\MessageInterface;
use modules\Messages\Models\Message;

class MessageController extends BaseController
{
    use ApiDesignTrait;


    private $messageInterface;

    public function __construct(MessageInterface $messageInterface)
    {
        $this->messageInterface = $messageInterface;
    }



    public function index(){
//        return('ss');
        return $this->messageInterface->index();
    }


    public function show(Message $message){
        return $this->messageInterface->show($message);
    }




    public function response(Message $message, Request $request){
        return $this->messageInterface->response($message, $request);
    }




}
?>
