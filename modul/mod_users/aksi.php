<?php
session_start();
include "../../config/koneksi.php";


$module=$_GET[module];
$act=$_GET[act];

// Hapus Kategori
if ($module=='pegawai' AND $act=='hapus'){
  mysql_query("DELETE FROM users WHERE id_pegawai='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input kategori
elseif ($module=='pegawai' AND $act=='input'){
  $pass=md5($_POST['pass']);
  mysql_query("INSERT INTO `users`(`username`, `password`, `level`) VALUES('$_POST[nama]','$pass','$_POST[level]')");
  header('location:../../media.php?module='.$module);
}

// Update kategori
elseif ($module=='pegawai' AND $act=='update'){
  $pass=md5($_POST['pass']);
  mysql_query("UPDATE `users` SET `username`='$_POST[nama]',`password`='$pass',`level`='$_POST[level]'  WHERE id_pegawai = '$_POST[id]'");
  header('location:../../media.php?module='.$module);
}
?>
