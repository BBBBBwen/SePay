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
            <li><a href="profile.php" rel="noopener noreferrer" class="active">Home</a></li>
            <li><a href="search.php" rel="noopener noreferrer">Search</a></li>
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
        <div style="margin-left: 25%">
            <?php
            echo '<div>
                       Email: <span>' . $user_data['email'] . '</span><br>
                       Name: <span>' . $user_data['username'] . '</span><br>
                       Registration date: <span>' . $user_data['reg_date'] . '</span>
                  </div>';
            ?>
        </div>
    </div>
</body>
</html>