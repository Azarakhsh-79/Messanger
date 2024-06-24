<html>
    <head>
     <base href="<?= URL ?>">
     <link rel="stylesheet" href="public/css/stylelogin.css">
    </head>
<body>
    <div class="login">
        <H1>ثبت نام</H1>
<form onsubmit="return false" >

    <input  id="name"  name="name" placeholder="نام">
  
    <input id="username" name="username" placeholder="شماره تلفن" /><br>

    <!-- <input id="emil" name="emile" placeholder=" ایمیل" /><br> -->
    
    <input id="password" name="password" type="password" placeholder="رمز عبور" /><br>
    
    <input id="confirm_password" name="confirm_password" type="password" placeholder="تکرار رمز عبور" /><br>
    <button id='btn' type="submit"  class="btn btn-primary btn-block btn-large" >ثبت نام</button><br>

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
    
        $("#btn").on('click', function() {

           

            if($("#name").val() == '' ||$("#username").val() == ''||$("#password").val() == ''||$("#confirm_password").val() == ''){
                $("#showerror").text("همه قسمت هارا پر کنید");
            }else if($("#password").val() !== $("#confirm_password").val()){
                $("#showerror").text("تکرار پسورد اشتباه است");
            }else if(CheckPassword($("#password").val())== false){
                $("#showerror").text(" پسورد باید بین 6 تا 20 کاراکتر و شامل حروف کوچک و بزرگ انگلیسی , اعداد باشد");
                $("#password").val("")
                $("#confirm_password").val("")
            }else{
                $.ajax({
                    url: "<?= URL; ?>register/insert_data",
                    type: "POST",
                    data: {
                        "name": $("#name").val(),
                        "username": $("#username").val(),
                        // "emil":$("#emil").val() ,
                        "password": $("#password").val(),
                        "confirm_password": $("#confirm_password").val()
                    },

                    success: window.location = "<?= URL; ?>login",
                   
                    error: function(response) {
                        alert("خطای 500");
                    }
                });
            }

           
        });
    </script>






</body>
</html>


