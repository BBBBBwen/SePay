<?php
require 'friend.php';
if (isset($_SESSION['id'])) {
    $user_data = $db->getUserInfoById($_SESSION['id']);
    if ($user_data === false) {
        header('Location: ../logout.php');
        exit;
    }
} else {
    header('Location: ../logout.php');
    exit;
}

if (!empty($_POST['email'])) {
    $user = $db->getUserInfoByEmail($_POST['email']);
}
// REQUEST NOTIFICATION NUMBER
$get_req_num = $friend->requestNotification($_SESSION['id'], false);
// TOTAL FRIENDS
$get_frnd_num = $friend->getAllFriends($_SESSION['id'], false);
?>
<?php include_once "../../content/social_head.php"; ?>
<?php include_once "../../content/social_header.php"; ?>
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
            <li><a href="profile.php" rel="noopener noreferrer">Home</a></li>
            <li><a href="search.php" rel="noopener noreferrer" class="active">Search</a></li>
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
        <form action="" method="post">
            Search user: <input type="email" placeholder="enter email" rows="1" name="email" onkeydown="pressed(event)"></input>
        </form>
        <?php if (!empty($user) && $user) { ?>
            <div class="usersWrapper">
                <?php
                echo '<div class="user_box">
                                <div class="user_img"><img src="' . $user['avatar'] . '" alt="Profile image"></div>
                                <div class="user_info"><span>' . $user['username'] . '</span>
                                <span><a href="user_profile.php?id=' . $user['id'] . '" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button" style="float: right">See profile</a></div>
                            </div>';
                ?>
            </div>
        <?php } else { ?>
            <p>empty</p>
        <?php } ?>
        <script>
            function pressed(e) {
                // Has the enter key been pressed?
                if ((window.event ? event.keyCode : e.which) == 13) {
                    // If it has been so, manually submit the <form>
                    document.forms[0].submit();
                }
            }
        </script>
    </div>
</div>
</body>
</html>