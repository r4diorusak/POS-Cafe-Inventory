<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
$id="";
$mn="";
$opr="";
$aksi="";

$pegawai="";

if(isset($_POST['kodetxt']))
	echo $kode_diskon=$_POST['kodetxt'];
if(isset($_GET['opr']))
	$opr=$_GET['opr'];
if(isset($_GET['rs_id']))
	$id=$_GET['rs_id'];
if(isset($_GET['harga']))
	$price=$_GET['harga'];
if(isset($_GET['penyedia']))
	$penyedia=$_GET['penyedia'];
if(isset($_GET['id']))
	$invoice=$_GET['id'];
if(isset($_GET['menu']))
	$mn=$_GET['menu'];
if(isset($_GET['aksi']))
	$aksi=$_GET['aksi'];
if(isset($_GET['diskon']))
	 $_SESSION['diskon']=$_GET['diskon'];
 
if(isset($_GET['jam']))
	$jam=$_GET['jam'];
if(isset($_GET['tgl']))
	$tgl=$_GET['tgl'];


  $_SESSION['meja']	= $_GET['meja'];

if($opr=="upd"){
	
 $tgl_skrg = date("Ymd"); 
 $sql_coffee=mysql_query("INSERT INTO `orders_temp`(`meja`,`id_menu`,`jumlah`,`status`,`jam`,`tgl_order`,`waiter`,`@harga`,`penyedia`) 
					VALUES ('$_SESSION[meja]','$id','1','0',NOW(),'$tgl_skrg','$_SESSION[namauser]','$price','$penyedia')
					");	
if($sql_coffee==true)
	echo "<script>location='media.php?module=p_menu&meja='$_SESSION[meja]'</script>";	
	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
	
   
	
}
	

if($opr=="del"){
	$del_sql=mysql_query("DELETE FROM orders_temp WHERE id_menu='$id' and meja='$_SESSION[meja]'");
	if($del_sql==true)
	echo "<script>location='media.php?module=p_menu&meja=$_SESSION[meja]'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}

if($opr=="bersih"){
	$bersih_sql=mysql_query("DELETE FROM orders_temp WHERE tgl_order < CURDATE() and meja='$_SESSION[meja]'");
	if($bersih_sql==true)
	echo "<script>location='media.php?module=p_menu&meja=$_SESSION[meja]'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}

	 

if($opr=="tambah"){
	
	 $tgl_skrg = date("Ymd"); 
	 $sql_coffee=mysql_query("INSERT INTO `orders_temp`(`meja`,`id_menu`,`jumlah`,`status`,`jam`,`tgl_order`,`waiter`,`@harga`,`penyedia`) 
					VALUES ('$_SESSION[meja]','$mn','1','0',NOW(),'$tgl_skrg','$_SESSION[namauser]','$price','$penyedia')
					");	
	
	if($sql_coffee==true)
	echo "<script>location='media.php?module=p_menu&meja=$_SESSION[meja]'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}

if($opr=="kurang"){
	$del_sql=mysql_query("DELETE FROM orders_temp WHERE no='$id' and meja='$_SESSION[meja]'");
	if($del_sql==true)
	echo "<script>location='media.php?module=p_menu&meja=$_SESSION[meja]'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}


$sql_hitung_lp=mysql_query("SELECT sum(harga*jumlah) as totbayar FROM `meja` a,orders_temp b,menu c where a.no_meja=b.meja and b.id_menu=c.id_menu and a.no_meja=$_SESSION[meja]
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
					<h4>Meja  : <?php echo $_SESSION['meja']; ?></h4>
				
					<!-- /.col -->
					<table border=0 class="table table-striped">
				
				
				<tr style="background-color: #ffd78c; border:1;">
					<td align="center" colspan="2"><h5><b>Total: Rp <?php echo $total_totbayar;; ?>,-</b></h5></td><td></td>
				</tr>
				
				</table>  
				
				  </div>
				
			
			
				<div class="form-group">
					
					 <div class="col-md-10">
					<a href="#" data-toggle="modal" data-target="#modal_makanan" class="btn btn-default" style="min-width: 110px;border-radius: 0px;"><span class="glyphicon btn-glyphicon glyphicon-search img-circle text-default"></span><b> Makanan</b></a>
					<a href="#" data-toggle="modal" data-target="#modal_minuman" class="btn btn-default" style="min-width: 110px;border-radius: 0px;"><span class="glyphicon btn-glyphicon glyphicon-search img-circle text-default"></span><b> Minuman</b></a>
					<a href="#" data-toggle="modal" data-target="#modal_coffee" class="btn btn-default" style="min-width: 110px;border-radius: 0px;"><span class="glyphicon btn-glyphicon glyphicon-search img-circle text-default"></span><b> Coffee</b></a>
					<a href="#" data-toggle="modal" data-target="#modal_snack" class="btn btn-default" style="min-width: 110px;border-radius: 0px;"><span class="glyphicon btn-glyphicon glyphicon-search img-circle text-default"></span><b> Snack</b></a>
					 </div>
					 <div class="col-md-2">	
					<a href="media.php?module=home" type="button" class="btn btn-primary pull-right"><span class="glyphicon btn-glyphicon glyphicon-floppy-save img-circle text-default"></span> Selesai</a>
					
					<?php if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir'){ ?>
					<!-- <a class="btn icon-btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Print Menu" href="menu-print.php?meja=<?php echo $_SESSION['meja'];?>" target="_blank"><span class="glyphicon btn-glyphicon glyphicon glyphicon-print img-circle text-default"></span> Print</a>
					  -->
					<?php } ?> 
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
			$res = mysql_query("SELECT no,a.id_menu,a.penyedia,menu,sum(jumlah),harga*sum(jumlah) as total, pelanggan ,jam,tgl_order,harga FROM `menu` a,orders_temp b where a.id_menu=b.id_menu and meja='$_SESSION[meja]' group by menu asc");
			
			  while($row=mysql_fetch_array($res)){
				    $_SESSION['nama_lengkap']=$row['pelanggan'];
				    $link='<a class="btn icon-btn btn-default" href="media.php?module=p_menu&meja='.$_SESSION['meja'].'&penyedia='.$row['penyedia'].'&menu='.$row['id_menu'].'&opr=kurang&rs_id='.$row['no'].'&jam='.$row['jam'].'&tgl='.$row['tgl_order'].'&harga='.$row['harga'].'"><i class="fa  fa-minus"></i></a>';
				    $link2='<a class="btn icon-btn btn-default" href="media.php?module=p_menu&meja='.$_SESSION['meja'].'&penyedia='.$row['penyedia'].'&menu='.$row['id_menu'].'&opr=tambah&rs_id='.$row['no'].'&jam='.$row['jam'].'&tgl='.$row['tgl_order'].'&harga='.$row['harga'].'"><i class="fa fa-plus"></i></a>';
				echo '
				<tr>
					<td align=center>'.$no.'</td>
					<td >'.$row['menu'].'</td>
					<td align=center>Rp.'.number_format($row['total'],0, ".", ".").'</td>
					<td align=center>'.$link,str_repeat("&nbsp;", 3),$row['sum(jumlah)'],str_repeat("&nbsp;", 3),$link2.'</td>
					<td width=80px align=center>
					<a name="btn_hapus" class="btn icon-btn btn-danger" href="media.php?module=p_menu&meja='.$_SESSION['meja'].'&opr=del&rs_id='.$row['id_menu'].'">
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
              
              </div>
            </form>
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
      

<!-- Modal -->
  <div class="modal fade" id="modal_print_order" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Print Order</h4>
        </div>
        <div class="modalc-body">
          	   
		 <!-- Modal mulai-->
		 
		 <table border=0><tr>
         <td align="center"><a href="menu-print-dapur.php?meja=<?php echo $_SESSION['meja']; ?>" target="_blank"><img src="images/Dapur1.jpg" class="img img-responsive" title="Dapur"></a></td>
		 <td align="center"><a href="menu-print-bar.php?meja=<?php echo $_SESSION['meja']; ?>" target="_blank"><img src="images/Bar1.jpg" class="img img-responsive" title="Bar"></a></td>
		 </tr></table>
		
		<br>
           <!-- Modal akhir-->
	
        </div>
       
      </div>

    </div>
  </div>
  


<div class="modal modal-wide fade" id="modal_meja" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Meja</h4>
              </div>
              <div class="modal-body">            	   
			   <?php  include "modul/mod_order/table_meja.php"; ?>
              </div>
             
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>  
	  
	  
<div class="modal modal-wide fade" id="modal_makanan" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Menu Makanan </h4>
              </div>
              <div class="modal-body">            	   
			   <?php  include "modul/mod_order/table_makanan.php"; ?>
              </div>
             
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal modal-wide fade" id="modal_snack" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Menu Snack </h4>
              </div>
              <div class="modal-body">            	   
			   <?php  include "modul/mod_order/table_snack.php"; ?>
              </div>
             
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal modal-wide fade" id="modal_coffee" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Menu Coffee</h4>
              </div>
              <div class="modal-body">            	   
			   <?php  include "modul/mod_order/table_coffee.php"; ?>
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
                <h4 class="modal-title">Menu Minuman</h4>
              </div>
              <div class="modal-body">            	   
			   <?php  include "modul/mod_order/table_minuman.php"; ?>
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