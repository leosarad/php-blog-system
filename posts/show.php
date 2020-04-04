<?php 
    session_start();
    require('../controller/dbConnect.php');
    
    $post_id = $_GET['id'];
    $findQuery = "SELECT * FROM posts WHERE id='$post_id'";
    $post = executeQuery($findQuery);

    $likes = getLikes($post['id']);
    $user  = getUser($post['user_id']);  
    
    $comments = getComments($post['id']);

    $post['user'] = $user;
    $post['likes'] = $likes;

    function executeQuery($query){
        $result = mysqli_query($GLOBALS['conn'],$query);
        if ( mysqli_num_rows($result) > 0 ){
            $row= mysqli_fetch_assoc($result);
            return $row;
        } else {
            return null;
        }
    }
    function getUser($user_id){
        $query = "SELECT * FROM users WHERE id=$user_id";
        $result = mysqli_query($GLOBALS['conn'],$query);
        if ( mysqli_num_rows($result) > 0 ){
            $row= mysqli_fetch_assoc($result);
            return $row;
        } else {
            return [];
        }
    }
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
    
    function getComments($post_id){
        $query = "SELECT * FROM comments WHERE post_id=$post_id";
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOG</title>
</head>
<?php include_once("../include/styles.php")?>
<body>
    <?php include_once("../include/header.php")?>

    <div class="myContainer">
       <?php if($post!=null){ ?>
            <div class="post-container">
                <h5 class="title"><?=$post['title']?></h5>
                <div class="details">
                    <a><span>b/<?=$post['user']['name']?> |</span></a><span> <?=$post['created_at']?></span>
                </div>
                <div class="post-thumbnail" style="background-image:url('/blog/assets/storage/thumbnails/<?=$post['thumbnail']?>')"></div>
                <div class="card-text"><?=$post['body']?></div>
                <div class="actions" post=''>
                    <?php if(isset($_SESSION['auth'])){ ?>
                        
                        <?php if(userLiked($likes)){ ?>
                                <span><i class="fa fa-heart-o active" aria-hidden="true"></i> <span> <?= $post['total_likes']; ?> </span></span>
                        <?php } else { ?>
                                <span><i class="fa fa-heart-o like" aria-hidden="true" onclick="postLike(<?=$post['id'] ?>,this)"></i> <span> <?= $post['total_likes']; ?> </span></span>
                        <?php } ?>
                        
                    <?php } else { ?>
                        <span><i class="fa fa-heart-o like" aria-hidden="true" ></i> <span>  <?= $post['total_likes']; ?>  </span></span>   
                    <?php } ?>

                    <span><i data='views' class="fa fa-eye" aria-hidden="true"></i> <span>  <?= $post['total_views']; ?>  </span> </span>
                    <span><i data='comments' class="fa fa-comment" aria-hidden="true" onclick="postComment(<?=$post['id'] ?>,this)"></i> <span>  <?= $post['total_comments']; ?>  </span> </span>
                </div>
                <div class="commentBox">
                    <form id="commentForm">
                        <input type="text" name="comment" id="comments">
                        <input type="submit" class='btn btn-primary' value="Comment">
                    </form>
                    <div>
                    
                        <?php if(count($comments)>0) {
                            foreach($comments as $comment) { 
                                $user = getUser($comment['user_id']);        
                        ?>
                            <div class='comments'>
                                <div>b/<?=$user['name'] ?></div>
                                <div><?=$comment['comment'] ?></div>
                            </div>
                        <?php }
                        } ?>
                </div>
            </div>
       <?php } else {?>
            <p class='msg '>The post is not found. <br> <a href="/blog/posts/create.php">Create Post</a></p>
       <?php }?>
    </div>

</body>
<?php include_once("../include/scripts.php")?>
<script>
$(document).ready(async function (){
    let response = await fetch(`/blog/controller/posts/postActions/view.php?id=<?=$post_id ?>`, {
            method: 'GET',
        });
        let result = await response.json();
        if(result.status==200){
            let view = document.querySelector('.fa.fa-eye');
            view.nextElementSibling.innerText=(view.nextElementSibling.innerText)*1+1;
        }
        console.log(result);
    });
</script>
</html>