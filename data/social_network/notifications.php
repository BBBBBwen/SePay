<?php
require 'friend.php';

if(isset($_SESSION['id'])){
    $user_data = $db->getUserInfoById($_SESSION['id']);
    if($user_data ===  false){
        header('Location: ../logout.php');
        exit;
    }
}
else{
    header('Location: ../logout.php');
    exit;
}
// TOTAL REQUESTS
$get_req_num = $friend->requestNotification($_SESSION['id'], false);
// TOTAL FRIENDS
$get_frnd_num = $friend->getAllFriends($_SESSION['id'], false);
$get_all_req_sender = $friend->requestNotification($_SESSION['id'], true);
?>
<?php include_once "../../content/social_head.php"; ?>
<?php include_once "../../content/social_header.php"; ?>
<body>
<div class="profile_container">

    <div class="inner_profile">
        <div class="img">
            <img src="<?php echo $user_data['avatar']; ?>" alt="Profile image">
        </div>
        <h1><?php echo  $user_data['username'];?></h1>
    </div>
    <nav>
        <ul>
            <li><a href="profile.php" rel="noopener noreferrer">Home</a></li>
            <li><a href="notifications.php" rel="noopener noreferrer" class="active">Requests<span class="badge <?php
                    if($get_req_num > 0){
                        echo 'redBadge';
                    }
                    ?>"><?php echo $get_req_num;?></span></a></li>
            <li><a href="friends.php" rel="noopener noreferrer">Friends<span class="badge"><?php echo $get_frnd_num;?></span></a></li>
        </ul>
    </nav>
    <div class="all_users">
        <h3>All request senders</h3>
        <div class="usersWrapper">
            <?php
            if($get_req_num > 0){
                foreach($get_all_req_sender as $row){
                    echo '<div class="user_box">
                                <div class="user_img"><img src="'.$row->avatar.'" alt="Profile image"></div>
                                <div class="user_info"><span>'.$row->username.'</span>
                                <span><a href="user_profile.php?id='.$row->sender.'" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button">See profile</a></div>
                            </div>';
                }
            }
            else{
                echo '<h4>You have no friend requests!</h4>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>