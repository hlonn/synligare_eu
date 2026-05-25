<?php

$servername = "localhost";
$username = "c9nvm403l_synligare_eutagcloud";
$password = "tagmaster";
$dbname = "c9nvm403l_synligare_eutagcloud";



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE TABLE tagtable (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
keyword  VARCHAR(30) unique,
weight  int NOT NULL,
link VARCHAR(150),
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
  echo "Table tagtable created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close();
?>