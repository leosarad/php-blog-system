<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "blog";

    $conn = new mysqli($server,$user,$password,$db);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    } else {
        
        // USERS TABLE SQL QUERY
        $usersTable ="CREATE TABLE users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255),
            email VARCHAR(255),
            password VARCHAR(255),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        echo "<br>Users Table: ".createTable($usersTable);

        // POSTS TABLE SQL QUERY
        $postsTable ="CREATE TABLE posts (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            body longtext NOT NULL,
            thumbnail VARCHAR(255) NOT NULL,
            user_id INT NOT NULL,
            total_likes INT NOT NULL,
            total_views INT NOT NULL,
            total_comments INT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at DATETIME 
        )";
        echo "<br>Posts Table: ".createTable($postsTable);

        // LIKES TABLE SQL QUERY
        $likesTable ="CREATE TABLE likes (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT NOT NULL,
            post_id INT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        )";
        echo "<br>Likes Table: ".createTable($likesTable);

        // COMMENTS TABLE SQL QUERY
        $commentsTable ="CREATE TABLE comments (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT NOT NULL,
            post_id INT NOT NULL,
            comment text NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        )";
        echo "<br>Likes Table: ".createTable($commentsTable);

    }


    function createTable($query){
        $result = mysqli_query($GLOBALS['conn'],$query);
        if ($result){
            return "true";
        } else {
            return "false";
        }
        var_dump($result);
    }

?>