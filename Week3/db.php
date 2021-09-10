<?php
$user = 'root';
$pass = '123456';

global $dbh;

$dbh = new PDO('mysql:host=localhost;port=3307;dbname=citizen', $user, $pass);
//write the port if it doesn't work
