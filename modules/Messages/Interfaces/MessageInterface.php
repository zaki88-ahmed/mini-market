<?php
namespace modules\Messages\Interfaces;

interface MessageInterface {

    public function index();
    public function show($message);
    public function response($message,$request);

}
