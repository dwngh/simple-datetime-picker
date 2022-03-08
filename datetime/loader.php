<?php
require_once("db.php");
$query = "SELECT * FROM dt";
$load_datetime = mysqli_query($conn, $query);
$load_datetime_result = [];
while ($row = $load_datetime->fetch_assoc())
    array_push($load_datetime_result, ["id" => $row['id'], "datetime" => $row['datetime']]);
?>