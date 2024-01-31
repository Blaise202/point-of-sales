<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'myDatabase');
define('DB_PASSWORD', '1234');
define('DB_DATABASE', 'pos');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if(!$conn){
    die("Connection Faied:". mysqli_connect_error());
}