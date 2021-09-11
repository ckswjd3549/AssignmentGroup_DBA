<?php
include_once("pdo_connect.php");
include_once("account_management.php");
include_once("auction_management.php");

if($_SESSION['Loggedin'] != true){
    header('location: index.php');
}



## CRUD of Accuont

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
        <button type="submit" name="btn_update_ac">Submit</button>
    </form>
    <?php   
}
if(array_key_exists('delete_ac',$_POST)){
    ?>
    <form method="post">
        <input name="uid" type="text" placeholder="Enter the UID to delete">
        <button type="submit" name="btn_delete_ac">Submit</button>
    </form>
    
    <?php
}

if(array_key_exists('logout',$_POST)){
    $_SESSION['Loggedin'] = false;
    header('location: index.php');
}

if(array_key_exists('btn_delete_ac',$_POST)){

    delete_account();
    unset($_POST['uid']);
    var_dump($_POST);

}

if(array_key_exists('btn_update_ac',$_POST)){

    update_account();
}



## CRUD of auction

if(array_key_exists('read_au',$_POST)){
    search_UID();
    read_auction_admin();
}

if(array_key_exists('update_au',$_POST)){
    ?>
    <form method="post">
        <label for="aid">AID</label>
        <input name="aid" type="text" placeholder="Enter the AID to update"><br>
        <label for="status">Status</label>
        <input name="status" type="text" placeholder="Enter the number to update"><br>
        <button type="submit" name="btn_update_au">Submit</button>
    </form>
    <?php   
}

if(array_key_exists('btn_update_au',$_POST)){

    update_auction();
}

if(array_key_exists('delete_au',$_POST)){
    ?>
    <form method="post">
        <input name="aid" type="text" placeholder="Enter the AID to delete">
        <button type="submit" name="btn_delete_au">Submit</button>
    </form>
    
    <?php
}

if(array_key_exists('btn_delete_au',$_POST)){

    delete_auction();
    unset($_POST['aid']);
    var_dump($_POST);

}


## CRUD of Auction in progress

if(array_key_exists('read_ap',$_POST)){
    read_auction_progress();
}


//  var_dump($_POST);
//  var_dump($_SESSION);
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
        <input name="read_ac" type="submit" value="Read Account">
        <input name="update_ac" type="submit" value="Update Account">
        <input name="delete_ac" type="submit" value="Delete Account">
        <br>
        <input name="read_au" type="submit" value="Read exist auctions">
        <input name="update_au" type="submit" value="Update auction">
        <input name="delete_au" type="submit" value="Delete auction">
        <br>
        <input name="read_ap" type="submit" value="Read auctions in progress">
        <!-- <input name="read_au" type="submit" value="Read exist auctions">
        <input name="read_au" type="submit" value="Read exist auctions"> -->
        <input name="logout" type="submit" value="Logout">
   
    </form>

</body>
</html>
