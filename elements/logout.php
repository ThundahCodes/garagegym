<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("location:../login.php");
    exit();
}
else {
    session_unset();
    header("location:../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>

</body>
</html>