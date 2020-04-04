<?php
    session_start();
    require('../dbConnect.php');
    $post_id = $_GET['id'];
    $findQuery = "SELECT user_id FROM posts WHERE id=".$post_id;
    $result = mysqli_query($conn,$findQuery);
    if ( mysqli_num_rows($result) > 0 ){
        $row= mysqli_fetch_assoc($result);
        if($row['user_id']==$_SESSION['auth']['id']){
            $deleteQuery = "DELETE FROM `posts` WHERE id=".$post_id;
            $result = mysqli_query($conn,$deleteQuery);
            if($result){
                $_SESSION['success']="Post Deleted Successfully.";
                return header("Location: ../../dashboard.php");
            } else {
                $_SESSION['failure']="Post Deletion Failed.";
                return header("Location: ../../dashboard.php");
            }
        } else {
            $_SESSION['failure']="User Not Auhtorized";
            return header("Location: ../../index.php");
        }
        
    } 
?>