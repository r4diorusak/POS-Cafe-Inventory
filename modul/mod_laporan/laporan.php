<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
   echo "
   <div class='box box-primary col-md-12'>
		  <div class='box-header'><h4>Laporan Pendapatan</h4></div>
		<div class='box-body'>
          <form method=POST action='invoice-date-print.php'>
          <table border=0>
          <tr><td>Dari Tanggal</td><td> : ";        
          combotgl(1,31,'tgl_mulai',$tgl_skrg);
          combonamabln(1,12,'bln_mulai',$bln_sekarang);
          combothn(2000,$thn_sekarang,'thn_mulai',$thn_sekarang);

    echo "</td></tr>
          <tr><td>s/d Tanggal</td><td> : ";
          combotgl(1,31,'tgl_selesai',$tgl_skrg);
          combonamabln(1,12,'bln_selesai',$bln_sekarang);
          combothn(2000,$thn_sekarang,'thn_selesai',$thn_sekarang);
		
    echo "</td></tr>
			<tr><td>Pegawai</td><td> :
	      <select name='pegawaitxt' class=''>
							<option value=''>-Pilih Pegawai-</option>
							<option value=''>-Semua-</option>
							<option value='admin'>admin</option>";
							$tampil=mysql_query("SELECT * FROM users ORDER BY id_pegawai ASC");
							while($r=mysql_fetch_array($tampil)){
							  echo "<option value=$r[username]>$r[username]</option>";
							}
				echo "</select>
			</tr></td>	
          <tr><td colspan=2><input type=submit value=Proses formtarget='_blank'>
          <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table>
		  </form></div></div>";

}

?>
