<?php
    /*
        @file name: documents.php 
        @description: handles to document related functions
        @author: Amar Al-Adil
    */ 
    require("constant.php");

    // Sets the database connection
    $connection = mysqli_connect(HOST_DB, USER_DB, PASSWORD_DB, NAME_DB);

    // if the request is either a GET or POST
    $method = $_SERVER['REQUEST_METHOD'];

    $category_id = -1;
    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
    }

    // If Connection Errors
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Case for Request Method - GET or POST
    switch ($method) {
        case 'GET': 
            // Select all depending on category
            $sql = "SELECT * FROM documents WHERE category_id ='$category_id' "; 
            break;
        case 'POST':
            // Document name
            $name = $_POST["name"];
            // if the submission is either UPDATE, INSERT or DELETE
            $submitAction = $_POST["submitAction"];
            // Document Id
            $documentID = $_POST["id"];

            // Depending on submitAction, sql query can be either an insert, update or delete for the documents
            if ($submitAction === 'Insert') {
                $sql = "INSERT INTO documents (category_id, name) VALUES ('$category_id','$name')"; 
            } elseif ($submitAction === 'Update') {
                // initialize the new update time
                $now = new DateTime(null, new DateTimeZone(SERVER_LOCATION));
                $sql = "UPDATE documents SET name = '$name', updated_at = '". $now->format('Y-m-d H:i:s') ."' WHERE id = '$documentID'"; 
            } else {
                $sql = "DELETE FROM documents WHERE id = '$documentID'"; 
            };
            
            break;
    }

    // run SQL statement
    $result = mysqli_query($connection,$sql);

    // die if SQL statement failed
    if (!$result) {
        http_response_code(404);
        die(mysqli_error($connection));
    } else {
        http_response_code(200);
    }
    // Similar to Switch, just for the output returns to app
    if ($method == 'GET') {
        echo '[';
        // Loops through all the documents
        for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
        echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
        }
        echo ']';
    } elseif ($method == 'POST') {
        echo json_encode($result);
    } else {
        echo mysqli_affected_rows($connection);
    }

    $connection->close();

?>