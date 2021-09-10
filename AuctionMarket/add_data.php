<?php
require_once 'vendor/autoload.php';

$user = 'root';
$pass = '123456';

global $dbh;
$pdo = new PDO('mysql:localhost;port=3307;dbname=bidding_system', $user, $pass);

$description = "This phone is new version";
$image = "asdfasdfa";

//$description = "Wow enjoy this";
//$image = "asdfasdfad";

//Use prepared statement
$stmt = $pdo->prepare("INSERT INTO product_detail(description, image) VALUES (?, ?)");
$stmt->execute([$description, $image]);

$client = new MongoDB\Client('mongodb://localhost:27017');

$collection = $client->rmit->product;

$res = $collection->insertOne([
    'description'=>$description,
    'image'=>$image
]);

echo 'Done';

