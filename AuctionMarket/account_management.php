<?php

if(!isset($_SESSION)) {
    session_start();
}

include_once("pdo_connect.php");







function delete_account(){


    global $PDO;
    extract($_POST);
    $delete = $PDO->query("DELETE FROM account where UID = " . $uid);
  

}

function update_account(){
    global $PDO;
    $uid = ($_POST['uid']);
    $coulmn = ($_POST['coulmn']);
    $value = ($_POST['value']);

    $result = $PDO->query("SELECT* FROM account");
    $_SESSION['UID_coulmn_check'] = false;

    $message = "UID doesn't exist";
    foreach ($result as $row){
        if($uid == $row["UID"] ){
            if(isset($row[$coulmn])){
                $_SESSION['UID_coulmn_check'] = true;
                break;
            }   
            else 
            $message ="Coulmn doesn't exist";
            echo $message;
            echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
            break;
        
        }
    }


    $_SESSION['value_check'] = false;

    if($_SESSION['UID_coulmn_check'] == true){

        switch ($coulmn){
            case 'Email':
                if(filter_var($value, FILTER_VALIDATE_EMAIL) == true){
                    $_SESSION['value_check'] = true;
                    $_SESSION['UID_coulmn_check'] = false;
                    break;
                }
                else 
                    $message = "Please enter validate email";
                    echo $message;
                    $_SESSION['UID_coulmn_check'] = false;
                    echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
                    break;
            case 'Phone' :
                $valueNum = (int)$value;
                if($valueNum != 0){
                    $_SESSION['value_check'] = true;
                    $_SESSION['UID_coulmn_check'] = false;
                    echo($valueNum);    
                    break;
                }
                else 
                    $message = "Please enter only phone number(without - and whitespace)";
                    echo $message;
                    $_SESSION['UID_coulmn_check'] = false;
                    echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
                    break;
            case 'UID':
                $valueNum = (int)$value;
                if($valueNum != 0){
                    $_SESSION['value_check'] = true;
                    $_SESSION['UID_coulmn_check'] = false;  
                    break;
                }
                else 
                    $message = "Please enter only number that upper than 0";
                    echo $message;
                    $_SESSION['UID_coulmn_check'] = false;
                    echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
                    break;

            case 'Admin':
                $message = "You can not adjust admin";
                echo $message;
                $_SESSION['UID_coulmn_check'] = false;
                echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
                break;
                                    
        }
    }
    else 
    echo $message;
    echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";


    
    if($_SESSION['value_check']== true){
        $sth =$PDO->prepare("UPDATE account set $coulmn = :value where UID = :uid");
        $sth->execute(
            [
            ':value' => $value,
            ':uid' => $uid
            ]
        );
        $_SESSION['value_check'] = false;
        $message = "Information updated";
        echo $message;
        sleep(3);
        echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
    }
  
    
}


function read_account(){

    global $PDO;

    $select = $PDO->query("SELECT * FROM account");
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
            <th>UID</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Password</th>
            <th>First_name</th>
            <th>Last_name</th>
            <th>Id_num</th>
            <th>Address</th>
            <th>City</th>
            <th>Country</th>
            <th>Balance</th>
            <th>Admin</th>
        </tr>

        <tr>
            <td><?php echo $row['UID']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['Phone']; ?></td>
            <td><?php echo $row['Password']; ?></td>
            <td><?php echo $row['First_name']; ?></td>
            <td><?php echo $row['Last_name']; ?></td>
            <td><?php echo $row['Id_num']; ?></td>
            <td><?php echo $row['Address']; ?></td>
            <td><?php echo $row['City']; ?></td>
            <td><?php echo $row['Country']; ?></td>
            <td><?php echo $row['Balance']; ?></td>
            <td><?php echo $row['Admin']; ?></td>
        </tr>

    </table>

    <?php endforeach;
}


