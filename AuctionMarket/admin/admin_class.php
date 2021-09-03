<?php
session_start();
ini_set('display_errors', 1);
Class Action {
    private $db;

    public function __construct() {
        ob_start();
        include 'pdo_connect.php';
        global $pdo;

        $this->db = $pdo;
    }
    function __destruct() {
        $this->db->close();
        ob_end_flush();
    }

    function login(){

        extract($_POST);
        $qry = $this->db->query("SELECT * FROM account where email = '".$email."'or phone = '".$phone."' and password = '".md5($password)."' ");
        if($qry->num_rows > 0){
            foreach ($qry->fetch_array() as $key => $value) {
                if($key != 'passwors' && !is_numeric($key))
                    $_SESSION['login_'.$key] = $value;
            }
            if($_SESSION['login_type'] != 1){
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                return 2 ;
                exit;
            }
            return 1;
        }else{
            return 3;
        }
    }
    function login2(){

        extract($_POST);
        $qry = $this->db->query("SELECT * FROM account where email = '".$email."'or phone = '".$phone."' and password = '".md5($password)."' ");
        if($qry->num_rows > 0){
            foreach ($qry->fetch_array() as $key => $value) {
                if($key != 'passwors' && !is_numeric($key))
                    $_SESSION['login_'.$key] = $value;
            }
            if($_SESSION['login_type'] == 1){
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                return 2 ;
                exit;
            }
            return 1;
        }else{
            return 3;
        }
    }
    function logout(){
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        header("location:login.php");
    }
    function logout2(){
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        header("location:../index.php");
    }

    function save_user(){
        extract($_POST);
        $data = " name = '$name' ";
        $data .= ", email = '$email' ";
        $data .= ", phone = '$phone' ";
        if(!empty($password))
            $data .= ", password = '".md5($password)."' ";
        $data .= ", type = '$type' ";
        if($type == 1)
            $establishment_id = 0;
        $chk = $this->db->query("SELECT * FROM account where email = '".$email."'or phone = '".$phone."' and id !='$id' ")->num_rows;
        if($chk > 0){
            return 2;
            exit;
        }
        if(empty($id)){
            $save = $this->db->query("INSERT INTO account set ".$data);
        }else{
            $save = $this->db->query("UPDATE account set ".$data." where id = ".$id);
        }
        if($save){
            return 1;
        }
    }
    function delete_user()
    {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM account where id = " . $id);
        if ($delete)
            return 1;
    }
    function update_account(){
        extract($_POST);
        $data = " name = '".$firstname.' '.$lastname."' ";
        $data .= ", username = '$email' " or ", username = '$phone'";
        if(!empty($password))
            $data .= ", password = '".md5($password)."' ";
        $chk = $this->db->query("SELECT * FROM account where username = '$email' and id != '{$_SESSION['login_id']}' ")->num_rows;
        if($chk > 0){
            return 2;
            exit;
        }
        $save = $this->db->query("UPDATE account set $data where id = '{$_SESSION['login_id']}' ");
        if($save){
            $data = '';
            foreach($_POST as $k => $v){
                if($k =='password')
                    continue;
                if(empty($data) && !is_numeric($k) )
                    $data = " $k = '$v' ";
                else
                    $data .= ", $k = '$v' ";
            }
            if($_FILES['img']['tmp_name'] != ''){
                $fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
                $move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
                $data .= ", avatar = '$fname' ";

            }
        }
    }

    function save_settings(){
        extract($_POST);
        $data = " code = '".str_replace("'","&#x2019;",$code)."' ";
        $data .= ", name = '$name' ";
        $data .= ", address = '$address' ";
        $data .= ", hotline_number = '$hotline_number' ";

        // echo "INSERT INTO system_settings set ".$data;
        $chk = $this->db->query("SELECT * FROM branch");
        if($chk->num_rows > 0){
            $save = $this->db->query("UPDATE branch set ".$data);
        }else{
            $save = $this->db->query("INSERT INTO branch set ".$data);
        }
        if($save){
            $query = $this->db->query("SELECT * FROM branch limit 1")->fetch_array();
            foreach ($query as $key => $value) {
                if(!is_numeric($key))
                    $_SESSION['system'][$key] = $value;
            }

            return 1;
        }
    }


    function save_category(){
        extract($_POST);
        $data = " name = '$name' ";
        if(empty($id)){
            $save = $this->db->query("INSERT INTO category set $data");
        }else{
            $save = $this->db->query("UPDATE category set $data where id = $id");
        }
        if($save)
            return 1;
    }
    function delete_category(){
        extract($_POST);
        $delete = $this->db->query("DELETE FROM category where id = ".$id);
        if($delete){
            return 1;
        }
    }
    function save_product(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k, array('id','img')) && !is_numeric($k)){
                if(empty($data)){
                    $data .= " $k='$v' ";
                }else{
                    $data .= ", $k='$v' ";
                }
            }
        }

        if(empty($id)){
            $save = $this->db->query("INSERT INTO product set $data");
            $id = $this->db->insert_id;
        }else{
            $save = $this->db->query("UPDATE product set $data where id = $id");
        }

        if($save){

            if($_FILES['img']['tmp_name'] != ''){
                $ftype= explode('.',$_FILES['img']['name']);
                $ftype= end($ftype);
                $fname =$id.'.'.$ftype;
                if(is_file('assets/uploads/'. $fname))
                    unlink('assets/uploads/'. $fname);
                $move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
                $save = $this->db->query("UPDATE product set image='$fname' where id = $id");
            }
            return 1;
        }
    }
    function delete_product(){
        extract($_POST);
        $delete = $this->db->query("DELETE FROM product where id = ".$id);
        if($delete){
            return 1;
        }
    }
    function get_latest_bid(){
        extract($_POST);
        $get = $this->db->query("SELECT * FROM bidding where product_id = $product_id order by amount desc limit 1 ");
        $bid = $get->num_rows > 0 ? $get->fetch_array()['bid_amount'] : 0 ;
        return $bid;
    }
    function save_bid(){
        extract($_POST);
        $data = "";
        $chk = $this->db->query("SELECT * FROM bidding where product_id = $product_id order by amount desc limit 1 ");
        $uid = $chk->num_rows > 0 ? $chk->fetch_array()['user_id'] : 0 ;
        foreach($_POST as $k => $v){
            if(!in_array($k, array('id')) && !is_numeric($k)){
                if(empty($data)){
                    $data .= " $k='$v' ";
                }else{
                    $data .= ", $k='$v' ";
                }
            }
        }
        $data .= ", user_id='{$_SESSION['login_id']}' ";

        if($uid == $_SESSION['login_id']){
            return 2;
            exit;
        }
        if(empty($id)){
            $save = $this->db->query("INSERT INTO bidding set ".$data);
        }else{
            $save = $this->db->query("UPDATE bidding set ".$data." where id=".$id);
        }
        if($save)
            return 1;
    }
}

