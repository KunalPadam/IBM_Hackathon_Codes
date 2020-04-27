<?php
$servername ="dashdb-txn-sbox-yp-lon02-04.services.eu-gb.bluemix.net";
$username ="xsg48981";
$password ="lm0d2svj^v2fsn15";
$dbname ="BLUDB";
// Create connection
$conn = new mysqli($servername,$username,$password,$dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>	