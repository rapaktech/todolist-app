<?php
    /* Run this file once to seed table into created database.
    Modify $username, $password and $dbname variable to match your own */

    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "ToDoList";

    $conn = new mysqli ($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die ("Connection failed: " . $conn->connect_error);
    }

    $sql = "CREATE TABLE Items (
        id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        item VARCHAR(1000) NOT NULL,
        added TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'Items' is now in database";
    } else {
        echo "Error creating table: " . $conn->error;
    }
?>