<?php
    session_start();
    require('../../dbConnect.php');

    $post_id=$_GET['id'];
        if(isset($_SESSION['auth']) ){
            $likes = getLikes($post_id);
            if(!userLiked($likes)){
                $user_id=$_SESSION['auth']['id'];
                $sql = "INSERT INTO likes (user_id,post_id) VALUES ('$user_id', '$post_id')";

                if ($conn->query($sql) == TRUE) { 
                    $sql = "UPDATE posts SET total_likes=total_likes+1 WHERE id=$post_id";
                    $conn->query($sql);
                    $response['status'] = 200;
                } else {
                    $response['status'] = 500;   
                }
            } else {
                $response['status'] = 400;   
            }
            
        } else {
            $response['status'] = 400;   
        }
        echo json_encode($response);

        function getLikes($post_id){
            $query = "SELECT * FROM likes WHERE post_id=$post_id";
            $result = mysqli_query($GLOBALS['conn'],$query);
            if ( mysqli_num_rows($result) > 0 ){
                $rows= mysqli_fetch_all($result,1);
                return $rows;
            } else {
                return [];
            }
        }
        
        function userLiked($likes){
            if(count($likes)>0){
                foreach($likes as $like){
                    if($like['user_id']==$_SESSION['auth']['id']){
                        return true;
                    } 
                }
            }
            return false;
        }
?>
