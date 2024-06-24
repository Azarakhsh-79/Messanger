<?php

class register extends  Controller
{
    public $checkLogin = '';

    function __construct()
    {
        parent::__construct();
        $this->checkLogin = Model::session_get("username");
        if ($this->checkLogin != FALSE) {
            header("Location:".URL);
        
    }
}

    function index()
    {
        $this->view('register/index');
    }

    function insert_data()
    {
        // session_start();
        // $rand =rand(10000,99999);
        // $_SESSION['rand']= $rand;
        // $link = "https://localhost/Farawin-Messanger/?rand=$rand";
        $this->model->insert_data($_POST);
    }

    function check_username()
    {
        $this->model->check_username($_POST);
    }



}