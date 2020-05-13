<html>
<head>
    <title>user management system</title>
</head>
<body>
    <h3>add user</h3>
    <form id="add_user" name="add_user" method="post" action="action.php?action=add">
        <table>
            <tr>
                <td>user name</td>
                <td><input name="name" type="text"/></td>

            </tr>
            <tr>
                <td>password</td>
                <td><input name="password"/></td>
            </tr>
            <tr>
                <td>email</td>
                <td><input type="text" name="email"/></td>
            </tr>
            <tr>
                <td>payment_password</td>
                <td><input name="payment_password" type="text"/></td>
            </tr>
            <tr>
                <td>image file's name of avatar</td>
                <td><input name="avatar" type="text"/></td>
            </tr>
            <tr>
                <td>user_level (1 for user, 2 for merchant)</td>
                <td><input name="user_level" type="text"/></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="add"/>submit
                    <input type="reset" value="reset"/>reset
                </td>
            </tr>
        </table>

    </form>
</body>
</html>