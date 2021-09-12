<?php
 
  $host     = 'localhost'; // 호스트 주소
  $database = 'testdb';  // 데이터베이스 이름
  $user     = 'root';      // DB 유저이름
  $password = 'oracion1@';      // DB 패스워드
 
  // PDO방식 DB 연결
  try {
    $PDO = new PDO('mysql:host='.$host.';charset=utf8',$user,$password);
    $PDO -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $PDO->query("CREATE DATABASE IF NOT EXISTS $database");
    $PDO->query("use $database");
    

  } catch(PDOException $Exception) {
    die('DB failed: '.$Exception->getMessage());
  }

 ?>

