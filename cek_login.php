<?php
error_reporting(0);
include "config/koneksi.php";
function antiinjection($data){
  $filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter_sql;
}

$username = antiinjection($_POST['username']);
$pass     = antiinjection(md5($_POST['password']));
$key	  = antiinjection(md5(gethostbyaddr($_SERVER['REMOTE_ADDR'])));

//$username = antiinjection($_GET['username']);
//$pass     = antiinjection(md5($_GET['password']));

$login=mysql_query("SELECT * FROM admin WHERE username='$username' AND password='$pass'");
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);

$login1=mysql_query("SELECT * FROM users WHERE username='$username' AND password='$pass'");
$ketemu1=mysql_num_rows($login1);
$r1=mysql_fetch_array($login1);

// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();
 
  $_SESSION[namauser]     = $r[username];
  $_SESSION[passuser]     = $r[password];
  $_SESSION[leveluser]    = $r[level];
  
  header('location:media.php?module=home');	

}elseif ($ketemu1 > 0) {
	
	session_start();
  
  $_SESSION[namauser]     = $r1[username];
  $_SESSION[passuser]     = $r1[password];
  $_SESSION[leveluser]    = $r1[level];
	  
  header('location:media.php?module=home');	
}else{
  echo "<link href=config/adminstyle.css rel=stylesheet type=text/css>";
  echo "<center>LOGIN GAGAL! <br> 
        Username atau Password Anda tidak benar.<br>
        Atau account Anda sedang diblokir.<br>";
  echo "<a href=index.php><b>ULANGI LAGI</b></a></center>";
}
?>
