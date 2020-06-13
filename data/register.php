<?php include_once "../content/head.php"; ?>
<?php include_once "../content/header.php"; ?>
<?php require '../content/connect_database.php'; ?>
<?php include '../data/rsa.php'; ?>
<?php
session_start();
require 'vendor/autoload.php';
define('AWS_KEY', 'AKIAJW4PWBT7J6EX2RXQ');
define('AWS_SECRET_KEY', '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');
$_SESSION['message'] = '';
if (!empty($_POST['username'])) $username = $_POST['username'];
if (!empty($_POST['email'])) $email = $_POST['email'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $haveError = true;
    $avatar_path = (time() . $_FILES['avatar']['name']);
    $temp_file_location = $_FILES['avatar']['tmp_name'];
    $s3 = new Aws\S3\S3Client([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => AWS_KEY,
            'secret' => AWS_SECRET_KEY,
        ]
    ]);
    try {
        $awsresult = $s3->putObject([
            'Bucket' => 'sepay-image',
            'Key' => $avatar_path,
            'SourceFile' => $temp_file_location,
            'ACL' => 'public-read'
        ]);
    } catch (RuntimeException $e) {
        $_SESSION['message'] = "Avatar upload fail";
    } catch (S3Exception $e) {
        $_SESSION['message'] = "Avatar upload fail";
    }
    if ($_POST['password'] != $_POST['confirmed_password']) {
        $_SESSION['message'] = "Two Password Do Not Match";
    } else if (empty($_POST['username'])) {
        $_SESSION['message'] = "Username can not be empty";
    } else if (empty($_POST['password'])) {
        $_SESSION['message'] = "Password can not be empty";
    } else if (empty($_POST['email'])) {
        $_SESSION['message'] = "Email can not be empty";
    } else if (!preg_match("!image!", $_FILES['avatar']['type'])) {
        $_SESSION['message'] = "Avatar must be png/jpg";
    } else if (empty($_POST['payment_password']) || strlen($_POST['payment_password']) < 6) {
        $_SESSION['message'] = "Please enter an at least 6 characters payment password";
    } else if (empty($_POST['user_level'])) {
        $_SESSION['message'] = "please select customer or merchant";
    } else if (!$awsresult) {
        $_SESSION['message'] = "Avatar upload fail";
    } else {
        $user = $db->getUserInfoByEmail($_POST['email']);
        if ($user) {
            $_SESSION['message'] = "Your email have already been registered";
        } else {
            $haveError = false;
        }
    }

    if ($haveError == false) {
        $result = $db->insertUser($_POST['username'], $_POST['password'], $_POST['email'], $_POST['payment_password'], $awsresult['ObjectURL'], $_POST['user_level']);
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
            <?php if (!empty($username)) { ?>
                <input type="text" placeholder="<?php echo $username; ?>" name="username"
                       value="<?php echo $username; ?>" required/>
            <?php } else { ?>
                <input type="text" placeholder="User Name" name="username" required/>
            <?php } ?>
            <?php if (!empty($email)) { ?>
                <input type="text" placeholder="<?php echo $email; ?>" name="email" value="<?php echo $email; ?>"
                       required/>
            <?php } else { ?>
                <input type="text" placeholder="Email" name="email" required/>
            <?php } ?>
            <input type="password" id="password" placeholder="Password" name="password" autocomplete="new-password"
                   onkeyup="CheckPassword()" required/>
            <input type="password" placeholder="Confirm Password" id="confirmed_password" name="confirmed_password"
                   autocomplete="new-password" required/>
            <input type="password" id="payment_password" placeholder="Payment Password (at least 6 characters)"
                   name="payment_password" required/>
            <span id="level">
                <input type="radio" name="user_level" value="1">
                <label for="female">Merchant</label>
                <input type="radio" name="user_level" value="2">
                <label for="male">Customer</label><br>
            </span>
            <input type="checkbox" id="age" name="Age" value="age" required>
            <label>confirm you are over 18 years old</label><br>
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
    var confirmed_password = document.getElementById('confirmed_password');
    var submit = document.getElementById('submit');

    function hash() {
        password = document.getElementById('password').value;
        confirmed_password = document.getElementById('confirmed_password').value;
        var hash = SHA256.hash(password);
        var confirmed_hash = SHA256.hash(confirmed_password);
        document.getElementById("password").value = hash;
        document.getElementById("confirmed_password").value = confirmed_hash;
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
        var DES_key = document.getElementById("payment_password").value;
        var encrypted_des_key = RSA_encryption(DES_key);
        document.getElementById("payment_password").value = encrypted_des_key;
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
<?php include_once "../content/foot.php"; ?>
