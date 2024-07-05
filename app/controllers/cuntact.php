<?php

class cuntact extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function check_data()
    {
        $this->model->check_data($_POST);
    }

    function cuntact_data()
    {
        $this->model->cuntact_data();
    }

    function edit_check()
    {
        $this->model->edit_check($_POST);
    }
    function name()
    {
        $this->model->name($_POST);
    }
    function update()
    {
        $this->model->update($_POST);
    }
    function get_message()
    {
        $this->model->get_message($_POST);
    }
    function delet()
    {
        $this->model->delet($_POST);
    }
    function delete_acunt()
    {
        $this->model->delete_acunt($_POST);
    }
}
