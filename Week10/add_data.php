<?php
require_once 'vendor/autoload.php';

$user = 'root';
$pass = '123456';

global $dbh;
$pdo = new PDO('mysql:localhost;port=3307;dbname=bidding_system', $user, $pass);

$id = 1;
$name = 'laptop';
$price = 1001.2;
$attributes = ['screen' => 'fullHD', 'brand' =>'HP'];

//Use prepared statement
$stmt = $pdo->prepare("INSERT INTO product(id, name, price) VALUES (?,?,?)");
$stmt->execute([$id, $name, $price]);

$client = new MongoDB\Client('mongodb://localhost:27017');

$collection = $client->rmit->product;

$res = $collection->insertOne([
   '_id'=>$id,
    'attributes'=>$attributes
]);

echo 'Done';

//$document = $collection->find([]);
//
//foreach ($document as $one) {
//    echo 'ID : ' . $one['_id'] . '<br>';
//    echo 'Name : ' . $one['name'] . '<br>';
//    foreach ($one['hobbies'] as $key => $val) {
//        echo "$key : $val " . '<br>';
//    }
//    foreach ($one['job'] as $key => $val) {
//        echo "$key : $val " . '<br>';
//    }
//    if (isset($one['new_attribute'])) {
//        echo 'new_attribute : ' . $one['new_attribute'] . '<br>';
//    }
//    if (isset($one['new_attribute_123'])) {
//        echo 'new_attribute_123 : ' . $one['new_attribute_123'] . '<br>';
//    }
//
//    echo '<hr>';
//}

/*
$res = $collection->insertOne([
  '_id' => '3',
  'name' => 'Dang 3',
  'hobbies' => ['Java 3', 'PHP 3', 'Database 3'],
  'job' => ['title' => 'Developer', 'place' => 'Google', 'from' => '2010' ]
]);
var_dump($res);
*/

/*
$res = $collection->updateOne(
  ['_id' => '3'],
  [
    '$set' => [
      'name' => 'Dang 2',
      'hobbies' => ['Java 2', 'PHP 2', 'Database 2'],
      'job' => ['title' => 'Developer 2', 'place' => 'Google 2', 'from' => '2010 2'],
      'new_attribute_123' => 123
    ]
  ]
);
var_dump($res);
*/