<?php

function parseDatetime(string $dt) {
	// Because of difference between the format get from HTML form and the "Datetime" store in MySQL
	// Dynamic accept two format of string datetime
    $check = DateTime::createFromFormat("Y-m-d H:i", $dt);
    if (!$check) return DateTime::createFromFormat("Y-m-d H:i:s", $dt);
    else return $check;
}

function saveDatetime($conn, $datetime) {
    $query = "INSERT INTO dt(datetime) VALUES ('".$datetime->format('Y-m-d H:i:s')."')";
    mysqli_query($conn, $query);
}

function getDatetime($conn, $id) {
    $query = "SELECT datetime FROM dt WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if ($result->num_rows != 1) {
        echo "Something gone wrong!";
        return NULL;
    } else {
        $r = $result->fetch_assoc();
        return parseDatetime($r['datetime']);
    }
}
?>