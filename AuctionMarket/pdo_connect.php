<?php
 
  $host     = 'localhost'; // Host
  $database = 'testdb';  // DB Name
  $user     = 'root';      // DB Username
  $password = 'oracion1@';      // DB Password
 
  // Connect DB with PDO
  try {
    $PDO = new PDO('mysql:host='.$host.';charset=utf8',$user,$password);
    $PDO -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $PDO->query("CREATE DATABASE IF NOT EXISTS $database");
    $PDO->query("use $database");
    

  } catch(PDOException $Exception) {
    die('DB failed: '.$Exception->getMessage());
  }

 ?>

