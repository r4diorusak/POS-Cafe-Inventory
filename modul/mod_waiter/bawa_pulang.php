<?php
error_reporting(0);

$id="";
$mn="";
$opr="";
$aksi="";



if(isset($_GET['opr']))
	$opr=$_GET['opr'];

if(isset($_GET['rs_id']))
	$id=$_GET['rs_id'];
if(isset($_GET['id']))
	$meja=$_GET['id'];

if(isset($_GET['rs_menu']))
	$mn=$_GET['rs_menu'];
if(isset($_GET['aksi']))
	$aksi=$_GET['aksi'];


  $_SESSION['meja']	= $_GET['meja'];

if($opr=="upd"){
	
$sql_pangkas=mysql_query("INSERT INTO `orders_temp`(`meja`,`id_menu`,`jumlah`,`point`) 
					VALUES ('$_SESSION[meja]','$id','1','1')
					");	
if($sql_pangkas==true)
	echo "<script>location='media.php?module=bw_pulang&meja=$_SESSION[meja]</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
	
	}
	

if($opr=="del"){
	$del_sql=mysql_query("DELETE FROM orders_temp WHERE no='$id'");
	if($del_sql==true)
	echo "<script>location='media.php?module=bw_pulang&meja=$_SESSION[meja]'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}

if($opr=="tambah"){
	$del_sql=mysql_query("UPDATE `orders_temp` SET `jumlah`=(jumlah)+1 WHERE no='$id'");
	if($del_sql==true)
	echo "<script>location='media.php?module=bw_pulang&meja=$_SESSION[meja]'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}

if($opr=="kurang"){
	$del_sql=mysql_query("UPDATE `orders_temp` SET `jumlah`=if (jumlah<=1,1,(jumlah)-1) WHERE no='$id'");
	if($del_sql==true)
	echo "<script>location='media.php?module=bw_pulang&meja=$_SESSION[meja]'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}



if($opr=="del-all"){
	$del_sql=mysql_query("TRUNCATE orders_temp");
	if($del_sql==true)
	echo "<script>location='media.php?module=bw_pulang&meja=$_SESSION[meja]&aksi=berhasil'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}

$sql_hitung_lp=mysql_query("SELECT sum(harga*jumlah) as totbayar FROM orders_temp a, menu b where a.id_menu=b.id_menu and a.meja='$_SESSION[meja]'
					");				
		 $stb=mysql_fetch_array($sql_hitung_lp);
		 $total_totbayar     = number_format($stb['totbayar'],0, ".", ".");
		 $_SESSION['sub_totbayar']     = $stb['totbayar'];
		   
		 $ppn=($stb['totbayar']*0.10);

?>


<div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Transaksi</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
               
				
				<div class="invoice-info">
					
					<!-- /.col -->
					<div class="col-sm-4 invoice-col">
					<h4> Pembeli: <?php echo $_SESSION['meja']; ?></h4>
					  
					  
					 <b>Total Bayar: Rp <?php echo   $total_totbayar; ?> </b><br>
					<!-- <b>PPN 10%: Rp <?php //echo   number_format($ppn,0, ".", "."); ?> </b><br> -->
					<br></div>
					<!-- /.col -->
				
				  </div>
				
			
			
				<div class="form-group">
					
					 <div class="col-md-10">
						 <a href="#" data-toggle="modal" data-target="#modal_makanan" class="btn btn-primary icon-btn btn-info"><i class="fa fa-cutlery"></i> Makanan</a>
						 <a href="#" data-toggle="modal" data-target="#modal_minuman" class="btn btn-primary icon-btn btn-info"><i class="fa fa-coffee"></i>  Minuman</button></a>
						 <a href="#" data-toggle="modal" data-target="#modal_softdrink" class="btn btn-primary icon-btn btn-info"><i class="fa fa-beer"></i> Soft Drink</button></a>
					 	 <a href="#" data-toggle="modal" data-target="#modal_jus" class="btn btn-primary icon-btn btn-info"><i class="fa fa-coffee"></i> Jus</button></a>
						 <a href="#" data-toggle="modal" data-target="#modal_paket" class="btn btn-primary icon-btn btn-info"><i class="fa fa-gift"></i> Paket</button></a>
					 </div>
					 <div class="col-md-2">	
					<a href="media.php?module=home" type="button" class="btn btn-primary pull-right"><span class="glyphicon btn-glyphicon glyphicon-floppy-save img-circle text-default"></span> Selesai</a>
					<!--<a class="btn icon-btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Print Menu" href="menu-print.php?meja=<?php echo $_SESSION['meja'];?>" target="_blank"><span class="glyphicon btn-glyphicon glyphicon glyphicon-print img-circle text-default"></span> Print</a> -->
					 </div>
				</div>
              </div>
			  
			  
			  
              <!-- /.box-body -->

              
		    <!-- /.tabel -->	
			 <div class="box-body">
			 <table id="dataTables_keranjang" class="table-bordered">
	
        <thead>
            <tr class="blue">
               <th width="20px">NO.</th>
                
                <th>Keterangan</th> 
				<th style=" text-align: center;">Harga</th>
				<th style=" text-align: center; width:120px;">Jumlah</th>
				
               
				<th style=" text-align: center;" width="40px">Aksi</th>
       
            </tr>
        </thead>
		
		<tbody>
			<?php
			$no = 1;
			$res = mysql_query("SELECT no,menu,meja,jumlah,harga*jumlah as total FROM `menu` a,orders_temp b where a.id_menu=b.id_menu and meja='$_SESSION[meja]' order by b.meja DESC");
			//$res = mysql_query("SELECT * FROM `menu`");

			  while($row=mysql_fetch_array($res)){
				    $link='<a class="btn icon-btn btn-default" href="media.php?module=bw_pulang&meja='.$_SESSION['meja'].'&menu='.$row['id_menu'].'&opr=kurang&rs_id='.$row['no'].'"><i class="fa  fa-minus"></i></a>';
				    $link2='<a class="btn icon-btn btn-default" href="media.php?module=bw_pulang&meja='.$_SESSION['meja'].'&menu='.$row['id_menu'].'&opr=tambah&rs_id='.$row['no'].'"><i class="fa fa-plus"></i></a>';
				echo '
				<tr>
					<td align=center>'.$no.'</td>
					<td >'.$row['menu'].'</td>
					<td align=center>Rp.'.number_format($row['total'],0, ".", ".").'</td>
					<td align=center>'.$link,str_repeat("&nbsp;", 3),$row['jumlah'],str_repeat("&nbsp;", 3),$link2.'</td>
					<td width=80px align=center>
					<a name="btn_hapus" class="btn icon-btn btn-danger" href="media.php?module=bw_pulang&meja='.$_SESSION['meja'].'&opr=del&rs_id='.$row['no'].'">
<span class="glyphicon btn-glyphicon glyphicon-trash img-circle text-default"></span>
</a>


</td>
							
					
				</tr>
				';
				$total = $total+ $row[total];
				$no++;
				
			}
				
			?>
		</tbody>

	</table></div>  <!-- /.table -->
			<div class="box-footer">
              <a href="media.php?module=bw_pulang&meja=<?php echo $_SESSION[meja]; ?>&opr=del-all" type="submit" class="btn btn-danger icon-btn btn-success"><span class="glyphicon btn-glyphicon glyphicon-trash img-circle text-default"></span> Kosongkan Keranjang</a>
              </div>
            </form>
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
      


	  
<div class="modal modal-wide fade" id="modal_makanan" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Makanan</h4>
              </div>
              <div class="modal-body">            	   
			   <?php  include "modul/mod_waiter/table_menu.php"; ?>
              </div>
             
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal modal-wide fade" id="modal_minuman" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">minuman</h4>
              </div>
              <div class="modal-body">            	   
			   <?php  include "modul/mod_waiter/table_minuman.php"; ?>
              </div>
             
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal modal-wide fade" id="modal_softdrink" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Soft Drink</h4>
              </div>
              <div class="modal-body">            	   
			   <?php  include "modul/mod_waiter/table_softdrink.php"; ?>
              </div>
             
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal modal-wide fade" id="modal_jus" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Jus</h4>
              </div>
              <div class="modal-body">            	   
			   <?php  include "modul/mod_waiter/table_jus.php"; ?>
              </div>
             
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal modal-wide fade" id="modal_paket" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Paket</h4>
              </div>
              <div class="modal-body">            	   
			   <?php  include "modul/mod_waiter/table_paket.php"; ?>
              </div>
             
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal modal-wide fade" id="modal_produk" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Produk</h4>
              </div>
              <div class="modal-body">            	   
			   <?php  include "modul/mod_waiter/table_produk.php"; ?>
              </div>
             
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

		

	  

<script src="assets/bootstrap/js/jquery-1.12.0.min.js"></script>
<script src="assets/bootstrap/js/jquery.dataTables.min.js"></script>
	<script>
	$(document).ready(function() {
		$('#dataTables_keranjang').DataTable();
	} );
	$(document).ready(function() {
		$('#dataTables').DataTable();
	} );
	
	</script>
	
 <script>
 const formatter = new Intl.NumberFormat('de-DE', {
  style: 'decimal',
  decimal: 'Rp',
  minimumFractionDigits: 0
})

//formatter.format(1000) // "$1,000.00"
//formatter.format(10) // "$10.00"
//formatter.format(123233000) // "$123,233,000.00"
 
 
 
        var x = 0;
        var y = 0;
        var z = 0;
        function calc(obj) {
            var e = obj.id.toString();
            
                x = Number(document.getElementById('tb2').value);
                y = Number(obj.value);
            
            z = <?php echo $tb['total_bayar'];?> - y;
            document.getElementById('total').value = 'Rp '+formatter.format(z);
            document.getElementById('update').innerHTML = 'Rp '+formatter.format(z);
        }
    </script>