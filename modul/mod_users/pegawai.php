<?php
$aksi="modul/mod_pegawai/aksi.php";
switch($_GET[act]){
  // Tampil Kategori
  default:
    echo "
     <div class='box box-primary col-md-8'>
		  <div class='box-header'>
		  <a class='btn icon-btn btn-primary' href='?module=pegawai&act=tambah'>
<span class='glyphicon btn-glyphicon glyphicon-plus img-circle text-default'></span>
Tambah
</a></div>
		 <div class='box-body'>
         <table id='dataTables' class='table-bordered col-md-12'>
           <thead><tr><th width=30px>NO</th><th>Nama Pegawai</th><th>Level</th><th>Aksi</th></tr></thead>"; 
    $tampil=mysql_query("SELECT * FROM users ORDER BY id_pegawai DESC");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td align=center>$no</td>
             <td>$r[username]</td>			 
			 <td align=center>$r[level]</td>			 
             <td align=center><a class='btn icon-btn btn-info' href=?module=pegawai&act=edit&id=$r[id_pegawai]><span class='glyphicon btn-glyphicon glyphicon-edit img-circle text-default'></a>
	               <a class='btn icon-btn btn-danger' href=$aksi?module=pegawai&act=hapus&id=$r[id_pegawai]><span class='glyphicon btn-glyphicon glyphicon-trash img-circle text-default'></span></a>
             </td></tr>";
      $no++;
    }
    echo "</table></div></div>";
    break;
  
  // Form Tambah Kategori
  case "tambah":
    echo " <div class='box box-primary col-md-6'>
		  <div class='box-header'><h2>Tambah Pegawai</h2></div>
		  <div class='box-body'>
          <form method=POST action='$aksi?module=pegawai&act=input'>
          <table>
          <tr><td>Nama Pegawai</td><td> : <input type=text name='nama'></td></tr>
		  <tr><td>Password</td><td> : <input type=text name='pass'></td></tr>
		  <tr><td>Level</td><td> : <select name='level'>
                    <option value=Kasir>Kasir</option>
                    <option value=Waiter>waiter</option>
                  </select></td></tr>
		 
          <tr><td colspan=2><input type=submit name=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div>";
     break;
  
  // Form Edit Kategori  
  case "edit":
    $edit=mysql_query("SELECT * FROM users WHERE id_pegawai='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<div class='box box-primary col-md-6'>
		  <div class='box-header'><h2>Edit Pegawai</h2></div>
		  <div class='box-body'>
          <form method=POST action=$aksi?module=pegawai&act=update>
          <input type=hidden name=id value='$r[id_pegawai]'>
          <table >
          <tr><td>Nama Pegawai</td><td> : <input type=text name='nama' value='$r[username]'></td></tr>
		  <tr><td>Password</td><td> : <input type=text name='pass'></td></tr>
		  <tr><td>Level</td><td> : <select name='level'>
                    <option value=Kasir>Kasir</option>
                    <option value=Waiter>waiter</option>
                  </select></td></tr>
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