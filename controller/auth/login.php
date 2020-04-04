<?php
    session_start();
    $email = $pw = "";

    $emailBool = $pwBool = false;

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if (empty($_POST["email"])) {
            $_SESSION['emailErr'] = "Email is required.";
        } else {
            $email = $_POST['email'];
            $email=test_input($email);
            
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                $_SESSION['emailErr'] = "Invalid email format.";
              } else {
                  $emailBool=true;
              }
        }

        if (empty($_POST["password"])) {
            $_SESSION['pwErr'] = "Password is required.";
        } else {
            $pw = $_POST['password'];
            $pw=test_input($pw);
            if(strlen($pw)<6){
                $_SESSION['pwErr'] = "Password length should be at least 6."; 
            } else {
                $pwBool=true;
            }
        }
        if ($emailBool && $pwBool){
            // Check Data From data base
            if ( authorize($email,$pw) ){
                $id=authorize($email,$pw);
                return header('location: ../../index.php');
            } else {
                $_SESSION['failure'] = "Email or Password did not match";
            }

        }
        return header('location: ../../auth/login.php');

    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function authorize($email, $pw){
        require "../dbConnect.php";
        $sql = "SELECT * FROM `users` where `email` = '$email' ";
        $result = mysqli_query($conn,$sql);
        if ( mysqli_num_rows($result) > 0 ){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['auth']=$row;
            if($row['password']==$pw)
                return $row['id'];
        } else {
            return false;
        }
    }

?>