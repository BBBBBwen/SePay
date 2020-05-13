<?php require_once "../../content/connect_database.php"; ?>
<html>

<head>
    <meta charset="UTF-8">
    <title>user management system</title>
    <script>
        function doDel(id, level) {
            if (confirm("confirm")) {
                window.location = 'action.php?action=del&id=' + id + '&level=' + level;
            }
        }
    </script>
</head>

<title>User List</title>

<?php
$pageSize = 10;
$rowCount = 0;
$curr_page = 1;


if (!empty($_GET['pageNow'])) {
    $pageNow = $_GET['pageNow'];
}

$pageCount = 0;


$sql = "select count(*) from users where user_level = :user_level";
$stmt = $db->prepare($sql);
$stmt->bindValue(':user_level', $_GET['level']);
$stmt->execute();
$row = $stmt->fetchColumn();
if ($row > 0) $rowCount = $row;

$pageCount = ceil($rowCount / $pageSize);

$sql = "select * from users where user_level != 0 limit " . ($curr_page - 1) * $pageSize . "," . $pageSize;
$stmt = $db->prepare($sql);
$stmt->execute();
echo "<table>";

echo "<tr><th>user_id</th><th>user_name</th><th>user_email</th><th>user_level</th><th>registration_date</th><th>modify</th><th>delete</th></tr>";

//循环显示用户的信息
$level = '';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($row['user_level'] == 1)
        $level = 'Merchant';
    else
        $level = 'User';
    echo "<tr><td>{$row['id']}</td><td>{$row['username']}</td><td>{$row['email']}</td><td>{$level}</td><td>{$row['reg_date']}</td>" .
        "<td><a href='edit_user.php?id={$row['id']}'>edit</a></td><td><a href='javascript:doDel({$row['id']},{$row['user_level']})'>delete</a></td></tr>";
}


echo "<h1>user list</h1>";
echo "</table>";

for ($i = 1; $i <= $pageCount; $i++) {
    echo "<a href='user_management.php?level=".$_GET['level']."&curr_page=".$i."'>".$i."</a>";
}

?>

</html>