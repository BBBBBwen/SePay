<?php require_once "page_not_found.php"; ?>
<html>
<head>
    <title>User Management System</title>
</head>
<body>
<h3>add user</h3>
<form id="add_user" name="add_user" method="post" action="action.php?action=add">
    <table>
        <tr>
            <td>user name</td>
            <td><input name="username" type="text" /></td>
        </tr>
        <tr>
            <td>password</td>
            <td><input name="password" id="password" /></td>
        </tr>
        <tr>
            <td>email</td>
            <td><input type="text" name="email" /></td>
        </tr>
        <tr>
            <td>payment_password</td>
            <td><input name="payment_password" type="text" id="payment_password" /></td>
        </tr>
        <tr>
            <td>image file's name of avatar</td>
            <td><input name="avatar" type="text" /></td>
        </tr>
        <tr>
            <td>user_level (0 for admin, 1 for merchant, 2 for user)</td>
            <td><input name="user_level" type="text" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="add" id="submit" onclick="encryption();hash();" />
                <input type="reset" value="reset" />
            </td>
        </tr>
    </table>
</form>
<a href='administration.php'>back</a>
</body>
<script src="../../assets/js/sha256.js"></script>
<script src="../../assets/js/rsa.js"></script>
<script src="../../assets/js/des.js"></script>
<script src="../../assets/js/security.js"></script>

</html>
