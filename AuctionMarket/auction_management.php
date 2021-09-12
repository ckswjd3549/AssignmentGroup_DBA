<?php

if(!isset($_SESSION)) {
    session_start();
}
include_once("pdo_connect.php");

$_SESSION['UID'] = "";

function search_UID(){
    global $PDO;
    $id = ($_SESSION['id']);
    $password = ($_SESSION['password']);
    $result = $PDO->query("SELECT* FROM account");
   
    foreach ($result as $row){
        if($id === $row["Email"] && $password === $row["Password"]){
            
            $_SESSION['UID'] = $row["UID"];
            break;         
        }

        else if($id === $row["Phone"] && $password === $row["Password"]){
           
            $_SESSION['UID'] = $row["UID"];
                break;
        }
    }   
}


function create_auction(){

    global $PDO;

    $uid = ($_SESSION['UID']);
    $product = ($_POST['Product']);
    $amount = ($_POST['Amount']);
    $closing_time = ($_POST['Closing_time']);
    $_SESSION['amount_check'] = false;
    $message = "";  


    $amountNum = (int)$amount;
    if($amountNum != 0){
        $_SESSION['amount_check'] = true;
    }
    else 
        $message = "Please enter only number that upper than 0";
        echo $message;
        sleep(3);
        echo "<meta http-equiv='refresh' content='3;url=user_page.php?'>";
    
    if($_SESSION['amount_check'] == true){
    $insert = $PDO -> prepare("INSERT INTO auction(`UID`, `Product`, `Amount`,`Closing_time`)
    VALUES(:uid, :product , :amount, :closing_time)");
    $insert -> execute(
        [
            ':uid' => $uid,
            ':product' => $product,
            ':amount' => $amount,
            ':closing_time' => $closing_time
        ]
        );
        $_SESSION['amount_check'] = false;
        $message ="auction created";
        sleep(3);
        echo "<meta http-equiv='refresh' content='3;url=user_page.php?'>";
    }


}

function read_auction_user(){

   
    global $PDO;
    $uid = ($_SESSION['UID']);

    $select = $PDO->prepare("SELECT * FROM auction where UID =:uid");
    $select ->execute(
        [
            ':uid' => $uid
        ]
        );
    
    if($select -> rowCount() >0){
    echo `<table class=’table table-hover’><tr>`;
    ?> <h1> Your auction requests</h1> <?php
    foreach($select as $row) : ?>

    <style>
    table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    }
    </style>

    <table>
        <tr>
            <th>AID</th>
            <th>Product</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date_created</th>
            <th>Closing_time</th>
            <th>Ongoing</th>
        </tr>

        <tr>
            <td><?php echo $row['AID']; ?></td>
            <td><?php echo $row['Product']; ?></td>
            <td><?php echo $row['Amount']; ?></td>
            <td><?php echo $row['Status']; ?></td>
            <td><?php echo $row['Date_created']; ?></td>
            <td><?php echo $row['Closing_time']; ?></td>
            <td><?php echo $row['Ongoing']; ?></td>

        </tr>

    </table>

    <?php endforeach;?>
    <h1> Status's number means <br>
        1= Waiting confirm <br>
        2= Request accepted <br>
        3= Request dinied <br>
    </h1>
    <?php
    }
    else echo "No request exists";
}

function read_auction_admin(){

   
    global $PDO;

    $select = $PDO->prepare("SELECT * FROM auction");
    $select ->execute();
    
    if($select -> rowCount() >0){
    echo `<table class=’table table-hover’><tr>`;
    foreach($select as $row) : ?>

    <style>
    table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    }
    </style>

    <table>
        <tr>
            <th>AID</th>
            <th>UID</th>
            <th>Product</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date_created</th>
            <th>Closing_time</th>
            <th>Latest_bidder</th>
            <th>Ongoing</th>
        </tr>

        <tr>
            <td><?php echo $row['AID']; ?></td>
            <td><?php echo $row['UID']; ?></td>
            <td><?php echo $row['Product']; ?></td>
            <td><?php echo $row['Amount']; ?></td>
            <td><?php echo $row['Status']; ?></td>
            <td><?php echo $row['Date_created']; ?></td>
            <td><?php echo $row['Closing_time']; ?></td>
            <td><?php echo $row['Latest_bidder']; ?></td>
            <td><?php echo $row['Ongoing']; ?></td>

        </tr>

    </table>

    <?php endforeach;?>
    <h1> Status's number means <br>
        1= auction ongoing <br>
        2= auction confirmed <br>
        3= auction cancelled <br>
    </h1>
    <?php
    }
    else echo "No request exists";
}





