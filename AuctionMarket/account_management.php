<?php
session_start();

include_once("pdo_connect.php");





function table(){
    
    global $PDO;
    $email = ($_POST['email']);
    $phone = ($_POST['phone']);
    $passwordR = ($_POST['password']);


    $sth = $PDO->prepare("INSERT INTO account VALUES(:email, :phone , :password)");
    $sth->execute([':email' => $email, ':phone' => $phone, ':password' => $passwordR]);


}

function ID_search(){
    global $PDO;
    $id = ($_POST['id']);
    $password = ($_POST['password']);
    $result = $PDO->query("SELECT * FROM account");
    $_SESSION['Loggedin'] = false;
    
    $message = "Id doesn't exist or wrong password";
    foreach ($result as $row){
        if($id === $row["email"] && $password === $row["password"]){
            $_SESSION['Loggedin'] = true;
            header('location: home.php');
            break;
        }
        else if($id === $row["phone"] && $password === $row["password"]){
                $_SESSION['Loggedin'] = true;
                header('location: home.php');
                break;
        }
    }   
    echo $message;
    // echo "<meta http-equiv='refresh' content='3;url=index.php?'>";
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

        // else if (empty ($_POST['password_check'])){
        //     echo $message;
        // }

        // else if (empty ($_POST['fname'])){
        //     echo $message;
        // }

        // else if (empty ($_POST['lname'])){
        //     echo $message;
        // }

        // else if (empty ($_POST['IDnum'])){
        //     echo $message;
        // }

        // else if (empty ($_POST['profile_pic'])){
        //     echo $message;
        // }

        // else if (empty ($_POST['address'])){
        //     echo $message;
        // }

        // else if (empty ($_POST['city'])){
        //     echo $message;
        // }

        // else if (empty ($_POST['country'])){
        //     echo $message;
        // }
        else return true;

    }


function ID_register(){
    $message ="";
    $email = ($_POST['email']);
    $phone = ($_POST['phone']);
    $passwordR = ($_POST['password']);
    $password_check = ($_POST['password_check']);
    // $fname = ($_POST['fname']);
    // $lname = ($_POST['lname']);

if (filter_var($email, FILTER_VALIDATE_EMAIL) != true) {
    $message = "Invalid Email";
    }   
    else if(is_numeric($phone) != true){
        $message = "Please enter only phone number(without - and whitespace)";
    }

    else if($passwordR != $password_check){
        $message = "Password and password confirmation do not match";
    }

    // else if((is_string($fname) && ($lname))){
    //     $message = "Please enter only Alphabet on name fileds";
    // }
    else  {
        $message = "success";
        $_SESSION['register_request'] = true;
    }

    echo $message;

}



?>
