<?php

class model_register extends model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert_data($post)
    {
        $sql = "SELECT * FROM users WHERE username=?";
        $params = array($post['username']);
        $result = $this->doSelect($sql, $params);

        if (sizeof($result) == 0) {
            if($post['password']!=$post['confirm_password']){
                echo "error";
            } else {
                $sql = "INSERT INTO users (name,username,password,register_date) VALUES (?,?,?,?)";
                $params = array($post['name'],$post['username'], md5($post['password']), self::jalali_date("Y/m/d"));
                $this->doQuery($sql, $params);

                echo "ok";

                header("Location:" . URL);
            }
        } else {
            echo "error";
        }
    }
    
    function check_username($post)
    {
        $sql = "SELECT * FROM users WHERE username=?";
        $params = array($post['username']);
        $result = $this->doSelect($sql, $params);

        if (sizeof($result) == 0) {
            return true;
        } else {
           return false;
        }
    }


}