function update_auction(){
    global $PDO;
    $aid = ($_POST['aid']);
    $status = ($_POST['status']);

   
    
    $select = $PDO->prepare("SELECT * FROM auction");
    $select ->execute();
    
    
     $message = "AID doesn't exist";
    foreach ($select as $row){
        if($aid == $row["AID"] ){
        
            $_SESSION['AID_exist'] = true;
            break;
            }
            else $_SESSION['AID_exist'] = false;

        }

 
        
    if($_SESSION['AID_exist']== true){
        $statNum = (int)$status;
        if($statNum > 0 && $statNum <= 3){
            $sth =$PDO->prepare("UPDATE auction set Status = :status where AID = :aid");
             $sth->execute(
            [
            ':status' => $status,
            ':aid' => $aid
            ]
            );
            unset($_SESSION['AID_exist']);
   
            echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
        }
        else{
            $message = "Please enter only 1 or 2 or 3 on status";
            echo $message;
            sleep(3);
            unset($_SESSION['AID_exist']);
            echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
        }
    }
    else  if($_SESSION['AID_exist'] == false){
        echo $message;
        sleep(3);
        unset($_SESSION['AID_exist']);
        echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
    }

        
        
  
    
}
function delete_auction(){


    global $PDO;
    extract($_POST);
    $delete = $PDO->query("DELETE FROM auction where AID = " . $aid);
  

}



## CRUD of Auction in progress

function read_auction_progress(){

   
    global $PDO;
    $sort = '';
    if(array_key_exists('amount_asc',$_POST)){
        $sort = 'amount_asc';
    }
    else if(array_key_exists('amount_desc',$_POST)){
        $sort = 'amount_desc';
    }
    else if(array_key_exists('time_asc',$_POST)){
        $sort = 'time_asc';
    }
    else if(array_key_exists('time_desc',$_POST)){
        $sort = 'time_desc';
    }
    else if(array_key_exists('count_asc',$_POST)){
        $sort = 'count_asc';
    }
    else if(array_key_exists('count_desc',$_POST)){
        $sort = 'count_desc';
    }
 

    switch ($sort){
        case 'amount_asc':
            $select = $PDO->prepare("SELECT * FROM auction where Ongoing = true ORDER BY Amount ASC");
            $select ->execute();
            break;
        case 'amount_desc':
            $select = $PDO->prepare("SELECT * FROM auction where Ongoing = true ORDER BY Amount DESC");
            $select ->execute();
            break;
        case 'time_asc':
            $select = $PDO->prepare("SELECT * FROM auction where Ongoing = true ORDER BY Closing_time ASC");
            $select ->execute();
            break;
        case 'time_desc':
            $select = $PDO->prepare("SELECT * FROM auction where Ongoing = true ORDER BY Closing_time DESC");
            $select ->execute();
            break;
        case 'count_asc':
            $select = $PDO->prepare("SELECT * FROM auction where Ongoing = true ORDER BY Bid_count ASC");
            $select ->execute();
            break;
        case 'count_desc':
            $select = $PDO->prepare("SELECT * FROM auction where Ongoing = true ORDER BY Bid_count DESC");
            $select ->execute();
            break;
        default: $select = $PDO->prepare("SELECT * FROM auction where Ongoing = true ");
                 $select ->execute();
    }

    


    if($select -> rowCount() >0){
    echo `<table class=’table table-hover’><tr>`;
    ?> <h1> Current available auction</h1>
    <?php
    foreach($select as $row) : ?>

    <style>
    table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    }
    </style>

    <table>
        <tr>
            <th>AID</th>
            <th>UID</th>
            <th>Product</th>
            <th>Amount</th>
            <th>Bid_count</th>
            <th>Date_created</th>
            <th>Closing_time</th>
            <th>Latest_bidder</th>
        </tr>

        <tr>
            <td><?php echo $row['AID']; ?></td>
            <td><?php echo $row['UID']; ?></td>
            <td><?php echo $row['Product']; ?></td>
            <td><?php echo $row['Amount']; ?></td>
            <td><?php echo $row['Bid_count']; ?></td>
            <td><?php echo $row['Date_created']; ?></td>
            <td><?php echo $row['Closing_time']; ?></td>
            <td><?php echo $row['Latest_bidder']; ?></td>

        </tr>

    </table>

    <?php endforeach;

    }
    else echo "No auction in progress exists";
}


