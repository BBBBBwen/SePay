<?php
require 'friend.php';

if(isset($_SESSION['id'])){
    $user_data = getUserInfoById($_SESSION['id']);
    if($user_data ===  false){
        header('Location: ../logout.php');
        exit;
    }
    // FETCH ALL USERS WHERE ID IS NOT EQUAL TO MY ID
    $all_users = getAllUsers($_SESSION['id']);
}
else{
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
        <h1><?php echo  $user_data['username'];?></h1>
    </div>
    <nav>
        <ul>
            <li><a href="profile.php" rel="noopener noreferrer" class="active">Home</a></li>
            <li><a href="notifications.php" rel="noopener noreferrer">Requests<span class="badge <?php
                    if($get_req_num > 0){
                        echo 'redBadge';
                    }
                    ?>"><?php echo $get_req_num;?></span></a></li>
            <li><a href="friends.php" rel="noopener noreferrer">Friends<span class="badge"><?php echo $get_frnd_num;?></span></a></li>
        </ul>
    </nav>
    <div class="all_users">
        <h3>All Users</h3>
        <div class="usersWrapper">
            <?php
            if($all_users){
                foreach($all_users as $row){
                    echo '<div class="user_box">
                                <div class="user_img"><img src="'.$row->avatar.'" alt="Profile image"></div>
                                <div class="user_info"><span>'.$row->username.'</span>
                                <span><a href="user_profile.php?id='.$row->id.'" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button" style="float: right">See profile</a></div>
                            </div>';
                }
            }
            else{
                echo '<h4>There is no user!</h4>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>