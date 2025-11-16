<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "kedan_db";

// Koneksi dan memilih database di server
$link = mysql_connect($server,$username,$password) or die('Could not connect: ' . mysql_error());

mysql_set_charset('utf8',$link);

mysql_select_db($database) or die("Database tidak bisa diakses. Periksa server!");


?>
