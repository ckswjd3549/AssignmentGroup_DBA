<?php

$user = 'root';
$password = '123456';

global $dbh;

$dbh = new PDO('mysql:host=localhost;port=3307;dbname=user_db', $user, $password);
