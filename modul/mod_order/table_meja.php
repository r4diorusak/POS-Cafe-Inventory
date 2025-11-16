<form method="post">
	<div class='box-body'>
    <table id="dataTables_meja" class="table-bordered" style="width:100%;">
	
        <thead>
            <tr class="blue">
               <th width="20px">NO.</th>
                
                <th>Nomor Meja</th>
				<th>Lokasi Meja</th>
				
				
				
				<th style=" text-align: center;" width="100px">Perintah</th>
       
            </tr>
        </thead>
		
		<tbody>
			<?php
			$no = 1;
			$res = mysql_query("SELECT * FROM meja ORDER BY id_meja ASC");
			//$res = mysql_query("SELECT * FROM `menu`");
			  while($row=mysql_fetch_array($res)){
				echo '
				<tr>
					<td align=center>'.$no.'</td>
					<td >'.$row['no_meja'].'</td>
					<td >'.$row['lokasi'].'</td>
					
					<td width=80px align=center><a name="btn_edit" class="btn icon-btn btn-info" href="media.php?module=p_menu&opr=upd-meja&rs_id='.$row['id_meja'].'">
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
		$('#dataTables_meja').DataTable();
	} );
	</script>
	


    </section>
 </form>