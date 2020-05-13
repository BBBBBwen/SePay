<?php require_once "../../content/connect_database.php"; ?>
<?php
switch ($_GET['action']) {
    case 'add':{
        $result = insertUser($_POST['username'], $_POST['password'], $_POST['email'], $_POST['payment_password'], time() . $_FILES['avatar']['name'], $_POST['level']);
        if ($result) {
            echo "<script> alert('success');
                            window.location='user_management.php'; 
                 </script>";
        } else {
            echo "<script> alert('fail');
                            window.history.back(); 
                 </script>";
        }
        break;
    }
    case "del": {
        $sql = "DELETE FROM users WHERE id = :user_id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $_GET['id']);
        $stmt->execute();
        header("Location: user_management.php");
        break;
    }
    case "edit" :{
        $result = updateUser($_POST['id'], $_POST['username'], $_POST['password'], $_POST['email'], $_POST['payment_password'], time() . $_FILES['avatar']['name'], $_POST['level']);
        if($result){
            echo "<script>alert('success');window.location='user_management.php'</script>";
        }else{
            echo "<script>alert('fail');window.history.back()</script>";
        }


        break;
    }
}