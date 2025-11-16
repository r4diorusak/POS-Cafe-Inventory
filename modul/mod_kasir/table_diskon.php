 <form method="POST" action="modul/mod_kasir/kasir.php">
	<div class='box-body'>
    <table id="dataTables_snack" class="table-bordered" style="width:100%;">
	
        <thead>
            <tr class="blue">
               <th width="20px">NO.</th>
                
                <th>Keterangan</th>
				 <th>Kode</th>
				<th style=" text-align: center;" width="100px">Perintah</th>
       
            </tr>
        </thead>
		
		<tbody>
			<?php
			$no = 1;
			$res = mysql_query("SELECT * FROM diskon");
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
					<td >'.$row['keterangan'].'</td>
					<td ><input class="form-control" type=text name="kodetxt"></td>
					<td width=80px align=center><a name="btn_edit" type="submit" class="btn icon-btn btn-info" href="media.php?module=home&diskon='.$row['diskon'].'">
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
		$('#dataTables_snack').DataTable();
	} );
	</script>
	


    </section>
 </form>