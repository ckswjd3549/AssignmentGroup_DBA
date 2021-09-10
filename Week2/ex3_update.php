<?php
$user = 'root';
$pass = '123456';

global $dbh;

$pdo = new PDO('mysql:localhost; dbname=company', $user, $pass);
$stmt = $pdo->prepare("INSERT INTO DEPT_LOCATIONS(Dnumber, Dlocation) VALUES (:number, :location)");
$stmt->bindParam(':number', $num);

$stmt->bindParam(':location', $loc);

// Use real values when executing

$num = 1;

$loc = 'HCMC';

$stmt->execute();

// Execute one more time

$num = 2;

$loc = 'New York';

$stmt->execute();