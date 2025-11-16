<form method="post"><a href="media.php?module=pelanggan&act=tambah" type="submit" class="btn btn-primary icon-btn btn-info"><span class="glyphicon btn-glyphicon glyphicon-plus img-circle text-default"></span> Pelanggan Baru</a>
	<div class='box-body'>
	
	
    <table id="dataTables_pelanggan" class="table-bordered" style="width:100%;">
	
        <thead>
            <tr class="blue">
               <th width="20px">NO.</th>
                
                <th>Nama Lengkap</th>
				
				<th style=" text-align: center;">Alamat</th>	
                <th style=" text-align: center;">Telepon</th>
				<th style=" text-align: center;" width="100px">Perintah</th>
       
            </tr>
        </thead>
		
		<tbody>
			<?php

			
			$no = 1;
			$res = mysql_query("SELECT * FROM `pelanggan`");
			  while($row=mysql_fetch_array($res)){
				   
				echo '
				<tr>
					<td align=center>'.$no.'</td>
					<td >'.$row['nama_lengkap'].'</td>
					<td >'.$row['alamat'].'</td>
					<td >'.$row['no_telp'].'</td>
					<td width=80px align=center><a name="btn_edit" class="btn icon-btn btn-info" href="media.php?module=home&opr=upd-pelanggan&rs_id='.$row['id_pelanggan'].'">
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
		$('#dataTables_pelanggan').DataTable();
	} );
	</script>
	


    </section>
 </form>