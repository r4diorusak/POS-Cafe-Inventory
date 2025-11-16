<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi_seo.php";

$module=$_GET[module];
$act=$_GET[act];

// Hapus Kategori
if ($module=='pelanggan' AND $act=='hapus'){
  mysql_query("DELETE FROM pelanggan WHERE id_pelanggan='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input kategori
elseif ($module=='pelanggan' AND $act=='input'){
  
  mysql_query("INSERT INTO pelanggan(nama_lengkap,alamat,no_telp) VALUES('$_POST[nama]','$_POST[alamat]','$_POST[telepon]')");
  header('location:../../media.php?module='.$module);
}

// Update kategori
elseif ($module=='pelanggan' AND $act=='update'){
  
  mysql_query("UPDATE pelanggan SET nama_lengkap = '$_POST[nama]',alamat = '$_POST[alamat]',no_telp= '$_POST[telepon]' WHERE id_pelanggan = '$_POST[id]'");
  header('location:../../media.php?module='.$module);
}
?>
