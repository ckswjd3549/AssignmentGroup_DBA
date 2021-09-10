<?php

require_once 'db.php';
global $dbh;

$pass = password_hash('password', PASSWORD_DEFAULT);
$dbh->query("insert into users(username password) values('abc', $password)");

if (isset($_POST['act'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $stmt = $dbh->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row['password'])) {
        echo "<h2>Login successful. Welcome $username</h2>";
    } else {
        echo "<h2>Login failed.</h2>";
    }
}

?>

<form method="post">
    <div>
        <span>Username</span><br>
        <input type="text" name="username">
    </div>
    <div>
        <span>Password</span><br>
        <input type="password" name="password">
    </div>
    <div>
        <input type="submit" name="act" value="Login">
    </div>
</form>