<?php
require "../../content/connect_database.php";

class Friend
{

    protected $db;

    public function __construct($db_connection)
    {
        $this->db = $db_connection;
    }

    // CHECK IF ALREADY FRIENDS
    public function isFriends($user_id, $friend_id)
    {
        try {
            $sql = "SELECT * FROM friends WHERE (user_id = :user_id AND friend_id = :friend_id) OR (user_id = :friend_id AND friend_id = :user_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->bindValue(':friend_id', $friend_id);
            $stmt->execute();

            if ($stmt->rowCount() === 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    //  IF I AM THE REQUEST SENDER
    public function isSender($user_id, $friend_id)
    {
        try {
            $sql = "SELECT * FROM friend_request WHERE sender = ? AND receiver = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id, $friend_id]);

            if ($stmt->rowCount() === 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //  IF I AM THE RECEIVER
    public function isReceiver($user_id, $friend_id)
    {

        try {
            $sql = "SELECT * FROM friend_request WHERE sender = ? AND receiver = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$friend_id, $user_id]);

            if ($stmt->rowCount() === 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // CHECK IF REQUEST HAS ALREADY BEEN SENT
    public function isQequestExists($user_id, $friend_id)
    {

        try {
            $sql = "SELECT * FROM friend_request WHERE (sender = :user_id AND receiver = :friend_id) OR (sender = :friend_id AND receiver = :user_id)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindValue(':friend_id', $friend_id, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() === 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    // MAKE PENDING FRIENDS (SEND FRIEND REQUEST)
    public function pendingFriends($user_id, $friend_id)
    {

        try {
            $sql = "INSERT INTO friend_request(sender, receiver) VALUES(?,?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id, $friend_id]);
            header('Location: user_profile.php?id=' . $friend_id);
            exit;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // CANCEL FRIEND REQUEST
    public function cancelRequest($user_id, $friend_id)
    {

        try {
            $sql = "DELETE FROM friend_request WHERE (sender = :user_id AND receiver = :friend_id) OR (sender = :friend_id AND receiver = :user_id)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->bindValue(':friend_id', $friend_id);
            $stmt->execute();
            header('Location: user_profile.php?id=' . $user_id);
            exit;
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    // MAKE FRIENDS
    public function makeFriends($user_id, $friend_id)
    {

        try {

            $delete_pending_friends = "DELETE FROM friend_request WHERE (sender = :user_id AND receiver = :friend_id) OR (sender = :friend_id AND receiver = :user_id)";
            $delete_stmt = $this->db->prepare($delete_pending_friends);
            $delete_stmt->bindValue(':user_id', $user_id);
            $delete_stmt->bindValue(':friend_id', $friend_id);
            $delete_stmt->execute();
            if ($delete_stmt->execute()) {

                $sql = "INSERT INTO friends(user_id, friend_id) VALUES(?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$user_id, $friend_id]);
                header('Location: user_profile.php?id=' . $friend_id);
                exit;

            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    // DELETE FRIENDS
    public function deleteFriends($user_id, $friend_id)
    {
        try {
            $delete_friends = "DELETE FROM friends WHERE (user_id = :user_id AND friend_id = :friend_id) OR (user_id = :friend_id AND friend_id = :user_id)";
            $delete_stmt = $this->db->prepare($delete_friends);
            $delete_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $delete_stmt->bindValue(':friend_id', $friend_id, PDO::PARAM_INT);
            $delete_stmt->execute();
            header('Location: user_profile.php?id=' . $user_id);
            exit;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // REQUEST NOTIFICATIONS
    public function requestNotification($user_id, $send_data)
    {
        try {
            $sql = "SELECT sender, username, avatar FROM friend_request JOIN users ON friend_request.sender = users.id WHERE receiver = ?";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id]);
            if ($send_data) {
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } else {
                return $stmt->rowCount();
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }


    public function getAllFriends($user_id, $send_data)
    {
        try {
            $sql = "SELECT * FROM friends WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();

            if ($send_data) {

                $return_data = [];
                $all_users = $stmt->fetchAll(PDO::FETCH_OBJ);

                foreach ($all_users as $row) {
                    $get_user = "SELECT id, username, avatar FROM users WHERE id = ?";
                    $get_user_stmt = $this->db->prepare($get_user);
                    $get_user_stmt->execute([$row->friend_id]);
                    array_push($return_data, $get_user_stmt->fetch(PDO::FETCH_OBJ));
                }

                return $return_data;

            } else {
                return $stmt->rowCount();
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}

session_start();
$friend = new Friend($db);
?>