<?php
error_reporting(0);
include "config/koneksi.php";



 $d_diskon = $_POST['diskontxt'];
 $k_diskon = $_POST['kodetxt'];


$sql_diskon=mysql_query("SELECT * FROM diskon WHERE diskon='$d_diskon' and kode='$k_diskon'");
$ketemu=mysql_num_rows($sql_diskon);
$r=mysql_fetch_array($sql_diskon);

if ($ketemu > 0){
  session_start();
  
  $_SESSION['diskon']     = $r['diskon'];
  header('location:media.php?module=home');	

}else{
 
  echo "<center>Kode Diskon Salah!<br>";  
  echo " <a href='media.php?module=home'><b>ULANGI LAGI</b></a></center>";
}
?>
