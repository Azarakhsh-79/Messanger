<html>

<head>
    <base href="<?= URL ?>">
    <link rel="stylesheet" href="public/css/stylelogin.css">
</head>

<body>
    <div class="login">
        <H1>ثبت نام</H1>
        <form onsubmit="return false">

            <input id="name" name="name" placeholder="نام">

            <input id="username" name="username" type="number" placeholder="شماره تلفن" /><br>

            <!-- <input id="emil" name="emile" placeholder=" ایمیل" /><br> -->
            <input id="img" type="file" placeholder="انتخواب عکس">

            <input id="password" name="password" type="password" placeholder="رمز عبور" />


            <input id="confirm_password" name="confirm_password" type="password" placeholder="تکرار رمز عبور" /><br>
            <button id='btn' type="submit" class="btn btn-primary btn-block btn-large">ثبت نام</button><br>

            <a href="login">ورود</a>

            <span id="showerror"></span>
        </form>

    </div>



    <script src="public/js/jquery-3.4.1.min.js"></script>

    <script src="public/js/jquery-3.4.1.min.js"></script>
    <script>
        function CheckPassword(inputtxt) {
            var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
            if (inputtxt.match(passw)) {

                return true;
            } else {

                return false;
            }
        }

        function Checkphone(phone) {
            var regex = new RegExp("^(\\+98|0)?9\\d{9}$");
            var result = regex.test(phone);
            return result;
        }

        function chekphone(phone) {
            var regex = /^09(1[0-9]|3[1-9]|2[1-9])-?[0-9]{3}-?[0-9]{4}$/;

            if (phone.match(regex)) {
                return true;
            } else {
                return false;
            }
        }

        function check_img() {

            let form_data = new FormData;
            let img = $("#img")[0].files;

            if (img.length > 0) {

                form_data.append('img', img[0]);

                $.ajax({
                    url: 'register/checkimg',
                    type: 'post',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: (response) => {

                        response = JSON.parse(response)
                        if (response.status_code == '201') {
                            $("#showerror").text(response.msg)
                        }
                        if (response.status_code == '202') {
                            $("#showerror").text(response.msg)
                        }
                        if (response.status_code == '203') {
                            $("#showerror").text(response.msg)
                        }
                        if (response.status_code == '204') {
                            sessionStorage.setItem('img_name', response.name);
                            sessionStorage.setItem('tmp_name', response.tmp_name);
                        }

                    }


                })
            } else {
                return false
            }



        }

        $("#btn").on('click', async function() {
            let img = await check_img();
            console.log(img)

            if ($("#name").val() == '' || $("#username").val() == '' || $("#password").val() == '' || $("#confirm_password").val() == '') {
                $("#showerror").text("همه قسمت هارا پر کنید");

            } else if ($("#password").val() !== $("#confirm_password").val()) {
                $("#showerror").text("تکرار پسورد اشتباه است");
                $("#confirm_password").val("")

            } else if (CheckPassword($("#password").val()) == false) {
                $("#showerror").text(" پسورد باید بین 6 تا 20 کاراکتر و شامل حروف کوچک و بزرگ انگلیسی , اعداد باشد");
                $("#password").val("")
                $("#confirm_password").val("")

            } else if (img == false) {
                $("#showerror").text('یک عکس انتخواب کنید')
            } else {
                console.log(sessionStorage.getItem('img_name'))
                console.log(sessionStorage.getItem('tmp_name'))
                $.ajax({
                    url: "<?= URL; ?>register/insert_data",
                    type: "POST",
                    data: {
                        "name": $("#name").val(),
                        "username": $("#username").val(),
                        "imgname": sessionStorage.getItem('img_name'),
                        "tmp_name": sessionStorage.getItem('tmp_name'),
                        "password": $("#password").val(),
                        "confirm_password": $("#confirm_password").val(),
                    },

                    success: () => {
                            sessionStorage.removeItem('img_name'),
                            sessionStorage.removeItem('tmp_name'),
                            window.location = "<?= URL; ?>login"
                        },

                    error: function(response) {
                        alert("خطای 500");
                    }

                });
            }
        });
    </script>






</body>

</html>