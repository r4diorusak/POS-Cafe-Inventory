<?php
$aksi="modul/mod_kategori/aksi_kategori.php";
switch($_GET[act]){
  // Tampil Kategori
  default:
    echo "
		<div class='box box-primary'>
		  <div class='box-header'>
		  <a class='btn icon-btn btn-primary' href='?module=kategori&act=tambahkategori'>
<span class='glyphicon btn-glyphicon glyphicon-plus img-circle text-default'></span>
Tambah
</a></div>
		<div class='box-body'>
         <table id='dataTables' class='table-bordered col-md-12'>
           <thead><tr><th width=30px>NO</th><th>Kategori</th><th>Aksi</th></tr></thead>"; 
    $tampil=mysql_query("SELECT * FROM kategori ORDER BY id_kategori DESC");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td align=center>$no</td>
             <td>$r[nama_kategori]</td>			 
             <td align=center><a class='btn icon-btn btn-info' href=?module=kategori&act=editkategori&id=$r[id_kategori]><span class='glyphicon btn-glyphicon glyphicon-edit img-circle text-default'></span></a> 
	               <a class='btn icon-btn btn-danger' href=$aksi?module=kategori&act=hapus&id=$r[id_kategori]><span class='glyphicon btn-glyphicon glyphicon-trash img-circle text-default'></span></a>

</td>   
             </td></tr>";
      $no++;
    }
    echo "</table></div></div>";
    break;
  
  // Form Tambah Kategori
  case "tambahkategori":
    echo "<div class='box box-primary col-md-6'>
		  <div class='box-header'><h2>Tambah Kategori</h2></div>
		<div class='box-body'>
          <form method=POST action='$aksi?module=kategori&act=input'>
          <table>
          <tr><td>Nama Kategori</td><td> : <input type=text name='nama_kategori'></td></tr>
		 
          <tr><td colspan=2><input type=submit name=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div>";
     break;
  
  // Form Edit Kategori  
  case "editkategori":
    $edit=mysql_query("SELECT * FROM kategori WHERE id_kategori='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<div class='box box-primary col-md-6'>
		  <div class='box-header'><h2>Edit Kategori</h2></div>
		<div class='box-body'>
          <form method=POST action=$aksi?module=kategori&act=update>
          <input type=hidden name=id value='$r[id_kategori]'>
          <table >
          <tr><td>Nama Kategori</td><td> : <input type=text name='nama_kategori' value='$r[nama_kategori]'></td></tr>
		  
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