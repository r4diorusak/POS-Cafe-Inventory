<?php
    echo "<div class='box box-primary col-md-6'>
		  <div class='box-header'><h2>Ganti Password</h2></div>
          <form method=POST action=modul/mod_password/aksi_password.php>
          <table>
          <tr><td>Masukkan Password Lama</td><td> : <input type=password name='pass_lama'></td></tr>
          <tr><td>Masukkan Password Baru</td><td> : <input type=password name='pass_baru'></td></tr>
          <tr><td>Masukkan Lagi Password Baru</td><td> : <input type=password name='pass_ulangi'></td></tr>
          <tr><td colspan=2><input type=submit value=Proses>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div>";
?>
