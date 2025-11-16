<?php
$aksi="modul/mod_pelanggan/aksi.php";
switch($_GET[act]){
  // Tampil Kategori
  default:
    echo "
          <div class='box box-primary'>
		  <div class='box-header'>
		  <a class='btn icon-btn btn-primary' href='?module=pelanggan&act=tambah'>
<span class='glyphicon btn-glyphicon glyphicon-plus img-circle text-default'></span>
Tambah
</a></div>
		<div class='box-body'>
         <table id='dataTables' class='table-bordered col-md-12'>
           <thead><tr><th width=30px>NO</th><th>Nama Pelanggan</th><th>Aksi</th></tr></thead>"; 
    $tampil=mysql_query("SELECT * FROM pelanggan ORDER BY id_pelanggan ASC");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td align=center>$no</td>
             <td>$r[nama_lengkap]</td>			 
             <td align=center><a class='btn icon-btn btn-info' href=?module=pelanggan&act=edit&id=$r[id_pelanggan]><span class='glyphicon btn-glyphicon glyphicon-edit img-circle text-default'></a>
	               <a class='btn icon-btn btn-danger' href=$aksi?module=pelanggan&act=hapus&id=$r[id_pelanggan]><span class='glyphicon btn-glyphicon glyphicon-trash img-circle text-default'></a>
             </td></tr>";
      $no++;
    }
    echo "</table></div></div>";
    break;
  
  // Form Tambah Kategori
  case "tambah":
    echo " <div class='box box-primary col-md-6'>
		  <div class='box-header'><h2>Tambah Pelanggan</h2></div>
		  <div class='box-body'>
          <form method=POST action='$aksi?module=pelanggan&act=input'>
          <table>
          <tr><td>Nama pelanggan </td><td> : <input type=text name='nama'></td></tr>
		  <tr><td>Alamat </td><td> : <input type=text name='alamat'></td></tr>
		  <tr><td>No Telepon </td><td> : <input type=text name='telepon'></td></tr>
		 
          <tr><td colspan=2><input type=submit name=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div>";
     break;
  
  // Form Edit Kategori  
  case "edit":
    $edit=mysql_query("SELECT * FROM pelanggan WHERE id_pelanggan='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<div class='box box-primary col-md-6'>
		  <div class='box-header'><h2>Edit Pelanggan</h2></div>
		  <div class='box-body'>
          <form method=POST action=$aksi?module=pelanggan&act=update>
          <input type=hidden name=id value='$r[id_pelanggan]'>
          <table >
          <tr><td>Nama Pelanggan</td><td> : <input type=text name='nama' value='$r[nama_lengkap]'></td></tr>
		    <tr><td>Alamat </td><td> : <input type=text name='alamat' value='$r[alamat]'></td></tr>
		  <tr><td>No Telepon </td><td> : <input type=text name='telepon' value='$r[no_telp]'></td></tr>
          <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div>";
    break;  
}
?>

<script src="assets/bootstrap/js/jquery-1.12.0.min.js"></script>
<script src="assets/bootstrap/js/jquery.dataTables.min.js"></script>
	<script>
	$(document).ready(function() {
		$('#dataTables').DataTable();
	} );
	</script>