<?php
include_once("pdo_connect.php");
include_once("account_management.php");

if($_SESSION['Loggedin'] != true){
    header('location: index.php');
}



var_dump($_SESSION);


if(array_key_exists('read_ac',$_POST)){
     read_account();
}
if(array_key_exists('update_ac',$_POST)){
    ?>
    <form method="post">
        <label for="uid">UID</label>
        <input name="uid" type="text" placeholder="Enter the UID to update"><br>
        <label for="coulmn">Coulmn</label>
        <input name="coulmn" type="text" placeholder="Enter the coulmm to update"><br>
        <label for="value">Value</label>
        <input name="value" type="text" placeholder="Enter the value to update"><br>
        <button type="submit" name="btn_update">Submit</button>
    </form>
    <?php   
}
if(array_key_exists('delete_ac',$_POST)){
    ?>
    <form method="post">
        <input name="uid" type="text" placeholder="Enter the UID to delete">
        <button type="submit" name="btn_delete">Submit</button>
    </form>
    
    <?php
}

if(array_key_exists('logout',$_POST)){
    $_SESSION['Loggedin'] = false;
    header('location: index.php');
}

if(array_key_exists('btn_delete',$_POST)){

    delete_account();
    unset($_POST['id']);
    var_dump($_POST);

}

if(array_key_exists('btn_update',$_POST)){

    update_account();

}


 var_dump($_POST);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="admin_page.php" method="POST">
        <input name="read_ac" type="submit" value="Read_Account">
        <input name="update_ac" type="submit" value="Update_Account">
        <input name="delete_ac" type="submit" value="Delete_Account">
        <input name="logout" type="submit" value="Logout">
    </form>

</body>
</html>
