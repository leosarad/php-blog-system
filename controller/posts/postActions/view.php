<?php
    session_start();
    require('../../dbConnect.php');

    $post_id=$_GET['id'];

    $sql = "UPDATE posts SET total_views=total_views+1 WHERE id=$post_id";
    if ($conn->query($sql)){
        $response['status'] = 200;
    } else {
        $response['status'] = 500;   
    }
    echo json_encode($response);
?>
