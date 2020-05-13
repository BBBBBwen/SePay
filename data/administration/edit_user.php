<?php require_once "../../content/connect_database.php"; ?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
</head>
<body>
<?php
$sql = "SELECT * FROM stu WHERE id =" . $_GET['id'];
$user = getUserInfoById($_GET['id']);
?>
<form id="add_user" name="add_user" method="post" action="action.php?action=add">
    <table>
        <tr>
            <td>user name</td>
            <td><input name="name" type="text" value="<?php echo $user['username'] ?>"/></td>

        </tr>
        <tr>
            <td>password</td>
            <td><input name="password" value="<?php echo $user['password'] ?>"/></td>
        </tr>
        <tr>
            <td>email</td>
            <td><input type="text" name="email" value="<?php echo $user['email'] ?>"/></td>
        </tr>
        <tr>
            <td>payment_password</td>
            <td><input name="payment_password" type="text" value="<?php echo $user['payment_password'] ?>"/></td>
        </tr>
        <tr>
            <td>image file's name of avatar</td>
            <td><input name="avatar" type="text" value="<?php echo $user['avatar'] ?>"/></td>
        </tr>
        <tr>
            <td>user_level (1 for user, 2 for merchant)</td>
            <td><input name="user_level" type="text" value="<?php echo $user['user_level'] ?>"/></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="edit"/>
                <input type="reset" value="reset"/>
            </td>
        </tr>
    </table>
</form>
</body>
</html>