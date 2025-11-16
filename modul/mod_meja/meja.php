<?php
$aksi="modul/mod_meja/aksi.php";
switch($_GET[act]){
  // Tampil Kategori
  default:
    echo "
          <div class='box box-primary col-md-8'>
		  <div class='box-header'>
		  <a class='btn icon-btn btn-primary' href='?module=meja&act=tambah'>
<span class='glyphicon btn-glyphicon glyphicon-plus img-circle text-default'></span>
Tambah
</a></div>
		<div class='box-body'>
         <table id='dataTables' class='table-bordered col-md-12'>
           <thead><tr><th width=30px>NO</th><th>Meja</th><th>Lokasi</th><th>Aksi</th></tr></thead>"; 
    $tampil=mysql_query("SELECT * FROM meja ORDER BY id_meja ASC");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td align=center>$no</td>
             <td align=center>$r[no_meja]</td>	
			 <td align=center>$r[lokasi]</td>		
             <td align=center><a class='btn icon-btn btn-info' href=?module=meja&act=edit&id=$r[id_meja]><span class='glyphicon btn-glyphicon glyphicon-edit img-circle text-default'></a>
	               <a class='btn icon-btn btn-danger' href=$aksi?module=meja&act=hapus&id=$r[id_meja]><span class='glyphicon btn-glyphicon glyphicon-trash img-circle text-default'></a>
             </td></tr>";
      $no++;
    }
    echo "</table></div></div>";
    break;
  
  // Form Tambah Kategori
  case "tambah":
    echo " <div class='box box-primary col-md-6'>
		  <div class='box-header'><h2>Tambah meja</h2></div>
		  <div class='box-body'>
          <form method=POST action='$aksi?module=meja&act=input'>
          <table>
          <tr><td>Meja </td><td> : <input type=number name='nama' min='1' max='99'></td></tr>
		  <tr><td>Lokasi </td><td> : 
		  <select name=lokasitxt>
			  <option value=Dalam>Dalam</option>
			  <option value=Luar>Luar</option>
			  <option value='R.Meeting'>R.Meeting</option>
			  <option value='B.Pulang'>B.Pulang</option>
			</select>
		  </td></tr>
		 
          <tr><td colspan=2><input type=submit name=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div>";
     break;
  
  // Form Edit Kategori  
  case "edit":
    $edit=mysql_query("SELECT * FROM meja WHERE id_meja='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<div class='box box-primary col-md-6'>
		  <div class='box-header'><h2>Edit meja</h2></div>
		  <div class='box-body'>
          <form method=POST action=$aksi?module=meja&act=update>
          <input type=hidden name=id value='$r[id_meja]'>
          <table >
          <tr><td>Meja</td><td> : <input type=number name='nama' value='$r[no_meja]' min='1' max='99'></td></tr>
		    <tr><td>Lokasi </td><td> : 
		  <select name=lokasitxt>
			  <option value='$r[lokasi]'>$r[lokasi]</option>
			  <option value=Dalam>Dalam</option>
			  <option value=Luar>Luar</option>
			  <option value=R.Meeting>R.Meeting</option>
			  <option value=B.Pulang>B.Pulang</option>
			</select>
		  </td></tr>
		  
		  </td></tr>  
          <tr><td colspan=2><input type=submit name=submit value=Update>
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