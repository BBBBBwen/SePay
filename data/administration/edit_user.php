<?php require_once "page_not_found.php"; ?>
<?php require_once "../../content/connect_database.php"; ?>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Management System</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table, td, th {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<?php
$sql = "SELECT * FROM users WHERE id =" . $_GET['id'];
$user = getUserInfoById($_GET['id']);
?>
<form id="add_user" name="add_user" method="post" action="action.php?action=add">
    <table>
        <tr>
            <td>user name</td>
            <td><input name="username" type="text" value="<?php echo $user['username'] ?>"/></td>
        </tr>
        <tr>
            <td>password (left blank for unchanged)</td>
            <td><input id="password" name="password"/></td>
        </tr>
        <tr>
            <td>email</td>
            <td><input type="text" name="email" value="<?php echo $user['email'] ?>"/></td>
        </tr>
        <tr>
            <td>payment_password (left blank for unchanged)</td>
            <td><input name="payment_password" id="payment_password" type="text"/></td>
        </tr>
        <tr>
            <td>image file's name of avatar</td>
            <td><input name="avatar" type="text" value="<?php echo $user['avatar'] ?>"/></td>
        </tr>
        <tr>
            <td>user_level (0 for admin, 1 for user, 2 for merchant)</td>
            <td><input name="user_level" type="text" value="<?php echo $user['user_level'] ?>"/></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="edit" id="submit" onclick="encryption();hash();"/>
                <input type="reset" value="reset"/>
            </td>
        </tr>
    </table>
</form>
</body>
<script src="../../assets/js/sha256.js"></script>
<script src="../../assets/js/rsa.js"></script>
<script src="../../assets/js/des.js"></script>
<script src="../../assets/js/security.js"></script>
</html>
