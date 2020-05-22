<?php
require 'friend.php';

if (isset($_SESSION['id'])) {
    $user_data = getUserInfoById($_SESSION['id']);
    if ($user_data === false) {
        header('Location: ../logout.php');
        exit;
    }
    // FETCH ALL USERS WHERE ID IS NOT EQUAL TO MY ID
    $all_users = getAllUsers($_SESSION['id']);
} else {
    header('Location: ../logout.php');
    exit;
}
// REQUEST NOTIFICATION NUMBER
$get_req_num = $friend->requestNotification($_SESSION['id'], false);
// TOTAL FRIENDS
$get_frnd_num = $friend->getAllFriends($_SESSION['id'], false);
?>
<?php include_once "../../content/social_head.php"; ?>
<?php include_once "../../content/social_header.php"; ?>
<html>
<style type="text/css">
    div#container {
        width: 500px;
        background-color: #99bbbb;
        margin: 0 auto;
    }

    div#header {
        background-color: #99bbbb;
    }

    div#content {
        background-color: #EEEEEE;
        height: 200px;
        width: 500px;
        float: left;
    }

    div#input {
        background-color: #99bbbb;
        height: 150px;
        width: 500px;
        float: left;
    }

    div#form {
        width: 500px;
        height: 80px;
    }

    div#chat_content {
        width: 500px;
        height: 260px;
    }

    h1 {
        margin-bottom: 0;
    }

    h2 {
        margin-bottom: 0;
        font-size: 18px;
    }

    h3 {
        margin-bottom: 0;
    }

    ul {
        margin: 0;
    }

    li {
        list-style: none;
    }
</style>
<?php
$receive_id = $_GET['id'];
$send_id = $_SESSION['id'];
$chtName = getUserInfoById($_GET['id'])['username'];
?>
<body>
<div class="profile_container">

    <div class="inner_profile">
        <div class="img">
            <img src="<?php echo $user_data['avatar']; ?>" alt="Profile image">
        </div>
        <h1><?php echo $user_data['username']; ?></h1>
    </div>
    <nav>
        <ul>
            <li><a href="profile.php" rel="noopener noreferrer" class="active">Home</a></li>
            <li><a href="notifications.php" rel="noopener noreferrer">Requests<span class="badge <?php
                    if ($get_req_num > 0) {
                        echo 'redBadge';
                    }
                    ?>"><?php echo $get_req_num; ?></span></a></li>
            <li><a href="friends.php" rel="noopener noreferrer">Friends<span
                            class="badge"><?php echo $get_frnd_num; ?></span></a></li>
        </ul>
    </nav>
    <div class="all_users">
        <h3>Chat with <?php echo $chtName ?></h3>
        <div class="usersWrapper">

            <div id="chat">
			<textarea name="chat_content" id="chat_content"
                      style="width: 480px; height:250px; margin:5px;border:0;padding:0;" readonly="readonly">
			</textarea>
            </div>

            <div id="form">
                <form name="chat">
                    <div id="input_content">
                        <input id="input" type="textarea" name="content"
                               style="width: 400px; margin:5px;border-color: #0070ba;padding:0;">
                        <input type="hidden" name="send" value="<?php echo $send_id ?>">
                        <input type="hidden" name="receive" value="<?php echo $receive_id ?>">
                        <button type="button" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button"
                                style="float:right" onclick="sendContent()">send
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">

    var int=self.setInterval("loadContent()",2000)

    function loadContent() {
        var receive = document.getElementsByName("receive")[0].value;
        var send = document.getElementsByName("send")[0].value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("chat_content").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "http://localhost/SePay/data/social_network/get_chat.php?send=" + send + "&receive=" + receive, true);
        xmlhttp.send();
    }

    function sendContent() {
        var content = document.getElementsByName("content")[0].value;
        var receive = document.getElementsByName("receive")[0].value;
        var send = document.getElementsByName("send")[0].value;

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
                document.getElementById("input").value = "";
        }
        xmlhttp.open("POST", "http://localhost/SePay/data/social_network/send_chat.php", true);
        var post_str = "content=" + content + "&receive=" + receive + "&send=" + send;
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(post_str);
        loadContent();
    }

</script>
</body>
</html>
