<?php
require 'connect_database.php';
session_start();
$_SESSION['message'] = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $haveError = false;
    $avatar_path = ('assets/images/' . $_FILES['avatar']['name']);
    if ($_POST['password'] != $_POST['confirmpassword']) {
        $haveError = true;
        $_SESSION['message'] = "Two Password Do Not Match";
    }
    if (empty($_POST['username'])) {
        $haveError = true;
        $_SESSION['message'] = "Username can not be empty";
    }
    if (empty($_POST['password'])) {
        $haveError = true;
        $_SESSION['message'] = "Password can not be empty";
    }
    if (empty($_POST['email'])) {
        $haveError = true;
        $_SESSION['message'] = "Email can not be empty";
    }
    if (!preg_match("!image!", $_FILES['avatar']['type'])) {
        $haveError = true;
        $_SESSION['message'] = "Avater must be png/jpg";
    }
    if (copy($_FILES['avatar']['tmp_name'], $avatar_path) == false) {
        $haveError = true;
        $_SESSION['message'] = "Avater upload fail";
    }
    $sql = "SELECT COUNT(email) AS num FROM users WHERE email=:email";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['num'] > 0) {
        $haveError = true;
        $_SESSION['message'] = "Your email have already been registered";
    }

    if ($haveError == false) {

        $sql = "INSERT INTO users (username, password,email,balance,avatar)
  			      VALUES(:username, :password,:email,:balance,:avatar)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $_POST['username']);
        $stmt->bindValue(':password', $_POST['password']);
        $stmt->bindValue(':email', $_POST['email']);
        $stmt->bindValue(':balance', 0);
        $stmt->bindValue(':avatar', $avatar_path);
        $result = $stmt->execute();
        $lastId = $db->lastInsertId();

        $_SESSION['message'] = 'Register Success!';
        header("Location: login.php");
    }
}

?>
<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet"
      type="text/css"/>
<link rel="stylesheet" href="assets/css/form.css" type="text/css">
<div class="body-content">
    <div class="module">
        <h1>Create an account</h1>
        <form class="form" action="register.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="alert alert-error"><?php echo $_SESSION['message']; ?></div>
            <input type="text" placeholder="User Name" name="username" required/>
            <input type="email" placeholder="Email" name="email" required/>
            <input type="password" id="password" placeholder="Password" name="password" autocomplete="new-password"
                   onkeyup="CheckPassword()" required/>
            <input type="password" placeholder="Confirm Password" id="confirmpassword" name="confirmpassword"
                   autocomplete="new-password" required/>
            <div class="avatar"><label>Select your avatar: </label><input type="file" name="avatar" accept="image/*"
                                                                          required/></div>
            <input type="submit" value="Register" id="submit" name="register" class="btn btn-block btn-primary"
                   onclick="hash()"/>
        </form>
    </div>
</div>
<script src="sha256.js"></script>
<script type="text/javascript">
    var password = document.getElementById('password');
    var confirmpassword = document.getElementById('confirmpassword');
    var submit = document.getElementById('submit');

    function hash() {
        password = document.getElementById('password').value;
        confirmpassword = document.getElementById('confirmpassword').value;
        var hash = SHA256.hash(password);
        var confirmhash = SHA256.hash(confirmpassword);
        document.getElementById("password").value = hash;
        document.getElementById("confirmpassword").value = confirmhash;
    }

    function CheckPassword() {
        if (password.value.length < 6) {
            submit.disabled = true;
            submit.value = 'Please enter at least 6 characters password';
        } else {
            submit.disabled = false;
            submit.value = 'Register';
        }
    }
</script>