function display_bidlist(){
    global $PDO;
    $uid =  $_SESSION['UID']; 
    
    $select = $PDO -> prepare("SELECT * FROM bidlist WHERE UID = :uid");
    $select -> execute(
        [
            ':uid' => $uid
        ]
    );
    if($select -> rowCount() >0){
        foreach($select as $row) : ?>

            <style>
            table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            }
            </style>
        
            <table>
                <tr>
                    <th>BID</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>AID</th>
                    <th>Date_created</th>
                </tr>
        
                <tr>
                    <td><?php echo $row['BID']; ?></td>
                    <td><?php echo $row['Product']; ?></td>
                    <td><?php echo $row['Amount']; ?></td>
                    <td><?php echo $row['AID']; ?></td>
                    <td><?php echo $row['date_created']; ?></td>
        
                </tr>
        
            </table>
        
            <?php endforeach;
            
    }
    else echo "You've never bid";
}

function display_winlist(){
    global $PDO;
    $uid =  $_SESSION['UID']; 
    $select = $PDO -> prepare("SELECT * FROM auction WHERE Ongoing = false And Latest_bidder =:uid");
    $select -> execute(
        [
            ':uid' => $uid
        ]
    );
    if($select -> rowCount() >0){
        foreach($select as $row) : ?>
        <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
        </style>
    
        <table>
            <tr>
                <th>AID</th>
                <th>Product</th>
                <th>Amount</th>
                <th>Bid_count</th>
                <th>Date_created</th>
                <th>Closing_time</th>
            </tr>
    
            <tr>
                <td><?php echo $row['AID']; ?></td>
                <td><?php echo $row['Product']; ?></td>
                <td><?php echo $row['Amount']; ?></td>
                <td><?php echo $row['Bid_count']; ?></td>
                <td><?php echo $row['Date_created']; ?></td>
                <td><?php echo $row['Closing_time']; ?></td>
    
            </tr>
    
        </table>
    
        <?php endforeach;}
        else echo "You've never won a bid";
    }

