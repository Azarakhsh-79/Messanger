<?php

class model_login extends Model
{
    public $checkLogin = '';

    function __construct()
    {
        parent::__construct();
    }

    function check_data($post)
    {
        $sql = "SELECT * FROM users WHERE username=? and password=?";
        $params = array($post['username'], md5($post['password']));
        $result = $this->doSelect($sql, $params);

        if (sizeof($result) == 0) {
            echo json_encode(array(
                    "msg" => "not found",
                    "status_code"=>  "404"
                )
            );
        } else {
            $this->session_set("username", $result[0]['username']);
            $this->session_set("id", $result[0]['id']);
            $this->session_set("name", $result[0]['name']);
            $this->session_set("src", $result[0]['userimg']);

            $sql2 = " UPDATE users SET status=?, statustime=? WHERE username= ? ";
            $params2 = array(1, time() , $post['username']);
            $result2 = $this->doQuery($sql2, $params2);



            $this->checkLogin = $result[0]['username'];
            echo json_encode(array(
                    "msg" => "ok",
                    "status_code"=>  "200"
                )
            );
        }
    }
    function exit(){

        
        $sql = " UPDATE users SET status=?, statustime=? WHERE username= ? ";
        $params = array(0, time() , $_SESSION['username']);
        $result = $this->doQuery($sql, $params);

        session_destroy();
        header('Location:'.URL);
    }
}
?>