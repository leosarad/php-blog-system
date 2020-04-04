<?php
    session_start();
    if(!isset($_SESSION['auth'])){
        header("Location: controller/auth/logout.php");
    }
    require('controller/dbConnect.php');
    
    $postsQuery = "SELECT * FROM posts ORDER BY created_at DESC";
    $posts = executeQuery($postsQuery);

    function executeQuery($query){
        $result = mysqli_query($GLOBALS['conn'],$query);
        if ( mysqli_num_rows($result) > 0 ){
            $rows= mysqli_fetch_all($result,1);
            return $rows;
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
</head>
<?php include_once("include/styles.php")?>
<body>
    <?php include_once("include/header.php")?>
    
    <?php
        if(isset($_SESSION['success'])){
    ?>
        <span class="d-flex justify-content-center text text-success">
            <strong><?=$_SESSION['success']?></strong>
        </span>
    <?php
        unset($_SESSION['success']);
        }
    ?>
    <?php
        if(isset($_SESSION['failure'])){
    ?>
        <span class="d-flex justify-content-center text text-danger">
            <strong><?=$_SESSION['failure']?></strong>
        </span>
    <?php
        unset($_SESSION['failure']);
        }
    ?>

    <div class=" myContainer">
        <div class="card post-item justify-content-center">
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                <?php if(!isset($_SESSION['auth'])) { ?>
                <div>You are not logged in to enter dashboard.</div>
                <div><a href="/blog/auth/login.php">Login</a></div>
                <div> Dont have an account, <a href="/blog/auth/register.php">Register</a></div>
                <?php } else { ?>
                <div>
                    Welcome to dahboard. Manage your Content here
                </div>
                <div>
                    <div class="card post-item">
                        <div class="card-header">
                                My Blog Posts 
                                    <a class='btn btn-primary' href="posts/create.php">Create New Post</a>
                        </div>
                        <div class="card-body">
                            <?php if($posts!=null) { ?>
                            <table>
                                <tr>
                                    <th style="width:75%">Title</th>
                                    <th colspan=2>Actions</th>
                                </tr>

                                <?php foreach($posts as $post) { ?>
                                <tr>
                                    <td><?=$post['title']; ?></td>
                                    <td><a href="/blog/posts/edit.php?id=<?=$post['id']; ?>"> Edit</a> | </td>
                                    <td><a href="/blog/controller/posts/destroy.php?id=<?=$post['id']; ?>">  Delete</a></td>
                                </tr>

                                <?php } ?>

                            </table>
                            <?php } else { ?>
                            <div>No Posts yet</div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

</body>
<?php include_once("include/scripts.php")?>
</html>