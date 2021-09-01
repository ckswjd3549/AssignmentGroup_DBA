<?php


include_once("pdo_connect.php");
include_once("account_management.php");



var_dump($_POST);


// function ID_validator() {
// if (filter_var($id, FILTER_VALIDATE_EMAIL)) {
//     $ID_types = "email";}
//     else if(is_numeric($id)){
//         $ID_types = "phone";
//     }
//     else echo "Please enter valid email address or phone number(without - and whitespace)";
// };



ID_search();

var_dump($_SESSION);




	
?>
