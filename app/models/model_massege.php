<?php

class model_massege extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_massage($POST){

        $sql = "SELECT * FROM users WHERE username=?";
        $params = array($POST['username']);
        $result = $this->doSelect($sql, $params);

        $sql2 = "SELECT * FROM massege WHERE (sendid=? and getid=?) or  (sendid=? and getid=?) order by id desc"  ;
        $params2 = array($_SESSION['id'] , $result[0]['id'] ,$result[0]['id']  ,$_SESSION['id'] );
        $result2 = $this->doSelect($sql2, $params2);


        // $sql2 = "SELECT * FROM massege WHERE sendid=? and getid=?" ;
        // $params2 = array($_SESSION['id'] , $result[0]['id']);
        // $result2 = $this->doSelect($sql2, $params2);

        // $sql3 = "SELECT * FROM massege WHERE sendid=? and getid=?";
        // $params3 = array($result[0]['id'] , $_SESSION['id']);
        // $result3 = $this->doSelect($sql3, $params3);


        // $merg =array_merge($result2,$result3);
        // // $merg =sort($merg);


            echo json_encode(array(
                "data" => $result2,
                "status_code" =>  "109"
            ));
    }
    function massege(){

        $sql = "SELECT * FROM users WHERE username=?";
        $params = array($_POST['getid']);
        $result = $this->doSelect($sql, $params);

        $sql2 = "INSERT INTO massege (sendid , getid , text ,datesend ) VALUES (?,?,?,?)";
        $params2 = array($_SESSION['id'],$result[0]['id'],$_POST['massege'],time());
        $result2=$this->doQuery($sql2, $params2);

        echo json_encode(array(
            "data" => 'ok',
            "status_code" =>  "110"
        ));



    }





}




?>