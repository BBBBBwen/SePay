<?php require_once "page_not_found.php"; ?>
<?php require_once "../../content/connect_database.php"; ?>
<?php
if (empty($_POST['username'])) {
    echo "<script> alert('Username can not be empty');
                            window.history.back(); 
                 </script>";
} else if (!empty($_POST['payment_password']) && strlen($_POST['payment_password']) < 6) {
    echo "<script> alert('Please enter an at least 6 characters payment password');
                            window.history.back(); 
                 </script>";
} else if (empty($_POST['user_level'])) {
    echo "<script> alert('please select customer or merchant');
                            window.history.back(); 
                 </script>";
} else {
    switch ($_GET['action']) {
        case 'add':
        {
            $user = getUserInfoByEmail($_POST['email']);
            if (!$user) {
                $result = insertUser($_POST['username'], $_POST['password'], $_POST['email'], $_POST['payment_password'], $_POST['avatar'], $_POST['user_level']);
                if ($result) {
                    echo "<script> alert('success');
                            window.location='administration.php'; 
                 </script>";
                } else {
                    echo "<script> alert('fail');
                            window.history.back(); 
                 </script>";
                }
            } else {
                echo "<script> alert('email exists');
                            window.history.back(); 
                 </script>";
            }
            break;
        }
        case "del":
        {
            $sql = "DELETE FROM users WHERE id = :user_id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':user_id', $_GET['id']);
            $stmt->execute();
            header("Location: user_management.php");
            break;
        }
        case "edit" :
        {
            $result = updateUser($_POST['user_id'], $_POST['username'], $_POST['password'], $_POST['email'], $_POST['payment_password'], $_POST['avatar'], $_POST['user_level']);
            $result = updateBalance($_POST['user_id'], 'AUD', $_POST['AUD']);
            $result = updateBalance($_POST['user_id'], 'USD', $_POST['USD']);
            $result = updateBalance($_POST['user_id'], 'EUR', $_POST['EUR']);
            if ($result) {
                echo "<script>alert('success');window.location='administration.php'</script>";
            } else {
                echo "<script>alert('fail');window.history.back()</script>";
            }
            break;
        }
    }
}