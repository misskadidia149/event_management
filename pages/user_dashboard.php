<?php
session_start();
if (!isset($_SESSION['user_role'])|| $_SESSION['user_role'] !=='user') {
    header("Location:login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
</head>
<body>
    <h1>Bienvenue, User</h1>
</body>
</html>