### bid progress
function bid_auction_progress(){
    global $PDO;
    
    $aid = $_POST['aid'];
    $uid =  $_SESSION['UID']; 
    $amount = $_POST['amount'];


    $select = $PDO -> prepare("SELECT * FROM auction WHERE AID = :aid");
    $select -> execute(
        [
            ':aid' => $aid
        ]
    );

    if($select -> rowCount() >0){
        foreach ($select as $row){
            if($row['Ongoing'] == true){
            $product = $row['Product'];
            $minimum_amount = $row['Amount'];
            }
            else{ 
                echo "Auction is not in progress";
                sleep(3);
                echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
            }
        }
    }
    
    $select2 = $PDO -> prepare("SELECT Balance FROM account WHERE UID = :uid");
    $select2 -> execute(
        [
            ':uid' => $uid
        ]
    );



    if(!$product == null){
        $amountNum = (float)$amount;
        $minimumNum = (float)$minimum_amount;
        if(!($amountNum <= $minimumNum)){
            $_SESSION['amount_check'] = true;
        }
        else{
            $message = "Please enter only number that upper than Auction amount";
            echo $message;
            sleep(3);
            echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
        }
    }
    else {
        echo "AID doesn't exitst";
        sleep(3);
        echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
    }

    if($_SESSION['amount_check'] == true){
        $add_bid = $PDO -> prepare(
            "INSERT INTO bidlist(`UID`, `Product`, `Amount`,`AID`) 
            VALUES(:uid, :product, :amount, :aid)");
        $add_bid -> execute(
            [
            ':uid' => $uid, 
            ':product' => $product, 
            ':amount' => $amount,
            ':aid' => $aid
            ]
            );
        $update_auction1 = $PDO -> prepare("UPDATE auction set Amount = :amount where AID = :aid;");
        $update_auction1 -> execute(
            [
                ':amount' => $amountNum, 
                ':aid' => $aid  
            ]
            );
        $update_auction2 = $PDO -> prepare("UPDATE auction set Latest_bidder = :uid where AID = :aid;");
        $update_auction2 -> execute(
                [
                    ':uid' => $uid, 
                    ':aid' => $aid  
                ]
                );
        $update_auction3 = $PDO -> prepare("UPDATE auction set Bid_count = Bid_count + 1 where AID = :aid;");
        $update_auction3 -> execute(
                [
                    ':aid' => $aid  
                ]
                );
        $_SESSION['amount_check'] = false;
        echo "Successfully bidded";
        sleep(3);
        echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
            


        
    }
}

function start_auction_progress(){
    global $PDO;

    $aid = $_POST['aid'];
    $select = $PDO->prepare("SELECT * FROM auction where Ongoing = FALSE And AID = :aid;");
    $select ->execute(
        [
            ':aid' => $aid
        ]
    );
    if($select -> rowCount() >0){
        $update = $PDO->prepare("UPDATE auction set Ongoing = TRUE WHERE AID = :aid;");
        $update ->execute(
            [
                ':aid' => $aid
            ]
            );
            echo "updated";
            unset($_POST['aid']);
        }
        
    else {
        echo "Auction doesn't exists or is already ongoing";
        unset($_POST['aid']);
    }
}


function close_auction_progress(){
    global $PDO;

    $aid = $_POST['aid'];
    $select = $PDO->prepare("SELECT * FROM auction where Ongoing = TRUE And AID = :aid;");
    $select ->execute(
        [
            ':aid' => $aid
        ]
    );
    if($select -> rowCount() >0){
        foreach ($select as $row){
            $winnerID = $row['Latest_bidder'];
            $auctionBalacne = $row['Amount'];
            $auctioneerID = $row['UID'];
        }
    
    ###
    $PDO->beginTransaction();
    try {
           
        
        $PDO -> exec('LOCK TABLES  account WRITE, auction WRITE, transaction WRITE;');
        $winBalance = $PDO -> prepare("SELECT Balance from account WHERE UID = :winID;");
        $winBalance -> execute(
            [
                ':winID' => $winnerID
            ]
            );
        $deposit = $PDO ->prepare("UPDATE account SET Balance = Balance + :au_bal WHERE UID = :auctionID;");
        $deposit -> execute(
            [
            ':au_bal' => $auctionBalacne,
            ':auctionID' => $auctioneerID
            ]
            );

        
        $withdraw = $PDO ->prepare("UPDATE account SET Balance = Balance - :au_bal WHERE UID = :winID;");
        $withdraw -> execute(
            [
                ':au_bal' => $auctionBalacne,
                ':winID' => $winnerID
            ]
            );
        $update = $PDO->prepare("UPDATE auction set Ongoing = FALSE WHERE AID = :aid;");
        $update ->execute(
            [
                ':aid' => $aid
            ]
            );

        $insert = $PDO-> prepare("INSERT INTO transaction(`Deposit_UID`, `Recipent_UID`, `Amount`)
        VALUES(:winId, :AuID, :amount)");
        $insert ->execute(
            [
                ':winId' => $winnerID,
                ':AuID' => $auctioneerID,
                ':amount' => $auctionBalacne
            ]
            );
        echo "updated"; 
        unset($_POST['aid']);
        $PDO ->exec("UNLOCK TABLES;"); 
        $PDO ->commit();  
    } catch(Exception  $e) { 
            $PDO->rollBack();
            echo "Failed: " . $e->getMessage();
        } 
    }
    else {
        echo "Auction doesn't exists or is not ongoing";
        unset($_POST['aid']);
    }
}


function read_transaction(){
    global $PDO;
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $select = $PDO->prepare("SELECT * FROM transaction where date_created > :start_time && date_created < :end_time;");
    $select ->execute(
        [
            ':start_time' => $start_time,
            ':end_time' => $end_time
        ]
    );
    if($select -> rowCount() >0){
        echo `<table class=’table table-hover’><tr>`;
        foreach($select as $row) : ?>
    
        <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
        </style>
    
        <table>
            <tr>
                <th>TID</th>
                <th>Deposit_UID</th>
                <th>Recipent_UID</th>
                <th>Amount</th>
                <th>date_created</th>
            </tr>
    
            <tr>
                <td><?php echo $row['TID']; ?></td>
                <td><?php echo $row['Deposit_UID']; ?></td>
                <td><?php echo $row['Recipent_UID']; ?></td>
                <td><?php echo $row['Amount']; ?></td>
                <td><?php echo $row['date_created']; ?></td>
    
            </tr>
    
        </table>
    
        <?php endforeach;
    } else{
        echo "No result exists between the two time zones";
        sleep(3);
        echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
    }
}  

function undo_transaction(){
    global $PDO;
    $tid = $_POST['tid'];
    $select = $PDO->prepare("SELECT * FROM transaction where TID = :tid;");
    $select ->execute(
        [
            ':tid' => $tid
        ]
        );
    if($select -> rowCount() >0){
        foreach($select as $row){
            $Deposit_UID = $row['Deposit_UID'];
            $Recipent_UID = $row['Recipent_UID'];
            $amount = $row['Amount'];
        }
    $deposit = $PDO ->prepare("UPDATE account SET Balance = Balance + :au_bal WHERE UID = :depositID;");
    $deposit -> execute(
            [
            ':au_bal' => $amount,
            ':depositID' => $Deposit_UID
            ]
            );

        
    $withdraw = $PDO ->prepare("UPDATE account SET Balance = Balance - :au_bal WHERE UID = :recipentID;");
    $withdraw -> execute(
            [
                ':au_bal' => $amount,
                ':recipentID' => $Recipent_UID
            ]
            );
    
    } else{
        echo "Transaction doesn't exist";
        sleep(3);
        echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
    }
}

    

?>