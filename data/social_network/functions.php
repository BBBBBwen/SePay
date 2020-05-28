<?php
require 'friend.php';

function redirect_to_profile(){
    header('Location: profile.php');
    exit;
}
// IF GET ACTION AND ID PARAMETERS
if(isset($_GET['action']) && isset($_GET['id'])){
    // CHEKC USER LOGGED IN OR NOT || IF USER LOGGED IN
    if(isset($_SESSION['id'])){
        // IF PARAMETER ID IS EQUAL TO MY ID($_SESSION['user_id']) THEN REDIRECT TO PROFILE
        if($_GET['id'] == $_SESSION['id']){
            redirect_to_profile();
        }
        // OTHERWISE DO THIS
        else{
            // ASSIGN TO VARIABLE
            $user_id = $_GET['id'];
            $my_id = $_SESSION['id'];

            // IF GET SEND REQUEST ACTION
            if($_GET['action'] == 'send_req'){
                // CHECK IS REQUEST ALREADY SENT OR NOT
                // is_request_already_sent() FUNCTION RETURN TRUE OR FLASE
                if($friend->isQequestExists($my_id, $user_id)){
                    redirect_to_profile();
                }
                // CHECK IF THIS ID IS ALREADY IN MY FRIENDS LIST.
                // THIS FUNCTION ALSO RETURN TRUE OR FLASE
                elseif($friend->isFriends($my_id, $user_id)){
                    redirect_to_profile();
                }
                // OTHERWISE MAKE FRIEND REQUEST
                else{
                    $friend->pendingFriends($my_id, $user_id);
                }
            }
            // IF GET CANCEL REQUEST OR IGNORE REQUEST ACTION
            else if($_GET['action'] == 'cancel_req' || $_GET['action'] == 'ignore_req'){
                $friend->cancelRequest($my_id, $user_id);
            }
            // IF GET ACCEPT REQUEST ACTION
            elseif($_GET['action'] == 'accept_req'){

                if($friend->isFriends($my_id, $user_id)){
                    redirect_to_profile();
                }
                else{
                    $friend->makeFriends($my_id, $user_id);
                }
            }
            // IF GET UNFRIEND REQUEST ACTION
            elseif($_GET['action'] == 'unfriend_req'){
                $friend->deleteFriends($my_id, $user_id);
            }
            else{
                redirect_to_profile();
            }
        }
    }
    else{
        header('Location: ../logout.php');
        exit;
    }
}
else{
    redirect_to_profile();
}