<form method="post">
	<div class='box-body'>
    <table id="dataTables" class="table-bordered col-md-12">
	
        <thead>
            <tr class="blue">
               <th width="20px">NO.</th>
                <th style=" text-align: center;">Gambar</th>
                <th>Keterangan</th>
				<th style=" text-align: center;">Kategori</th>
					
                <th style=" text-align: center;">Harga</th>
				<th style=" text-align: center;" width="100px">Perintah</th>
       
            </tr>
        </thead>
		
		<tbody>
			<?php
			
			$no = 1;
			$res = mysql_query("SELECT * FROM `menu` a,kategori b where a.kategori=b.id_kategori order by a.id_menu DESC");
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
					<td align=center><img src="'.$gbr.'"width="80px" height="60px"></td>
					<td >'.$row['menu'].'</td>
					<td align=center>'.$row['nama_kategori'].'</td>
					<td align=center>Rp.'.number_format($row['harga'],0, ".", ".").'</td>
					<td width=80px align=center><a name="btn_edit" class="btn icon-btn btn-info" href="media.php?module=menu&opr=upd&rs_id='.$row['id_menu'].'">
<span class="glyphicon btn-glyphicon glyphicon-edit img-circle text-default"></span>
</a>
					
					<a name="btn_hapus" class="btn icon-btn btn-danger" href="media.php?module=menu&opr=del&rs_id='.$row['id_menu'].'&rs_menu='.$row['id_menu'].'">
<span class="glyphicon btn-glyphicon glyphicon-trash img-circle text-default"></span>
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
		$('#dataTables').DataTable();
	} );
	</script>
	


    </section>
 </form>