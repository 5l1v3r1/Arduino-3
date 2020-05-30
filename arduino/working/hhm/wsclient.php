<?php
session_start();
include("../admin/php-config.conf");
include("../admin/php-db-config.conf");
$ID = $_GET['ID'];
?>
<html class="htmlClass">
    <head>
        <title>Online Crane : Ambient</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=0"/>
        <link rel="stylesheet" href="../class/jquery.mobile-1.4.5.min.css">
        <script src="../class/jquery-1.11.3.min.js"></script>
        <script src="../class/jquery.mobile-1.4.5.min.js"></script>
        <script type="text/javascript">
            //var sock = new WebSocket("ws://192.168.1.95:1919");  //replace this address with the one the node.js server prints out. keep port 1919
            var sock = new WebSocket("ws://103.76.180.24:1919");  //replace this address with the one the node.js server prints out. keep port 1919
            var display = document.getElementById("display");

            sock.onopen = function (event) {

//                alert("Socket connected succesfully!!!"+event);
                setTimeout(function () {
                    sock.send(id + '_Controller_Handshaked');
                }, 1000);
                display.innerHTML += "connection succeeded <br />";
            };


            sock.onmessage = function (event) {
                console.log(event);//show received from server data in console of browser
                display.innerHTML += event.data + "<br />"; //add incoming message from server to the log screen previous string + new string(message)
            };


            var ww = window.innerWidth;
            var wh = window.innerHeight;
            var id = '';
            var TY = '';
            var play_mode = '';
            var Timeout1 = '';
            var interval = '';

            $(document).ready(function () {
                infras();
                id = $("#id").val();
                //Smartphone Event
                $(".option-btn").bind('touchstart', function () {
                    var cmd = $(this).attr("cmd");
                    if (cmd) {
                        send_press(cmd);
                    }
                });
                $(".option-btn").bind('touchend', function () {
                    var bname = $(this).attr("bname");
                    if (bname) {
                        send_release(bname);
                    }
                });

            });

            function infras() {

                play_mode = $("#play_mode").val();
                if (play_mode === '1') {
                    $(".btn-play").show();
                } else {
                    alert('else mode');
                }
            }
            function reset_game() {

                var db_time = $("#T").attr("db_time");
                $("#T").val(db_time).attr("full_time", db_time);
                $("#TIME-COUNTDOWN").text(db_time).css("background-color", "#ddd");
                clearInterval(interval);
                $("#REWARD-DISPLAY").text('');
                switch_camera(1);
            }
            function btn_play() {
                $(".btn-play").hide();
                $(".btn-start").show();
                $("#cust_waiting").text('1');
                sock.send(id + "_play");    //send string to server


            }
            function btn_start() {
                $(".btn-start").hide();
                $(".btn-up").show();
                reset_game();
            }
            function btn_up_release() {
                $(".btn-up").hide();
                $(".btn-right").show();
                switch_camera(2);
            }
            function btn_right_release() {
                $(".btn-right").hide();
                send_command('TX5');
            }
            function send_press(cmd) {
                send_command(cmd);
            }
            function send_release(bname) {

                send_command("TX0");
                if (bname === 'btn_up') {
                    btn_up_release();
                } else if (bname === 'btn_right') {
                    btn_right_release();
                }
            }

            function send_command(command) {
                id = $("#id").val();
                TY = $("#TY").val();

                if (command === 'TX5') {
                    $("#TIME-COUNTDOWN").text('-');
                    $(".command-btn").removeAttr("cmd");
                    $(".control").removeAttr("onmousedown");
                    $(".control").removeAttr("onmouseup");

                    var rwd_counter = 15;
                    var rwd_interval = setInterval(function () {
                        rwd_counter--;
                        if (rwd_counter > 0) {
                            $("#REWARD-DISPLAY").text('รอลุ้น... ' + rwd_counter);
                        } else {
                            $("#REWARD-DISPLAY").text('');
                            clearInterval(rwd_interval);
                            $(".btn-start").show();
                            $('#T').val('30').attr("full_time", '30');
                            count_time('retain_play');
                        }
                    }, 1000);

                    $(".btn-right").hide();


//                    var RWD = setTimeout(function () {
//                        check_reward();
//                    }, 10000);
                }

                if (command !== "") {
                    count_time(0);
                    sock.send(id + "_" + command + "TY" + TY);    //send string to server
                } else {
                    console.log("empty string not sent");
                    alert('no command');
                }
                $("#command_note").val(id + "_" + command + "TY" + TY);
            }
            function check_reward() {




                var cmd_send = id + "_TX7TY888888";
                alert(cmd_send);
                sock.send(cmd_send);    //send string to server
                sock.onmessage = function (msgevent) {
                    console.log('in :', msgevent.data);
                    var reward_respond = msgevent.data;
                    var reward_result = reward_respond.split(":");
                    reward_result = reward_result[2];
                    if (reward_result === '1') {
                        $("#REWARD-DISPLAY").text('ยินดีด้วย!!!!!!');
                        alert("ยินดีด้วยค่ะ คุณได้รับของรางวัล !!!!!\n กรุณาเข้าที่หน้ารายการรางวัล เพื่อเลือกวิธีการจัดส่ง \nหรือขายคืนค่ะ");

                    } else {
                        $("#REWARD-DISPLAY").text('เสียใจด้วยค่ะ :(');
                        alert("เสียใจด้วยค่ะ :(\nลองใหม่นะคะ...");
                    }
                };
            }
            function switch_camera(cam) {
                if (cam === 0) {
                    if ($("#cam1").is(":visible")) {
                        $("#cam1").slideUp(300);
                        $("#cam2").slideDown(300);
                    } else {
                        $("#cam1").slideDown(300);
                        $("#cam2").slideUp(300);

                    }
                } else if (cam === 1) {
                    $("#cam1").slideDown(300);
                    $("#cam2").slideUp(300);
                    $("#cam3").slideUp(300);
                } else if (cam === 2) {
                    $("#cam1").slideUp(300);
                    $("#cam2").slideDown(300);
                    $("#cam3").slideUp(300);
                } else if (cam === 3) {
                    $("#cam1").slideUp(300);
                    $("#cam2").slideUp(300);
                    $("#cam3").slideDown(300);
                }

            }


            function count_time(mode) {
                var counter = parseInt($('#T').val());
                var full_time = parseInt($('#T').attr("full_time"));

                if (full_time === counter) {
                    $('#T').val('0');
                    interval = setInterval(function () {
                        counter--;
                        if ($("#TIME-COUNTDOWN").text() === '-') {
                            counter = 0;
                            clearInterval(interval);
                        } else if (counter <= 0 && mode === 0) {
                            clearInterval(interval);
                            send_command('TX5');
                        } else if (counter <= 0 && mode === 'retain_play') {
                            clearInterval(interval);
                            $(".btn-play").show();
                            $(".btn-start").hide();
                            $("#cust_waiting").text('0');
                        }

                        if (counter < 10) {
                            var counter_text = '0' + counter;

                            $("#TIME-COUNTDOWN").text(counter_text).css({backgroundColor: 'red', color: '#fff'});
                        } else {
                            var counter_text = '' + counter;
                            $("#TIME-COUNTDOWN").text(counter_text).css({backgroundColor: 'yellow', color: '#000'});
                        }

                    }, 1000);
                }
            }
        </script>
        <style>
            iframe{
                /*position:fixed;*/
                width:100%;
                /*height:30%;*/
                /*object-fit:cover;*/
            }
            .control{
                width:50px;
                height:50px;
            }
        </style>

    </head>
    <body>
        <?php
        $sql = "SELECT * FROM online_machine WHERE ID='$ID' AND Active=1";
        //echo $sql;
        $result = $conn_db->query($sql);
        while ($db = $result->fetch_array()) {
            foreach ($db as $key => $value) {
                $$key = $value;
            }
        }
