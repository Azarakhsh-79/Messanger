<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="teme-color" content="black">
    <base href="<?php URL; ?>">
    <link rel="stylesheet" href="style.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> پیام رسان </title>

    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/all.css">
</head>

<body onload="refresh_cuntact()">



    <div class="motherdiv">
        <div class="iconbar">
            <li id="add" title="افزودن مخاطب"><i class="fa-regular fa-circle-plus"></i></li>
            <!-- <li id="refresh"><i class="fa-duotone fa-rotate "></i></li> -->
            <li id="edit" title="ویرایش اطلاعات"><i class="fa-solid fa-user-pen"></i></li>
            <li id="Exit" title="خروج"><i class="fa-duotone fa-right-from-bracket"></i></i></li>

        </div>


        <div class="right">

            <div class="header">
                <div class="userimg">
                    <img src="public/images/profile/a1" class="img" alt="">
                </div>
                <div class="listhead">
                    <?= $_SESSION['name']; ?>
                </div>
                <div class="menu">

                </div>



            </div>

            <div id="chatlist" class="chatlist">

            </div>
        </div>

        <div id="left" class="left">
            <div class="header">
                <div class="textimg">
                    <div class="userimg">
                        <img src="/app/views/index/imgg.jpeg" class="img" alt="">
                    </div>
                    <h4 id="usermessage">a<br> <span>onloin</span></h4>
                </div>
                <ul class="icon">
                    <li id="close"><i class="fa-solid fa-rectangle-xmark"></i></li>
                </ul>
            </div>
            <div class="messagebox">
                <div class="messagee sel">
                    <p>aaaaaaaaaaaaaaaaaaaaaaddgggggggggggggdddddddddddddddddddddaa
                        aaaaaaaaaaaaaaaaaaaa <br> <span>time</span></p>
                </div>
                <div class="messagee get">
                    <p>bbbbb<br> <span>time</span></p>
                </div>
            </div>

            <div class="chatbox">

                <li id="send"><i class="fa-solid fa-paper-plane-top"></i></li>
                <input id="message" type="text" placeholder="message...">
                <li id="send_file"><i class="fa-light fa-paperclip"></i></li>



            </div>


        </div>

        <div id="modal">
            <div class="modalform">
                <h4>افزودن مخاطب</h4>
                <input id="phone" type="text" placeholder="شماره موبایل">
                <button id="mbtn">ذخیره</button>
                <button id="c_btn"> خروج</button>
                <span id="modalspan"></span>

            </div>
        </div>

        <div id="modal_update">
            <div id="edit_form" class="edit_form">

                <h4>ویرایش اطلاعات </h4>
                <p>تلفن و رمز عبور خودرا وارد کنید</p>
                <input id="edit_phone" type="text" placeholder="شماره تلفن">
                <input id="edit_pas" type="password" placeholder=" پسورد">

                <button id="editbtn">ذخیره</button>
                <button id="e_c_btn"> خروج</button><br>
                <span id="edit_span"></span>



            </div>

            <div id="edit_username" class="edit_username">
                <p>هر قسمت که خالی باشه تغیر نمیکنه</p>

                <input id="edit_name" type="text" placeholder="تغیر نام ">
                <input id="edit_pas2" type="text" placeholder="تغیر رمز">
                <input id="confrim_edit_pas" type="text" placeholder="تکرار رمز">

                <button id="editbtn2">ذخیره</button>
                <button id="e_c_btn"> خروج</button><br>
                <span id="edit_span2"></span>
            </div>


        </div>




    </div>







    <script src="public/js/jquery-3.4.1.min.js"></script>
    <!-- <script src="public/js/indexjs.js"></script> -->
    <script>

        // ===================public=============================

        $("#close").on('click', () => {
            $("#left").css({
                'display': 'none'
            })
        })

        $("#Exit").on('click', () => {

            $.ajax({
                url: 'login/exit',
                type: 'post',
            });

            location.href = "https://localhost/Farawin-Messanger/login"

        })


        // ===================add cuntact========================

         $("#add").on('click', () => {
            $("#modal").css({
                'display': 'block'
            })
        })

        $("#mbtn").on('click', () => {

            var phone = document.getElementById("phone").value;

            if (phone == "") {

                $("#modalspan").text("شماره تلفن خالی است");

            } else {
                $.ajax({
                    url: "<?= URL . 'cuntact/check_data' ?>",
                    type: "POST",
                    data: {
                        "phone": phone
                    },

                    success: function(response) {
                        var modal = document.getElementById("modal");
                        response = JSON.parse(response);
                        if (response.status_code == "100") {
                            $("#modalspan").text("شماره خودتان را نمیتوانید اضافه کنید ")
                        }
                        if (response.status_code == "101") {
                            $("#modalspan").text("مخاطب قبلا ثبت نام نکرده است")

                        } else if (response.status_code == "102") {

                            data = cuntact_data();
                            modal.style.display = 'none';

                        } else if (response.status_code == "103") {
                            $("#modalspan").text(response.msg);
                        }
                    }
                });
            }
        });

        $("#c_btn").on('click', () => {
            $("#modal").css({
                'display': 'none'
            })
        })

        function cuntact_data() {

            $.ajax({
                url: 'cuntact/cuntact_data',
                typ: 'post',
                data: '',

                success: function(response) {
                    response = JSON.parse(response);



                    if (response.status_code == "104") {
                        return false;
                    } else if (response.status_code == "105") {

                        add_data_cuntact(response.msg);
                    }

                }

            })
        }

        function add_data_cuntact(cuntact) {
            document.getElementById('chatlist').innerHTML = '';
            for (i = 0; i < cuntact.length; i++) {
                $.ajax({
                    url: 'cuntact/name',
                    type: "post",
                    data: {
                        'id': cuntact[i]["cuntactid"]
                    },
                    success: (response) => {
                        response = JSON.parse(response);

                        if (response.status_code == '107') {

                        }
                        if (response.status_code == '108') {

                            var block = document.createElement('div');
                            block.classList.add('block');
                            block.setAttribute("onclick", 'block_click("' + response.username + '")');
                            block.setAttribute('id', 'block');

                            var imgbox = document.createElement('div');
                            imgbox.classList.add('imgbox');

                            var detalis = document.createElement('div');
                            detalis.classList.add('detalis');

                            var listhead = document.createElement('div');
                            listhead.classList.add('listhead');

                            var h4 = document.createElement('h4');

                            h4.setAttribute('id', response.username)
                            h4.textContent = response.name;

                            var p = document.createElement('p');
                            p.classList.add('time');


                            var message = document.createElement('div');
                            message.classList.add('message');


                            var pp = document.createElement('p');

                            pp.textContent = response.username;
                            var b = document.createElement('b');

                            message.appendChild(pp);
                            message.appendChild(b);

                            listhead.appendChild(h4);
                            listhead.appendChild(p);

                            detalis.appendChild(listhead);
                            detalis.appendChild(message);

                            block.appendChild(imgbox);
                            block.appendChild(detalis);

                            document.querySelector('.chatlist').prepend(block);

                            $('#chatlist').prepend(block);

                           


                        }
                    }
                })


                // <div class="block ">

                //         <div class="imgbox"><img src="imgg.jpeg" class="img"></div>
                //         <div class="detalis">
                //             <div class="listhead">
                //                 <h4>amir </h4>
                //                 <p class="time"> 00:00 </p>
                //             </div>

                //             <div class="message">
                //                 <p> hi ddaaaaaaaaad</p>
                //                 <b>1</b>
                //             </div>

                //         </div>
                //     </div>
            }
        }

        function refresh_cuntact() {
            cuntact_data();



        }

        function block_click(username) {
            
            $("#left").css({
                'display': 'block'
            });

            $("#usermessage").text($('#' + username).html());

            sessionStorage.removeItem('getmassege');
            sessionStorage.setItem('getmassege',username);



        }


        // ==================update=============================



        $("#edit").on('click', () => {
            $("#modal_update").css({
                'display': 'block'
            })
        })

        $("#e_c_btn").on('click', () => {
            $("#modal_update").css({
                'display': 'none'
            })
        })

        $("#editbtn").on('click', () => {

            var edit_phone = document.getElementById("edit_phone").value;
            var edit_pas = document.getElementById("edit_pas").value;
            var edit_form = document.getElementById("edit_form");
            var edit_username = document.getElementById("edit_username");

            if (edit_phone == '' || edit_pas == '') {
                $("#edit_span").text('همه بخش ها را پر کنید')
            }
            console.log(edit_phone, edit_pas)
            $.ajax({
                url: 'cuntact/edit_check',
                type: 'post',
                data: {

                    "username": edit_phone,
                    "password": edit_pas
                },

                success: (response) => {
                    response = JSON.parse(response);

                    if (response.status_code == '404') {
                        $("#edit_span").text('تلفن  یا رمز عبور صحیح نیست')
                    }
                    if (response.status_code == '106') {

                        edit_form.style.display = 'none'
                        edit_username.style.display = 'block'
                    }

                }





            })
        })

        function CheckPassword(inputtxt) {
            var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
            console.log(inputtxt)
            if (inputtxt.match(passw)) {
                return true;
            } else {
                return false;
            }
        }

        $("#editbtn2").on('click', () => {
            edit_name = document.getElementById("edit_name").value;
            edit_pas2 = document.getElementById("edit_pas2").value;
            confrim_edit_pas = document.getElementById("confrim_edit_pas").value;


            if (edit_pas2 == confrim_edit_pas) {
                if (CheckPassword(edit_pas2) != true) {
                    $("#edit_span2").text('رمز عبور باید بین 6 تا 20 رقم و شامل حروف فارسی یا انگلیسی باشد')
                }
                $.ajax({
                    url: 'cuntact/update',
                    type: 'post',
                    data: {
                        "edit_name": edit_name,
                        "edit_pas2": edit_pas2,
                    },
                    success: (response) => {
                        response = JSON.parse(response);


                        if (response.status_code == '107') {

                        }
                        if (response.status_code == '108') {

                        }
                    }





                })

            } else {
                $("#edit_span2").text('رمز عبور و تکرار صحیح نیست')
            }





        })


        // ==================messaage============================


        $("#send").on('click', () => {
            console.log($('#message').val());
            console.log(sessionStorage.getItem('getmassege'));

            $.ajax({
                url:'massege/massege',
                type:'post',
                data:{
                    'massege': $('#message').val(),
                    'getid': sessionStorage.getItem('getmassege')
                   
                },
                success:(response)=>{
                    response=JSON.parse(response);
                    console.log(response)

                }
            })
            

        })

        function get_message(username){

            $.ajax({
                url: 'massege/get_message',
                type:'post',
                data:{
                    'username':username
                },
                success:(response)=>{

                    response=JSON.parse(response);

                    if(response.status_code =='109'){


                    }
                }

            })


        }
    </script>



</body>



</html>