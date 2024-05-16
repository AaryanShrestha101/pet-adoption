<?php

$server = "localhost";
$user = "root";
$password = "";
$db = "be19_cr5_animal_adoption_sarközi_stefanie";

$conn = mysqli_connect($server,$user,$password,$db);

if(!$conn) {
    die("Connection Failed:".mysqli_connect_error());
}

?>