<?php
require 'friend.php';
if(isset($_SESSION['id'])){
    if(isset($_GET['id'])){
        $user_data = getUserInfoById($_GET['id']);
        if($user_data ===  false){
            header('Location: profile.php');
            exit;
        }
        else{
            if($user_data['id'] == $_SESSION['id']){
                header('Location: profile.php');
                exit;
            }
        }
    }
}
else{
    header('Location: ../logout.php');
    exit;
}
// CHECK FRIENDS
$is_already_friends = $friend->isFriends($_SESSION['id'], $user_data['id']);
//  IF I AM THE REQUEST SENDER
$check_req_sender = $friend->isSender($_SESSION['id'], $user_data['id']);
// IF I AM THE REQUEST RECEIVER
$check_req_receiver = $friend->isReceiver($_SESSION['id'], $user_data['id']);
// TOTAL REQUESTS
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
        <h1><?php echo  $user_data['username'];?></h1>
        <nav>
            <ul>
                <li><a href="profile.php" rel="noopener noreferrer">Home</a></li>
                <li><a href="notifications.php" rel="noopener noreferrer">Requests<span class="badge <?php
                        if($get_req_num > 0){
                            echo 'redBadge';
                        }
                        ?>"><?php echo $get_req_num;?></span></a></li>
                <li><a href="friends.php" rel="noopener noreferrer">Friends<span class="badge"><?php echo $get_frnd_num;?></span></a></li>
            </ul>
        </nav>
        <div class="actions">
            <?php
            if($is_already_friends){
                echo '<a href="functions.php?action=unfriend_req&id='.$user_data['id'].'" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button">Unfriend</a>';
            }
            elseif($check_req_sender){
                echo '<a href="functions.php?action=cancel_req&id='.$user_data['id'].'" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button">Cancel Request</a>';
            }
            elseif($check_req_receiver){
                echo '<a href="functions.php?action=ignore_req&id='.$user_data['id'].'" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button">Ignore</a> 
                    <a href="functions.php?action=accept_req&id='.$user_data['id'].'" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button">Accept</a>';
            }
            else{
                echo '<a href="functions.php?action=send_req&id='.$user_data['id'].'" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button">Send Request</a>';
            }
            ?>

        </div>
    </div>
</div>
</body>
</html>