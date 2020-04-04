<?php
    session_start();
    require('../../dbConnect.php');

    if(isset($_SESSION['auth']) ){
        
        $response['data'] = ["",""];

        $post_id=$_GET['id'];
        $user_id=$_SESSION['auth']['id'];
        $comment = test_input($_POST['comment']);
        
        $sql = "INSERT INTO comments (user_id,post_id,comment) VALUES ('$user_id', '$post_id', '$comment')";

        if ($conn->query($sql) == TRUE) { 
            $sql = "UPDATE posts SET total_comments=total_comments+1 WHERE id=$post_id";
            $conn->query($sql);
            $response['status'] = 200;
            $response['data'] = [$_SESSION['auth']['name'],$comment];
        } else {
            $response['status'] = 500;   
        }
        
    } else {
        $response['status'] = 400;   
    }
    echo json_encode($response);

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    
?>
