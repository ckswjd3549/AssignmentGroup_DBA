<?php
include_once("pdo_connect.php");
include_once("account_management.php");
include_once("auction_management.php");

if($_SESSION['Loggedin'] != true){
    header('location: index.php');
}



// Auction requests


if(array_key_exists('read_au',$_POST)){
    search_UID();
    read_auction_user();
}

if(array_key_exists('create_au',$_POST)){

    ?>
    <form method="post">
        <label for="Product">Product</label>
        <input name="Product" type="text" placeholder="Enter the Product name"><br>
        <label for="Amount">Amount</label>
        <input name="Amount" type="text" placeholder="Enter the minimum amount of product"><br>
        <label for="Closing_time">Closing time</label>
        <input name="Closing_time" type="datetime-local"><br>
        <button type="submit" name="btn_create_au">Submit</button>
    </form>
    <?php   
}

if(array_key_exists('btn_create_au',$_POST)){
    search_UID();
    create_auction();

}


// Auction in progress

if(array_key_exists('read_ap',$_POST)){
    ?>
    <form  method="POST">
    <input name="amount_desc" type="submit" value="Sorts by highest price">
    <input name="amount_asc" type="submit" value="Sorts by lowest price">
    <br>
    <input name="time_desc" type="submit" value="Sorts by most time left"> 
    <input name="time_asc" type="submit" value="Sorts by least time left">
    <br>
    <input name="count_desc" type="submit" value="Sorts by highest bidding count">
    <input name="count_asc" type="submit" value="Sorts by lowest bidding count">
    <br>
    <input name="diplay" type="submit" value="Sorts by AID">
    </form>
    <?php
}
        

if(array_key_exists('diplay',$_POST)){
       read_auction_progress();
    }

    else if(array_key_exists('amount_asc',$_POST)){
        read_auction_progress();
    }
    else if(array_key_exists('amount_desc',$_POST)){
        read_auction_progress();
    }
    else if(array_key_exists('time_asc',$_POST)){
        read_auction_progress();
    }
    else if(array_key_exists('time_desc',$_POST)){
        read_auction_progress();
    }
    else if(array_key_exists('count_asc',$_POST)){
        read_auction_progress();
    }
    else if(array_key_exists('count_desc',$_POST)){
        read_auction_progress();
    }



if(array_key_exists('bid_ap',$_POST)){
    ?>
       <form method="post">
        <label for="aid">AID</label>
        <input name="aid" type="text" placeholder="Enter the AID to bid"><br>
        <label for="amount">Amount</label>
        <input name="amount" type="text" placeholder="Enter the amount to bid"><br>
        <button type="submit" name="btn_bid_ap">Submit</button>
    </form>
        <?php
    }

if(array_key_exists('btn_bid_ap',$_POST)){
    search_UID();
    bid_auction_progress();
    }
    




// Display information

if(array_key_exists('display_info',$_POST)){
    search_UID();
    display_info();
}

if(array_key_exists('display_bid',$_POST)){
    search_UID();
    display_bidlist();
}

if(array_key_exists('display_win',$_POST)){
    search_UID();
    display_winlist();

}

// Logout

if(array_key_exists('logout',$_POST)){
    $_SESSION['Loggedin'] = false;
    header('location: index.php');
}






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
    <form action="user_page.php" method="POST">
        <input name="read_au" type="submit" value="Read exist requests">
        <input name="create_au" type="submit" value="Create a new request">
        <br>
        <input name="read_ap" type="submit" value="Read auctions in progress">
        <input name="bid_ap" type="submit" value="Bid auction in progress">
        <br>
        <input name="display_bid" type="submit" value="Display personal bid list">
        <input name="display_win" type="submit" value="Display personal win list">
        <input name="display_info" type="submit" value="Display personal info">
        <input name="logout" type="submit" value="Logout">


    </form>

</body>
</html>
