<?php
session_start();
$title_check = $content_check = $thumbnail_check = false;
$title = $thumbnail =  $content = "";



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
        $thumbnail = "thumbnail.png";
    }
    // ************  End Thumbnail Validation *********** //


    // *********** Start Uploading in Database ********** //
    if( $title_check == true && $content_check == true && $thumbnail_check == true ){
        
        require_once("../dbConnect.php");
        $user_id = $_SESSION['auth']['id'];
        $sql = "INSERT INTO posts (title, thumbnail, body, user_id, created_at) VALUES ('$title', '$thumbnail', '$content', '$user_id', now() )";

        if ($conn->query($sql) == TRUE) {
            $response['success'] = "Post saved successfully.";   
            $response['status'] = 200;
        } else {
            $response['failure'] = "Failed to save post";   
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