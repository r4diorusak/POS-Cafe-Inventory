<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi_seo.php";

$module=$_GET[module];
$act=$_GET[act];

// Hapus Kategori
if ($module=='meja' AND $act=='hapus'){
  mysql_query("DELETE FROM meja WHERE id_meja='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input kategori
elseif ($module=='meja' AND $act=='input'){
  
  mysql_query("INSERT INTO `meja`(`no_meja`,`lokasi`) VALUES('$_POST[nama]','$_POST[lokasitxt]')");
  header('location:../../media.php?module='.$module);
}

// Update kategori
elseif ($module=='meja' AND $act=='update'){
  
  mysql_query("UPDATE meja SET no_meja = '$_POST[nama]', lokasi = '$_POST[lokasitxt]' WHERE id_meja = '$_POST[id]'");
  header('location:../../media.php?module='.$module);
}
?>
