<?php

class model_massege extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_message($username){

        $sql = "SELECT * FROM users WHERE username=?";
        $params = array($username);
        $result = $this->doSelect($sql, $params);

        $sql2 = "SELECT * FROM massege WHERE sendid=? , getid=?";
        $params2 = array($_SESSION['id'] , $result[0]['id']);
        $result2 = $this->doSelect($sql2, $params2);

            echo json_encode(array(
                "data" => $result2,
                "status_code" =>  "109"
            ));
    }
    function massege(){

        $sql = "SELECT * FROM users WHERE username=?";
        $params = array($_POST['getid']);
        $result = $this->doSelect($sql, $params);

        $sql2 = "INSERT INTO massege (sendid , getid , text  ) VALUES (?,?,?)";
        $params2 = array($_SESSION['id'],$result[0]['id'],$_POST['massege']);
        $result2=$this->doQuery($sql2, $params2);

        echo json_encode(array(
            "data" => 'ok',
            "status_code" =>  "110"
        ));



    }





}




?>