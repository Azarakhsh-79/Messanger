        // ===================add cuntact=============================
        var modal = document.getElementById("modal");
        var add = document.getElementById("add");
        var c_btn = document.getElementById("c_btn");
        var mbtn = document.getElementById("mbtn");


        add.onclick = function() {
            modal.style.display = 'block';
        }
        c_btn.onclick = function() {
            modal.style.display = 'none';
        }

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




        mbtn.onclick = function() {

            var phone = document.getElementById("phone").value;



            // console.log(phone);
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


                            //add_data_cuntact(data);

                            modal.style.display = 'none';

                        } else if (response.status_code == "103") {
                            $("#modalspan").text(response.msg);
                        }
                    }
                });
            }
        }

        function add_data_cuntact(cuntact) {
            $("#chatlist").children().empty();
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
                            block.setAttribute("onclick", 'block_click()');
                            block.setAttribute('id', 'block');

                            var imgbox = document.createElement('div');
                            imgbox.classList.add('imgbox');

                            var detalis = document.createElement('div');
                            detalis.classList.add('detalis');

                            var listhead = document.createElement('div');
                            listhead.classList.add('listhead');

                            var h4 = document.createElement('h4');
                            h4.classList.add('h4');
                            h4.textContent = response.msg;
                            var p = document.createElement('p');
                            p.classList.add('time');

                            var message = document.createElement('div');
                            message.classList.add('message');

                            var pp = document.createElement('p');
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

        function block_click() {

            var value = document.getElementsByClassName("h4");
            var value2 =value.innerHTML;
            $("#usermessage").text(value2);
            document.getElementById('#usermessage').innerHTML=value2;
            usermessage.style.background = 'red'
			
			// left.style.display='none'
			



        }



        // ==================update====================================


        var modal_update = document.getElementById("modal_update");
        var edit_phone = document.getElementById("edit_phone").value;
        var edit_pas = document.getElementById("edit_pas").value;
        var edit_form = document.getElementById("edit_form");
        var edit_username = document.getElementById("edit_username");



        $("#edit").on('click', () => {
            modal_update.style.display = 'block'
        })

        $("#e_c_btn").on('click', () => {
            modal_update.style.display = 'none'
        })


        $("#editbtn").on('click', () => {
            $.ajax({
                url: 'cuntact/edit_check',
                type: 'post',
                data: {
                    "username": edit_phone,
                    "password": edit_pas
                },

                success: (response) => {

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



        $("#Exit").on('click', () => {


            $.ajax({
                url: 'login/exit',
                type: 'post',

            });

            location.href = "https://localhost/Farawin-Messanger/"


        })
        // $("#block").on('click', () => {
        //     bbb = document.getElementById("aaa").text;
        //     $("#usermassega").text(bbb)
        // })