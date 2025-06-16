<?php
$host = "mariadb";
$user = "root";
$pass = "rootpass";
$dbname = "testdb";

echo "Trying to connect to $host ...<br>";

$ip = gethostbyname($host);
echo "Resolved $host to $ip<br>";

$mysqli = new mysqli($host, $user, $pass, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "Connected to MariaDB successfully!";
?>
