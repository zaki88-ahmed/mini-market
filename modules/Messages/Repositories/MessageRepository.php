<?php

namespace modules\Messages\Repositories;

use App\Http\Traits\ApiDesignTrait;
use App\Mail\ContactResponseMail;
use Illuminate\Support\Facades\Mail;
use modules\Messages\Interfaces\MessageInterface;
use modules\Messages\Models\Message;

class MessageRepository implements MessageInterface
{

    use ApiDesignTrait;
    public function index(){

        $messages = Message::orderBy('id', 'DESC')->paginate(10);

        return $this->ApiResponse(200, 'all messages', null, $messages);
    }



    public function show($message){


        return $this->ApiResponse(200, 'all messages', null, $message);
    }



    public function response($message, $request){

        $request->validate([

            'title' => 'required|string|max:255',
            'body' => 'required|string',

        ]);

        $receiverName = $message->name;
        $receiverMail = $message->email;

        Mail::to($receiverMail)->send(
            new ContactResponseMail($receiverName, $request->title, $request->body)
        );

        return $this->ApiResponse(200, 'mail sent', null, $message);
    }
}
