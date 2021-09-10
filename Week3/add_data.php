<?php
require_once 'db.php';
global $dbh;

// add cities
$fp = fopen('au.csv', 'r');

// insert statement
$stmt = $dbh->prepare("INSERT INTO cities(name, lat, lng, capital, population) VALUES (?, ?, ?, ?, ?)");

// ignore first line
fgetcsv($fp);
while ($line = fgetcsv($fp)) {
    $name = $line[0];
    $lat = $line[1];
    $lng = $line[2];
    $capital = $line[5];
    $population = $line[7];

    $stmt->execute([$name, $lat, $lng, $capital, $population]);
}

// add people
$first = fopen('first.csv', 'r');
$last = fopen('last.csv', 'r');

// read all names
$first_arr = [];
while ($str = fgets($first, 50)) {
    $first_arr[] = $str;
}

$last_arr = [];
while ($str = fgets($last, 50)) {
    $last_arr[] = $str;
}

fclose($first);
fclose($last);

// insert statement
$stmt = $dbh->prepare("INSERT INTO people(first_name, last_name, birth_date, birth_location, current_location) VALUES (?, ?, ?, ?, ?)");

$dbh->beginTransaction();

// insert MAX people
$people_max = 100000;  // change this value according to your system
$count = 0;
$first_max = 5162;  // around 5K first names
$last_max = 88798;  // around 88K last names
$location_max = 1035;  // around 1305 cities
while ($count < $people_max) {
    $first_name = $first_arr[rand(0, $first_max)];
    $last_name = $last_arr[rand(0, $last_max)];
    $year = rand(1920, 2002);
    $month = rand(1, 12);
    $day = rand(1, 31);
    // some special cases (not all)
    if ($month == 2 && $day > 28) {
        $day = 28;
    }
    if ($day > 30 && in_array($month, [4, 6, 9, 11])) {
        $day = 30;
    }
    $birth = "$year-$month-$day";
    $birth_location = rand(1, $location_max);
    $current_location = rand(1, $location_max);

    $stmt->execute([$first_name, $last_name, $birth, $birth_location, $current_location]);
    $count++;
}

$dbh->commit();