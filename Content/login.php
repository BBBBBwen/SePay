<?php
require __DIR__.'/../Data/connect_database.php';
$_SESSION['message'] = '';
if (!empty($_POST)) {
    if (empty($_POST['email'])) {
        $_SESSION['message'] = "Email can not be empty";
    }
    if (empty($_POST['password'])) {
        $_SESSION['message'] = "Password can not be empty";
    }
    $query = "SELECT * FROM users WHERE email=:email";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if (empty($user)) {
        $_SESSION['message'] = "Your username is not exist! Please <a href=register.php>Register</a> first!";
    } else if ($user && ($_POST['password'] == $user['password'])) {
        if (isset($_SESSION['id'])) {
            unset($_SESSION['id']);
        }

        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['avatar'] = $user['avatar'];
        $_SESSION['message'] = "Login Success!";
        header("Location: /");
    } else {
        $_SESSION['message'] = "Your password is incorrect!";
    }

}
?>
<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet"
      type="text/css"/>
<link rel="stylesheet" href="../assets/css/form.css" type="text/css">
<div class="body-content">
    <div class="module">
        <h1>Log in</h1>
        <form class="form" action="login.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="alert alert-error"><?php echo $_SESSION['message']; ?></div>
            <input type="email" placeholder="Email" name="email" required/>
            <input type="password" id="password" placeholder="Password" name="password" autocomplete="password"
                   required/>
            <input type="submit" value="Log In" id="submit" name="register" class="btn btn-block btn-primary"
                   onclick="hash()"/>
        </form>
    </div>
</div>
<script src="../assets/js/sha256.js"></script>
<script type="text/javascript">
    function hash() {
        var password = document.getElementById('password').value;
        var hash = SHA256.hash(password);
        document.getElementById("password").value = hash;
    }</script>