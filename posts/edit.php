<?php
    session_start();
    if(!isset($_SESSION['auth'])){
        header("Location: ../controller/auth/logout.php");
    }
    require('../controller/dbConnect.php');
    
    $postQuery = "SELECT * FROM posts WHERE id=".$_GET['id'];
    $post = executeQuery($postQuery);

    function executeQuery($query){
        $result = mysqli_query($GLOBALS['conn'],$query);
        if ( mysqli_num_rows($result) > 0 ){
            $row= mysqli_fetch_assoc($result);
            return $row;
        } else {
            return null;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOG</title>
    <?php include('../include/styles.php') ?>
    <link rel="stylesheet" href="/blog/assets/css/quill.css">
</head>
<body>
<?php include('../include/header.php') ?>

<div class="msg msg-success"></div>
<div class="msg msg-error"></div>

<div class="myContainer formContainer">
    <form action="" method="POST" id='postForm' class='post-item'>
      <h2>Create Blog</h2>
      <div class="form-group">
        <label for="title"><h6>Title</h6></label>
        <input type="text" class='form-control' name="title" id="title" placeholder="Enter Title" value="<?=$post['title']; ?>" >
      </div>
      <div class="form-group">
        <h6>Thumbnail</h6>
        <input type="file" name="thumbnail" id="thumbnail" value="Choose Thumbnail">
      </div>
      <div class="form-group">
      <label for="title"><h6>Body</h6></label>
        <div id="editor" >
            <?=$post['body']; ?>
        </div>
      </div>
      <div class="form-group">
        <button type="submit" name='submit' class="form-control btn btn-primary mb-2">Save</button>
      </div>
    </form>
  </div>
</body>
<?php include('../include/scripts.php') ?>
<script src="/blog/assets/js/quill.js"></script>

<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });


    let postForm = document.getElementById('postForm');

    $(postForm).submit(async (e) => {
        e.preventDefault();
        
        let content=document.querySelector('.ql-editor');
        body=content.innerHTML;
            
        let data = new FormData(postForm);
        data.append('body',body);
            
        let response = await fetch("/blog/controller/posts/update.php?id=<?=$post['id'];?>", {
            method: 'POST',
            body: data
        });
        let result = await response.json();
        console.log(result);
        if(result.status==200){
            document.querySelector(".msg.msg-success").innerText="Post Updated Succefully.";
            document.querySelector(".msg.msg-error").innerText="";

        }
        if(result.status==400){
            document.querySelector(".msg.msg-error").innerText="Fields should not be empty";
            document.querySelector(".msg.msg-success").innerText="";

        }
        if(result.status==500){
            document.querySelector(".msg.msg-error").innerText="Post Updation Failed.";
            document.querySelector(".msg.msg-success").innerText="";
        }
    })
</script>

</html>