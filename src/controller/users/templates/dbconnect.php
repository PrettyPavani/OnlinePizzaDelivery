<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "online_pizza_delivery";

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn){
    die("Error". mysqli_connect_error());
}

?>
