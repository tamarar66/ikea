<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'ikea');
 

$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$connect->set_charset("utf8");

if($connect === false){
    die("Neuspešna konekcija. " . mysqli_connect_error());
}
?>
