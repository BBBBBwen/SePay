<?php
require __DIR__ . '/../Data/connect_database.php';
include __DIR__ . '/../Data/rsa.php';
$_SESSION['message'] = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $haveError = false;
    $avatar_path = ('gs://sesame-pay.appspot.com/images/' . $_FILES['avatar']['name']);
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
        $_SESSION['message'] = "Avatar must be png/jpg";
    }
    if (strlen($_POST['paymentpassword']) < 6) {
        $haveError = true;
        $_SESSION['message'] = "Please enter an at least 6 characters payment password";
    }
//    if (copy($_FILES['avatar']['tmp_name'], $avatar_path) == false) {
//        $haveError = true;
//        $_SESSION['message'] = "Avatar upload fail";
//    }
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

        $sql = "INSERT INTO users (username, password,email,balance,paymentpassword,avatar)
  			      VALUES(:username, :password,:email,:balance,:paymentpassword,:avatar)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $_POST['username']);
        $stmt->bindValue(':password', $_POST['password']);
        $stmt->bindValue(':email', $_POST['email']);
        $stmt->bindValue(':balance', 0);
        $stmt->bindValue(':paymentpassword', $_POST['paymentpassword']);
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
<link rel="stylesheet" href="../assets/css/form.css" type="text/css">
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
            <input type="password" id="paymentpassword" placeholder="Payment Password (at least 6 characters)"
                   name="paymentpassword" required/>
            <div class="avatar"><label>Select your avatar: </label><input type="file" name="avatar" accept="image/*"
                                                                          required/></div>
            <input type="submit" value="Register" id="submit" name="register" class="btn btn-block btn-primary"
                   onclick="encryption();hash();"/>
        </form>
    </div>
</div>
<script src="../assets/js/sha256.js"></script>
<script src="../assets/js/rsa.js"></script>
<script src="../assets/js/des.js"></script>
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


    //Encrypt payment password(DES) by RSA
    function encryption() {
        var DES_key = document.getElementById("paymentpassword").value;
        var encrypted_des_key = RSA_encryption(DES_key);
        document.getElementById("paymentpassword").value = encrypted_des_key;
    }

    //Encrypt DES key by RSA public key
    function RSA_encryption(deskey) {
        var pubilc_key = "-----BEGIN PUBLIC KEY-----MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzdxaei6bt/xIAhYsdFdW62CGTpRX+GXoZkzqvbf5oOxw4wKENjFX7LsqZXxdFfoRxEwH90zZHLHgsNFzXe3JqiRabIDcNZmKS2F0A7+Mwrx6K2fZ5b7E2fSLFbC7FsvL22mN0KNAp35tdADpl4lKqNFuF7NT22ZBp/X3ncod8cDvMb9tl0hiQ1hJv0H8My/31w+F+Cdat/9Ja5d1ztOOYIx1mZ2FD2m2M33/BgGY/BusUKqSk9W91Eh99+tHS5oTvE8CI8g7pvhQteqmVgBbJOa73eQhZfOQJ0aWQ5m2i0NUPcmwvGDzURXTKW+72UKDz671bE7YAch2H+U7UQeawwIDAQAB-----END PUBLIC KEY-----";
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(pubilc_key);
        var encrypted = encrypt.encrypt(deskey);
        return encrypted;
    }

</script>