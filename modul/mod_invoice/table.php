 <form class="form-horizontal" method=POST action='modul/mod_laporan/pdf3.php'>
	<div class='box-body'>
    <table id="dataTables_pegawai" class="table-bordered" style="width:100%;">
	
        <thead>
            <tr class="blue">
               <th width="20px">NO.</th>
                <th>Invoice</th>
                <th>Tanggal</th>
				<th>Jam</th>
				<th>Total</th>
				
				<th style=" text-align: center;" width="100px">Perintah</th>
       
            </tr>
        </thead>
		
		<tbody>
			<?php

			
			$no = 1;
			$res = mysql_query("SELECT invoice,tgl_order,jam_order,sum(total_bayar) as totbayar, (total_bayar*diskon) ds,(total_bayar*pajak) pj, (total_bayar*jasa) js FROM `invoice` group by invoice order by tgl_order desc,jam_order desc");
			//$res = mysql_query("SELECT * FROM `menu`");
			  while($row=mysql_fetch_array($res)){
				 
				echo '
				<tr>
					<td align=center>'.$no.'</td>
					<td >#'.$row['invoice'].'</td>
					<td align=center>'.$row['tgl_order'].'</td>
					<td align=center>'.$row['jam_order'].'</td>
					
					<td align=center>Rp. '.number_format($totalx=(($row['totbayar']-$row['ds'])+$row['pj']+$row['js']),0, ".", ".").'</td>
					<td width=80px align=center><a type="submit" target="_blank" class="btn icon-btn btn-info" href="invoice-print.php?id='.$row['invoice'].'">
<span class="glyphicon btn-glyphicon glyphicon-print img-circle text-default"></span>
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
		$('#dataTables_pegawai').DataTable();
	} );
	</script>
	


    </section>
 </form>
 
 
 