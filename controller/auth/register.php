<?php
    session_start();
    $name = $email = $pw = $rpw = "";

    $nameBool = $emailBool = $pwBool = false;

    // Form Validation 
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {
    
        // Email Validation
        if (empty($_POST["email"])) {
            $_SESSION['emailErr'] = "Email is Required";
        } else {
            $email = $_POST['email'];
            $email=test_input($email);
            
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                $_SESSION['emailErr'] = "Invalid email format";
              } else {
                  $emailBool=true;
              }
        }
        // Name Validation
        if (empty($_POST["name"])) {
            $_SESSION['nameErr'] = "Name is Required";
        } else {
            $name = $_POST['name'];
            $name=test_input($name);
            $nameBool=true;
        }

        //  Password Validation
        if (empty($_POST["password"])) {
            $_SESSION['pwErr'] = "Password is Required";
            if (empty($_POST["rpw"])) {
                $_SESSION['rpwErr'] = "Repeat Password is Required";
            }
        } else {
            $pw = $_POST['password_confirmation'];
            $pw=test_input($pw);
            if(!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/",$pw)){
                $_SESSION['pwErr'] = "Password format Worng";
            } else {
                if (empty($_POST["password_confirmation"])) {
                    $_SESSION['pwErr'] = "Confirm Password is Required";
                } else {
                    $rpw = $_POST['password_confirmation'];
                    $rpw=test_input($rpw);
                    if($pw==$rpw){
                        $pwBool=true;

                    } else {
                        $_SESSION['pwErr'] = "Confirm Password did not match.";
                    }
                }
            }
        }
        
        if ($emailBool && $pwBool && $nameBool){
            // Add Data to data base
            
            // $topic_interest = json_decode($_POST['selectedCateg']);
            
            if ( insertData($email,$pw,$name) ){
                $_SESSION['success'] = "Registered Successfully.";
            } else {
                $_SESSION['failure'] = "Failed to signup";
            }
        } 

        return header('location: ../../auth/register.php');
    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function insertData($email,$pw,$name){
        require "../dbConnect.php";
        $sql = "INSERT INTO users (`email`, `password`, `name` ) VALUES ('$email', '$pw', '$name')";
        if (mysqli_query($conn,$sql)){
            return true;
        } else {
            return false;
        }
    }
?>