function add_account(){
    
    global $PDO;
    $email = ($_POST['email']);
    $phone = ($_POST['phone']);
    $passwordR = ($_POST['password']);
    $fname = ($_POST['fname']);
    $lname = ($_POST['lname']);
    $idnum = ($_POST['IDnum']);
    $address = ($_POST['address']);
    $city = ($_POST['city']);
    $country = ($_POST['country']);
    $balacne = 0;



    $sth = $PDO->prepare("INSERT INTO account(`email`, `phone`, `password`, `first_name`, `last_name`, `id_num`, `address`, `city`, `country`, `balance`)
         VALUES(:email, :phone , :password, :first_name, :last_name, :id_num, :address, :city, :country, :balance)");
    $sth->execute(
        [':email' => $email, 
        ':phone' => $phone, 
        ':password' => $passwordR,
        ':first_name' => $fname,
        ':last_name' => $lname,
        ':id_num' => $idnum,
        ':address' => $address,
        ':city' => $city,
        ':country' => $country,
        ':balance' => $balacne
        ]
    );


}

function ID_search(){
    global $PDO;
    $id = ($_POST['id']);
    $password = ($_POST['password']);
    $result = $PDO->query("SELECT* FROM account");
   
    
    $message = "Id doesn't exist or wrong password";
    foreach ($result as $row){
        if($id === $row["Email"] && $password === $row["Password"]){
            if($row["Admin"] == true){
                $_SESSION['Loggedin'] = true;
                $_SESSION['id'] = $id;
                $_SESSION['password'] = $password;
                header('location: admin_page.php');
                break;

            }
            $_SESSION['Loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['password'] = $password;
            header('location: user_page.php');

            break;
            
        }
        else if($id === $row["Phone"] && $password === $row["Password"]){
               
                if($row["Admin"] == true){
                    $_SESSION['Loggedin'] = true;
                    $_SESSION['id'] = $id;
                    $_SESSION['password'] = $password;
                    header('location: admin_page.php');
                    break;
                }
                $_SESSION['Loggedin'] = true;
                $_SESSION['id'] = $id;
                $_SESSION['password'] = $password;
                header('location: user_page.php');
                break;
        }
    }   
    echo $message;
    echo "<meta http-equiv='refresh' content='3;url=index.php?'>";
}


function Info_check(){
    $message ="Please filled all information";
    if(empty ($_POST['email'])){
            echo $message;
        }

        else if (empty ($_POST['phone'])){
            echo $message;
        }

        else if (empty ($_POST['password'])){
            echo $message;
        }

        else if (empty ($_POST['password_check'])){
            echo $message;
        }

        else if (empty ($_POST['fname'])){
            echo $message;
        }

        else if (empty ($_POST['lname'])){
            echo $message;
        }

        else if (empty ($_POST['IDnum'])){
            echo $message;
        }

        // else if (empty ($_POST['profile_pic'])){
        //     echo $message;
        // }

        else if (empty ($_POST['address'])){
            echo $message;
        }

        else if (empty ($_POST['city'])){
            echo $message;
        }

        else if (empty ($_POST['country'])){
            echo $message;
        }
        else return true;

    }


function ID_register(){
    $message ="";
    $email = ($_POST['email']);
    $phone = ($_POST['phone']);
    $passwordR = ($_POST['password']);
    $password_check = ($_POST['password_check']);
    $fname = ($_POST['fname']);
    $lname = ($_POST['lname']);

if (filter_var($email, FILTER_VALIDATE_EMAIL) != true) {
    $message = "Invalid Email";
    }   
    else if(is_numeric($phone) != true){
        $message = "Please enter only phone number(without - and whitespace)";
    }

    else if($passwordR != $password_check){
        $message = "Password and password confirmation do not match";
    }

    else if((!is_string($fname) && ($lname))){
        $message = "Please enter only Alphabet on name fileds";
    }
    else  {
        $message = "success";
        $_SESSION['register_request'] = true;
    }

    echo $message;

}


function display_info(){
    global $PDO;
    $uid = $_SESSION['UID'];
    $row = $PDO->prepare("SELECT* FROM account where UID = :uid");
    $row -> execute(
        [ 
            ':uid' => $uid
        ]
        );
    foreach ($row as $user) :?>

        <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
        </style>
    
        <table>
            <tr>
                <th>UID</th>
                <th>Balance</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Password</th>
                <th>First_name</th>
                <th>Last_name</th>
                <th>Address</th>
                <th>City</th>
                <th>Country</th>
            </tr>
    
            <tr>
                <td><?php echo $user['UID']; ?></td>
                <td><?php echo $user['Balance']; ?></td>
                <td><?php echo $user['Email']; ?></td>
                <td><?php echo $user['Phone']; ?></td>
                <td><?php echo $user['Password']; ?></td>
                <td><?php echo $user['First_name']; ?></td>
                <td><?php echo $user['Last_name']; ?></td>
                <td><?php echo $user['Address']; ?></td>
                <td><?php echo $user['City']; ?></td>
                <td><?php echo $user['Country']; ?></td>
    
            </tr>
    
        </table>
    
        <?php endforeach;
        
}

function update_user_balance(){
    global $PDO;
    $uid = $_POST['uid'];
    $amount = $_POST['amount'];

    $select = $PDO -> prepare("SELECT * FROM account WHERE UID = :uid");
    $select -> execute(
        [
            ':uid' => $uid
        ]
    );
    if($select -> rowCount() >0){
        $amountNum = (int)$amount;
        if($amountNum > 0){
        $update = $PDO -> prepare("UPDATE account set Balance = :amount where UID = :uid;");
        $update -> execute(
            [
                ':amount' => $amountNum,
                ':uid' => $uid
            ]
        );
    }
        else {
            $message = "Please enter only number that upper than 0";
            echo $message;
            sleep(3);
            echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
        }

    } else {
        $message = "Please enter only number that upper than 0";
        echo $message;
        sleep(3);
        echo "<meta http-equiv='refresh' content='3;url=admin_page.php?'>";
    }
}


?>
