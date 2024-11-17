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
        //     if (isset($_FILES['img'])) {

        //         $img_name = $_FILES['img']['name'];
        //         $img_size = $_FILES['img']['size'];
        //         $tmp_name = $_FILES['img']['tmp_name'];
        //         $error = $_FILES['img']['error'];

        //         if ($error === 0) {
        //             if ($img_size > 1000000) {
        //                 echo json_encode(array(
        //                     'msg' => ' حجم فایل بالا است',
        //                     'status_code' => '202'
        //                 ));
        //             } else {

        //                 //پیدا کزدن فرمت عکس
        //                 $img_format = pathinfo($img_name, PATHINFO_EXTENSION);
        //                 //تبدیل کردن اسم به حروف کوچک 
        //                 $img_lower = strtolower($img_format);
        //                 $formats = array('jpg', 'jpeg', 'png');

        //                 if (in_array($img_lower, $formats)) {

        //                     $new_name = uniqid('IMG-', true) . '.' . $img_lower;

        //                     $upload_path = "D:/xamp/htdocs/Farawin-Messanger/public/images/profile/" . $new_name;
        //                     move_uploaded_file($tmp_name, $upload_path);

        //                     echo json_encode(array(
        //                         'msg'=>'ok',
        //                         'status_code' => '204'
        //                     ));
        //                 } else {
        //                     echo json_encode(array(
        //                         'msg' => ' باشد   jpg, jpeg, png فرمت عکس باید ',
        //                         'status_code' => '203'
        //                     ));
        //                 }
        //             }
        //         } else {
        //             echo json_encode(array(
        //                 'msg' => $error,
        //                 'status_code' => '201'
        //             ));
        //         }
        //     }




            $sql = "INSERT INTO users (name,username,password,register_date) VALUES (?,?,?,?)";
            $params = array($post['name'], $post['username'], md5($post['password']),  self::jalali_date("Y/m/d"));
            $this->doQuery($sql, $params);

            header("Location:" . URL . "login");
        } else {
            echo json_encode(array(
                "msg" => "شماره قبلا ثبت نام کرده است ",
                "status_code"=>'200'
            ));
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

    function checkimg()
    {
        if (isset($_FILES['img'])) {

            $img_name = $_FILES['img']['name'];
            $img_size = $_FILES['img']['size'];
            $tmp_name = $_FILES['img']['tmp_name'];
            $error = $_FILES['img']['error'];

            if ($error === 0) {
                if ($img_size > 1000000) {
                    echo json_encode(array(
                        'msg' => ' حجم فایل بالا است',
                        'status_code' => '202'
                    ));
                } else {

                    //پیدا کزدن فرمت عکس
                    $img_format = pathinfo($img_name, PATHINFO_EXTENSION);
                    //تبدیل کردن اسم به حروف کوچک 
                    $img_lower = strtolower($img_format);
                    $formats = array('jpg', 'jpeg', 'png');

                    if (in_array($img_lower, $formats)) {

                        $new_name = uniqid('IMG-', true) . '.' . $img_lower;

                        $upload_path = "D:/xamp/htdocs/Farawin-Messanger/public/images/profile/" . $new_name;
                        move_uploaded_file($tmp_name, $upload_path);

                        echo json_encode(array(
                            'name' => $new_name,
                            'tmp_name' => $tmp_name,
                            'status_code' => '204'
                        ));
                    } else {
                        echo json_encode(array(
                            'msg' => ' باشد   jpg, jpeg, png فرمت عکس باید ',
                            'status_code' => '203'
                        ));
                    }
                }
            } else {
                echo json_encode(array(
                    'msg' => $error,
                    'status_code' => '201'
                ));
            }
        }
    }
}
