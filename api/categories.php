<?php
    /*
        @file name: categories.php 
        @description: handles to categories related functions
        @author: Amar Al-Adil
    */ 
    require("constant.php");

    // Sets the database connection
    $connection = mysqli_connect(HOST_DB, USER_DB, PASSWORD_DB, NAME_DB);

    // If Connection Errors
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "select * from categories"; 

    // run SQL statement
    $result = mysqli_query($connection,$sql);

    // die if SQL statement failed
    if (!$result) {
        http_response_code(404);
        die(mysqli_error($connection));
    }

    echo '[';
    for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
    echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
    echo ']';

    $connection->close();

?>