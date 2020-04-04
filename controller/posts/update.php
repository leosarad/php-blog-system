<?php
session_start();
$title_check = $content_check = $thumbnail_check = false;
$title = $thumbnail =  $content = "";
require_once("../dbConnect.php");

    $post_id = $_GET['id'];
    $findQuery = "SELECT * FROM posts WHERE id='$post_id'";
    $post = executeQuery($findQuery);

    function executeQuery($query){
        $result = mysqli_query($GLOBALS['conn'],$query);
        if ( mysqli_num_rows($result) > 0 ){
            $row= mysqli_fetch_assoc($result);
            return $row;
        } else {
            return null;
        }
    }
    $id=$post['id'];
    $title = $post['title'];
    $body = $post['body'];
    $thumbnail = $post['thumbnail'];


if($_SERVER['REQUEST_METHOD']=="POST"){

    // ************ Start Title Validation *********** //
    $title = test_input($_POST['title']);
    if(strlen($title) > 0){
        $title_check = true;
    } else{
        $response['error']['title'] = "Title Required";
    }
// ************ End Title Validation *********** //

// ************ Start Content Validation *********** //
    if(strlen($_POST['body'])>0){
        $content = $_POST['body'];
        $content_check = true;
    } else{
        $response['error']['content'] = "Content Required";
    }

// ************ End Content  Validation *********** //


// ************ Start Thumbnail Validation *********** //
    if(!$_FILES['thumbnail']['name']==""){
        $file_name = $_FILES['thumbnail']['name'];
        $file_tmp = $_FILES['thumbnail']['tmp_name'];
        $file_type = $_FILES['thumbnail']['type'];
        $file_ext = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
        $thumbnail = time().".".$file_ext;
        $file_new_name = "../../assets/storage/thumbnails/".$thumbnail;
        $extensions= array("jpeg","jpg","png");
        if (in_array($file_ext,$extensions)== FALSE ) {
        $response['error']['thumbnail']="Invalid File Type, please choose a JPEG or PNG file.";
        } else {
            if (move_uploaded_file($file_tmp, $file_new_name)){
                $response['success']['thumbnail'] = "Thumbnail saved";
                $thumbnail_check = TRUE;
            } else {
                $response['error']['thumbnail'] = "Thumbnail save Failed";
            }
        }
    } else {
        $thumbnail_check = TRUE;
    }
    // ************  End Thumbnail Validation *********** //


    // *********** Start Uploading in Database ********** //
    if( $title_check == true && $content_check == true && $thumbnail_check == true ){
        $sql = "UPDATE posts SET title='$title', thumbnail='$thumbnail', body='$content', updated_at=now() WHERE id='$id'";

        if ($conn->query($sql) == TRUE) {
            $response['success'] = "Post updated successfully.";   
            $response['status'] = 200;
        } else {
            $response['failure'] = "Failed to update post";   
            $response['status'] = 500;   
        }

    } else {
        $response['status'] = 400;   
    }


    // *********** Sending Response *********** //
    $response['data'] = [$title,$thumbnail,$content,$title_check,$content_check,$thumbnail_check];
    echo json_encode($response); 

}

// *********** End Uploading in Database ********** //

// functions to prevent injections
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>