<?php
// Update user and password variables according to your system configuration
$user = 'root';
$pass = '123456';

global $dbh;

$pdo = new PDO('mysql:host=localhost;dbname=company', $user, $pass);

$rows = $pdo->query('SELECT Fname, Lname FROM EMPLOYEE ORDER BY Fname');
echo '<ul>';
foreach ($rows as $row) {

    echo $row['Fname'] . ' ' . $row['Lname'] . '<br>';

}

?>



<p><a href="ex2_update.php">Update a department name here</a></p>


