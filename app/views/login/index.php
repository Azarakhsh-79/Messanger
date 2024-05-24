<html>
<head>
    <base href="<?= URL ?>">
</head>
<body>
<form onsubmit="return false;">
    <label>Username:</label>
    <input id="username" class="select" name="username" placeholder="Enter username" />
    <label>Password:</label>
    <input id="password" class="select" name="password" type="password" placeholder="Enter password" />
    <input id="btn" type="submit" value="send data"/>
    <br/>
    <span id="showError"></span>
</form>

<script src="public/js/jquery-3.4.1.min.js"/></script>

<script>
    function CheckPassword(inputtxt)
    {
        var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
        if(inputtxt.value.match(passw))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    $("#btn").on('click',function (){
          var username = document.getElementById("username").value;
          var password = document.getElementById("password").value;

          if(username == ""){
              $("#showError").text("Username is empty");
          } else if (password == ""){
              $("#showError").text("Password is empty");
          } else if (!CheckPassword(password)){
              $("#showError").text("Password is not secure");
          } else {
              $.ajax({
                  url: "<?= URL; ?>login/check_data",
                  type: "POST",
                  data: {
                      "username": username,
                      "password": password
                  },
                  success: function (response){
                      response = JSON.parse(response);
                      if(response.status_code == "404"){
                          $("#showError").text("Username or Password is wrong");
                      } else {
                          window.location = "<?= URL; ?>";
                      }
                  },
                  error: function (response) {
                      alert("dsgdgfdgdfgd");
                  }
              });
          }
        }
    );
</script>

</body>
</html>