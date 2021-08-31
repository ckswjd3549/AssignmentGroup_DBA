
<?php


include_once("pdo_connect.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="login.php" method="post">
        <p>ID</p>
        <input type="text" name="id" placeholder="Phone number or Email">
        <p>Password</p>
        <input type="text" name="password" placeholder="******">
        <br>
        <button id='login' type="submit" value="Login">Login</button>
        <button id='Register' type="button"><span><a href="register.php">Register</span></a></button>
    </form>

</body>
</html>


