<?php 

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}

?>