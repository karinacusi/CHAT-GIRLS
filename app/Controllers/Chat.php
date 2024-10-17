<?php

namespace App\Controllers;

class Chat extends BaseController {

    public function index(){
        //Cargar la vista del chat
        return view('chat_view');
    }
}