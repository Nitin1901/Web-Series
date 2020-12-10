<?php

    //Declaring variables.
    $host = "localhost";  
    $user = "root";  
    $password = ''; 
    $db = "dbms";
    $table_users = "users";
    $table_webseries = "web_series";
    $table_seasons = "seasons";
    $table_genre = "genre";
      
    // Connecting to database.
    $conn = mysqli_connect($host, $user, $password);

    // Check connection
    if(!$conn) {
        die("<br>Connection failed: " . mysqli_connect_error());
    }

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS $db";

    if (!mysqli_query($conn, $sql)) {
        echo "<br>Error creating database: " . mysqli_error($conn);
    }

    // Connecting to database
    $sql = "USE $db";
    if (!mysqli_query($conn, $sql)) {
        echo "<br>Error creating database: " . mysqli_error($conn);
    }

    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS $table_users ( 
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(50) NOT NULL,
        phone CHAR(10) NOT NULL,
        type CHAR NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";

    if (!mysqli_query($conn, $sql)) {
        echo "<br>Error creating table: " . mysqli_error($conn);
    }
    
    // create table to store data about series
    $sql = "CREATE TABLE IF NOT EXISTS $table_webseries(
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(225) NOT NULL UNIQUE,
        seasons INT,
        rating INT NOT NULL, 
        image VARCHAR(225) NOT NULL,
        video VARCHAR(225) NOT NULL,
        PRIMARY KEY(id))";
        
    if (!mysqli_query($conn, $sql)) {
        echo "<br>Error creating table: " . mysqli_error($conn);
    }

    // create table to store data about each season
    $sql = "CREATE TABLE IF NOT EXISTS $table_seasons(
        id INT NOT NULL,
        season_num INT NOT NULL,
        episode_cnt INT NOT NULL,
        time_ep VARCHAR(10) NOT NULL,
        uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY(id,season_num),
        CONSTRAINT fkey_seasons FOREIGN KEY (id) REFERENCES $table_webseries(id)
        ON DELETE CASCADE 
        ON UPDATE CASCADE
        )";
        
    if (!mysqli_query($conn, $sql)) {
        echo "<br>Error creating table: " . mysqli_error($conn);
    }

    // create table to store data about each season
    $sql = "CREATE TABLE IF NOT EXISTS $table_genre(
        id INT NOT NULL,
        genre VARCHAR(225),
        PRIMARY KEY(id, genre),
        CONSTRAINT fkey_genre FOREIGN KEY (id) REFERENCES $table_webseries(id)
        ON DELETE CASCADE 
        ON UPDATE CASCADE
        )";
        
    if (!mysqli_query($conn, $sql)) {
        echo "<br>Error creating table: " . mysqli_error($conn);
    }

?>  
