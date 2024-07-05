<?php

use LDAP\Result;

class model_cuntact extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    function check_data($post)
    {
        
        if ($post['phone'] == $_SESSION['username']) {

            echo json_encode(
                array(
                    "msg" => "شماره خود را نمیتوان اضافه کرد",
                    "status_code" => "100"
                )
            );
        } else {

            $sql = "SELECT * FROM users WHERE username=? ";
            $params = array($post['phone']);
            $result = $this->doSelect($sql, $params);

            if (sizeof($result) == 0) {

                echo json_encode(
                    array(
                        "msg" => "هیچ موردی در دیتا بیس نبود",
                        "status_code" => "101"
                    )
                );
            } else {
             
                $sql2 = "SELECT * FROM cuntact WHERE cuntactid=? and userid=?";
                $params2 = array($result[0]['id'], $_SESSION['id']);
                $result2 = $this->doSelect($sql2, $params2);

                if (sizeof($result2) == 0) {

                    $sql = "INSERT INTO cuntact (userid,cuntactid) VALUES (?,?)";
                    $params = array($_SESSION['id'], $result[0]['id']);
                    $this->doQuery($sql, $params);

                    echo json_encode(
                        array(
                            "msg" =>  "اطلاعات با موفقیت ثبت شد",
                            "status_code" => "102"
                        )
                    );
                } else {
                    echo json_encode(
                        array(
                            "msg" =>  "مخاطب قبلا اضافه شده است",
                            "status_code" => "103"
                        )
                    );
                }
            }
        }
    }
    function cuntact_data()
    {

        $sql = "SELECT * FROM cuntact WHERE userid=?";
        $params = array($_SESSION['id']);
        $result = $this->doSelect($sql, $params);

        if (sizeof($result) == 0) {

            echo json_encode(
                array(
                    "msg" => "",
                    "status_code" => "104"
                )
            );
        } else {

            echo json_encode(
                array(
                    'msg' => $result,
                    'status_code' => '105'
                ),
            );
        }
    }
    function edit_check($post)
    {

        $sql = "SELECT * FROM users WHERE username=? and password=?";
        $params = array($post['username'], md5($post['password']));
        $result = $this->doSelect($sql, $params);

        if (sizeof($result) == 0) {
            echo json_encode(
                array(
                    "msg" => "not found",
                    "status_code" =>  "404"
                )
            );
        } else {

            echo json_encode(
                array(
                    "msg" => "ok",
                    "status_code" =>  "106"
                )
            );
        }
    }
    function update($post)
    {


        if ($post['edit_pas2'] != '') {

            $sql = " UPDATE `users` SET `name`=?,`password`=? WHERE username= ? ";
            $params = array($post['edit_name'], md5($post['edit_pas2']), $_SESSION['username']);
            $result = $this->doSelect($sql, $params);
            
        } else {

            $sql = " UPDATE `users` SET `name`=? WHERE username =? ";
            $params = array($post['edit_name'], $_SESSION['username']);
            $result = $this->doSelect($sql, $params);
        }
        if (sizeof($result) == 0) {
            echo json_encode(
                array(
                    "msg" => "not found",
                    "status_code" =>  "107"
                )
            );
        } else {

            echo json_encode(
                array(
                    "msg" => "ok",
                    "status_code" =>  "108"
                )
            );
        }
    }
    function name($data)
    {

        $sql = "SELECT * FROM users WHERE id=? ";
        $params = array($data['id']);
        $result = $this->doSelect($sql, $params);

        /// $time = time() - $result[0]['statustime'];
        $time3 = date('y/m/d-H:i', $result[0]['statustime']);
        //$time2 = getdate($time);


        if (sizeof($result) == 0) {
            echo json_encode(array(
                "msg" => "ok",
                "status_code" =>  "107"
            ));
        } else {
            echo json_encode(array(

                "name" => $result[0]['name'],
                "username" => $result[0]['username'],
                "status" => $result[0]['status'],
                "statustime" => $time3,
                "userimg" => $result[0]['userimg'],

                "status_code" =>  "108"
            ));
        }
    }
    function delet($post){

        $sql = "SELECT * FROM users WHERE username=? ";
        $params = array($post['username']);
        $result = $this->doSelect($sql, $params);

        $sql2 ="DELETE FROM `massege` WHERE (sendid=? and getid =?) or (sendid=? and getid =?) ";
        $params2 = array($_SESSION['id'],$result[0]['id'],$result[0]['id'],$_SESSION['id'] );
        $result2 = $this->doQuery($sql2, $params2);

        $sql2 ="DELETE FROM `cuntact` WHERE (userid=? and cuntactid =?) or (userid=? and cuntactid =?) ";
        $params2 = array($_SESSION['id'] ,$result[0]['id'] ,$result[0]['id'] ,$_SESSION['id'] );
        $result2 = $this->doQuery($sql2, $params2);

        echo json_encode(array(
            "msg" => "ok",
            "status_code" =>  "110"
        ));

    }
}