/*
        $CameraBaseID = 2020000;
        $CameraID1 = $CameraBaseID.$ID*2;
        $CameraID2 = $CameraBaseID.$ID*2+1;

        //setup for test ;
        if ($ID==9){
        $CameraID1 = $CameraBaseID;
        $CameraID1.=7;
        $CameraID2 = $CameraBaseID;
        $CameraID2.=18;
        }*/
        ?>
        <div style="top:0;width:100%;background-color:#222;padding:3px;">
            <button class="ui-btn ui-btn-icon-left ui-icon-back ui-btn-inline ui-corner-all" onclick="location.href = '../'">Back</button>
            <div style="clear:both;"></div>
        </div>
        <div style="background-color:#111;padding:5px;">
            <div id="cam1" style="position:relative;background-color:#000;max-width:400px;margin:0 auto;">
                <!--iframe src="http://hhm.ambient.co.th:81/client_<?= $CameraID1 ?>" style="height:250px;" ></iframe-->
		<img id='ws1'></img>
                <div class="cam-caption">CAM 1</div>
            </div>

            <div id="cam2" style="display:none;position:relative;background-color:#000;max-width:400px;margin:0 auto;">
                <!--iframe src="http://hhm.ambient.co.th:81/client_<?= $CameraID2 ?>" style="height:250px;"></iframe-->
		<img id='ws2'></img>
                <div class="cam-caption">CAM 2</div>
            </div>
        </div>

        <script>
		var img = [];
		img.push(document.querySelector('#ws1'));
		img.push(document.querySelector('#ws2'));
            	//const WS_URL = 'ws:///35.240.185.52:65070';
            	const WS_URL = ['ws://hhm.ambient.co.th:'+<?=65070+$ID*2?>,'ws://103.76.180.24:'+<?=65070+$ID*2+1?>];
            	const ws = [];
            	WS_URL.forEach((item,i)=>{
               	  ws[i]= new WebSocket(item);
            	});

		let urlObject;
            	ws.forEach((item,i)=>{
            	 item.onopen = () => {
		 console.log(`Connected to ${WS_URL[i]}`);

		 }

            	 item.onmessage = message => {
               	  let arrayBuffer = message.data;
		  if(urlObject){
                   URL.revokeObjectURL(urlObject);
                  }

		  urlObject = URL.createObjectURL(new Blob([arrayBuffer]));
             	  img[i].src = urlObject;

		  } // it's now just connecting but doing nothing.
          	 });
        </script>

        <div id="PLAYER-DISPLAY" style="font:normal 15px sans-serif;background-color:lightgreen;padding:3px;font-size:13px;">
            Waiting:<span id="cust_waiting">0</span>  Watching:<span id="cust_waiting">1</span></div>
        <div id="REWARD-DISPLAY" style="font:normal 30px sans-serif;"></div>
        <div style="position:fixed;right:10px;top:350px;">
            <div id="btn-all"style="max-width:200px;display:none;">
                <?php
                include("../img/button/control_btn.svg");
                ?>

            </div>
            <div class="option-btn btn-play" onclick="btn_play()" cmd="" bname="" ><img class="command-btn" src="../img/button/online-play.png"></div>
            <div class="option-btn btn-start" onclick="btn_start()" cmd="" bname=""><img class="command-btn" src="../img/button/online-start.png"></div>
            <div class="option-btn btn-up" onmousedown="send_press('TX1')" onmouseup="send_release('btn_up')" cmd="TX1" bname="btn_up"><img class="command-btn" src="../img/button/online-up.png"></div>
            <div class="option-btn btn-right" onmousedown="send_press('TX4')" onmouseup="send_release('btn_right')" cmd="TX4" bname="btn_right"><img class="command-btn" src="../img/button/online-right.png"></div>
            <div style="position:fixed;top:75px;right:20px;width:75px;" onclick="switch_camera(0)">
                <img src="../img/cam-view.svg" style="width:100%">
            </div>

        </div>
        <div id="REWARD-LIST">
            <div style="font:normal 18px sans-serif;padding:5px;">รายการของรางวัลในตู้:</div>
            <div class="reward-node">
                <div><img src="../machine_pic/<?= $MachineID ?>.jpg"></div>
                <div class="reward-node-title"><?= $Title ?></div>

            </div>

        </div>
        <div style='display:none;position:absolute;bottom:10px;width:150px;left:1200px' id="AREA-DEV">
            <div>
                <table>
                    <tr>
                        <td></td>
                        <td><button class="control command-btn" onmousedown="send_command('TX1')" onmouseup="send_command('TX0')">↑</button></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><button class="control command-btn" onmousedown="send_command('TX3')" onmouseup="send_command('TX0')">←</button></td>
                        <td><button class="control command-btn" onclick="send_command('TX5')">G</button></td>
                        <td><button class="control command-btn" onmousedown="send_command('TX4')" onmouseup="send_command('TX0')">→</button></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button class="control command-btn" onmousedown="send_command('TX2')" onmouseup="send_command('TX0')">↓</button></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan='3'>
                            <button onclick="check_reward()">C-Reward</button>
                            <button onclick="send_command('TX8')">C-Reverse</button>
                            <button onclick="send_command('TX9')">Reset</button>
                        </td>
                    </tr>
                </table>
            </div>

            <input type="text" id="id" placeholder="id" value="<?= $MachineID ?>">
            <input type="text" id="play_mode" placeholder="play_mode" value="<?= $Play_Mode ?>">
            <input type="text" id="command_note" placeholder="command">
            <input type="text" id="TY" placeholder="TY" value="<?= $Grab_Weight ?>" >
            <input typ="text" id="T" placeholder="Timg"  value="<?= $Max_Second ?>" full_time="<?= $Max_Second ?>" db_time="<?= $Max_Second ?>">

            <div id="TIME-COUNTDOWN"><?= $Max_Second ?></div>
        </div>
        <div style='display:none'>
            <div id="spare">-return-</div>
        </div>
        <script type="text/javascript">
            $("#BTN-CONTROL").show();
            $("#AREA-DEV").show();
        </script>
        <style type="text/css">
            .cam-caption{
                position:absolute;
                bottom:10px;
                right:10px;
                color:#fff;
                opacity: 0.5;
                font:normal 16px sans-serif;
            }
            #TIME-COUNTDOWN{
                position:fixed;
                bottom:5px;
                right:5px;
                text-align:center;
                background-color:#ddd;
                border:solid 3px gray;
                border-radius:15px;
                padding:5px 10px;
                font:bold 35px courier;
            }
            .option-btn{
                display:none;
                max-width:200px;
            }
            #REWARD-LIST{
                clear:both;
                margin-top:120px;
            }
            .reward-node{
                float:left;
                margin:5px;
                background-color:#ddd;
                border:solid 1px #ccc;
                border-radius:10px;
            }
            .reward-node-title{
                padding:5px;
                font:normal 14px sans-serif;
            }
            .reward-node img{
                width:200px;
                height:200px;
                border-radius:10px;
            }
        </style>
    </body>
</html>
