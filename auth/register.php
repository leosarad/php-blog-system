<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOG</title>
    <?php include_once("../include/styles.php")?>
</head>
<body>
<?php include_once("../include/header.php")?>
<!-- Echo Session Messeges -->
    <?php
        if(isset($_SESSION['success'])){
    ?>
        <span class="d-flex text text-success justify-content-center" >
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
<!-- End Echo Session Messages -->
<div class="myContainer">
    <div class="post-item">
        <div class="card-header">Register</div>
        <div class="card-body">
            <form method="POST" action="/blog/controller/auth/register.php">
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control " name="name" value=""  autocomplete="name" autofocus>
                        
                        <?php
                            if(isset($_SESSION['nameErr'])){
                        ?>
                            <span class="text text-danger" >
                                <strong><?=$_SESSION['nameErr']?></strong>
                            </span>
                        <?php
                            unset($_SESSION['nameErr']);
                            }
                        ?>

                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Email Address</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control " name="email" value=""  autocomplete="email">
                        <?php
                            if(isset($_SESSION['emailErr'])){
                        ?>
                            <span class="text text-danger" >
                                <strong><?=$_SESSION['emailErr']?></strong>
                            </span>
                        <?php
                            unset($_SESSION['emailErr']);
                            }
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control " name="password"  autocomplete="new-password">
                        <?php
                            if(isset($_SESSION['pwErr'])){
                        ?>
                            <span class="text text-danger" >
                                <strong><?=$_SESSION['pwErr']?></strong>
                            </span>
                        <?php
                            unset($_SESSION['pwErr']);;
                            }
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<?php include_once('../include/scripts.php')?>
</html>