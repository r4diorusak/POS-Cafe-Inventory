 <form method="POST" action="modul/mod_kasir/p_menu.php">
	<div class='box-body'>
    <table id="dataTables_menu" class="table-bordered" style="width:100%;">
	
        <thead>
            <tr class="blue">
               <th width="20px">NO.</th>
                
                <th>Keterangan</th>
				
				<th style=" text-align: center;">Gambar</th>				
                <th style=" text-align: center;">Harga</th>
				<th style=" text-align: center;" width="100px">Perintah</th>
       
            </tr>
        </thead>
		
		<tbody>
			<?php
			$no = 1;
			$res = mysql_query("SELECT * FROM `menu` a,kategori b where a.kategori=b.id_kategori and nama_kategori='Makanan' ORDER by a.menu DESC");
			//$res = mysql_query("SELECT * FROM `menu`");
			  while($row=mysql_fetch_array($res)){
				   if(($row['gambar']=="photos/menu/")){
					$gbr="images/no_img.png";
					}else{
					$gbr=$row['gambar'];
					}
				echo '
				<tr>
					<td align=center>'.$no.'</td>
					<td >'.$row['menu'].'</td>
					<td align=center><img src="'.$gbr.'"width="80px" height="60px"></td>				
					<td align=center>Rp.'.number_format($row['harga'],0, ".", ".").'</td>
					<td width=80px align=center><a name="btn_edit" class="btn icon-btn btn-info" href="media.php?module=bw_pulang&opr=upd&meja='.$_SESSION['meja'].'&rs_id='.$row['id_menu'].'">
<span class="glyphicon btn-glyphicon glyphicon-plus-sign img-circle text-default"></span>
</a>
					
					


</td>
							
					
				</tr>
				';
				$no++;
			}
			?>
		</tbody>

	</table></div>
	

<script src="assets/bootstrap/js/jquery-1.12.0.min.js"></script>
<script src="assets/bootstrap/js/jquery.dataTables.min.js"></script>
	<script>
	$(document).ready(function() {
		$('#dataTables_menu').DataTable();
	} );
	</script>
	


    </section>
 </form>