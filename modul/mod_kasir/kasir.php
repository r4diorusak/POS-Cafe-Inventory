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

if($opr=="upd"){
	
   
	if ($_SESSION['nama_lengkap']=="" OR $_SESSION['meja']==""){ echo "<div class='alert alert-danger alert-dismissible'><b><i class='fa fa-warning'></i> Pilih Pembeli dan Meja Terlebih Dahulu !</b></div>";
	}else{
   
 $tgl_skrg = date("Ymd"); 
 $sql_coffee=mysql_query("INSERT INTO `orders_temp`(`meja`,`id_menu`,`jumlah`,`status`,`jam`,`tgl_order`,`pelanggan`,`@harga`,`penyedia`) 
					VALUES ('$_SESSION[meja]','$id','1','0',NOW(),'$tgl_skrg','$_SESSION[nama_lengkap]','$price','$penyedia')
					");	
if($sql_coffee==true)
	echo "<script>location='media.php?module=home'</script>";	
	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
	
   }
	
}
	
if($opr=="upd-pelanggan"){
	
		$sql_pl=mysql_query("SELECT * FROM `pelanggan` where id_pelanggan='$id'");
		
		$pl=mysql_fetch_array($sql_pl);
		
		$_SESSION['nama_lengkap']	= $pl['nama_lengkap'];		
		$_SESSION['diskon']	="";
		$sql_plw=mysql_query("UPDATE `orders_temp` SET `pelanggan`='$_SESSION[nama_lengkap]' WHERE meja='$_SESSION[meja]'");
	}
	

if($opr=="upd-meja"){
	
		$sql_pl=mysql_query("SELECT * FROM `meja` where id_meja='$id'");
		$pl=mysql_fetch_array($sql_pl);
	
		  $_SESSION['meja']     = $pl['no_meja'];
		  $_SESSION['lokasi']   = $pl['lokasi'];
		  $_SESSION['diskon']	="";
	}
	
	
if($opr=="del"){
	$del_sql=mysql_query("DELETE FROM orders_temp WHERE id_menu='$id' and meja='$_SESSION[meja]'");
	if($del_sql==true)
	echo "<script>location='media.php?module=home'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}

if($opr=="bersih"){
	$bersih_sql=mysql_query("DELETE FROM orders_temp WHERE tgl_order < CURDATE() and meja='$_SESSION[meja]'");
	if($bersih_sql==true)
	echo "<script>location='media.php?module=home'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}

	 

if($opr=="tambah"){
	
	 $tgl_skrg = date("Ymd"); 
	 $sql_coffee=mysql_query("INSERT INTO `orders_temp`(`meja`,`id_menu`,`jumlah`,`status`,`jam`,`tgl_order`,`pelanggan`,`@harga`,`penyedia`) 
					VALUES ('$_SESSION[meja]','$mn','1','0',NOW(),'$tgl_skrg','$_SESSION[nama_lengkap]','$price','$penyedia')
					");	
	
	if($sql_coffee==true)
	echo "<script>location='media.php?module=home&meja=$_SESSION[meja]'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}

if($opr=="kurang"){
	$del_sql=mysql_query("DELETE FROM orders_temp WHERE no='$id' and meja='$_SESSION[meja]'");
	if($del_sql==true)
	echo "<script>location='media.php?module=home&meja=$_SESSION[meja]'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}


if($opr=="order"){
	$del_sql=mysql_query("TRUNCATE orders_temp");
	if($del_sql==true)
	echo "<script>location='media.php?module=home'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}

if($opr=="invoice"){
if ($_SESSION['tot_bayar']==""){ echo "<div class='alert alert-danger alert-dismissible'><b><i class='fa fa-warning'></i> Pilih Menu  Terlebih dahulu !</b></div>";
   }elseif($_SESSION['nama_lengkap']==""){ echo "<div class='alert alert-danger alert-dismissible'><b><i class='fa fa-warning'></i> Pilih Pembeli / Pelangan Terlebih dahulu !</b></div>";
   }elseif($_SESSION['meja']==""){ echo "<div class='alert alert-danger alert-dismissible'><b><i class='fa fa-warning'></i> Pilih Meja Terlebih dahulu !</b></div>";
   }else{
	
	
	//1
	$tgl_skrg = date("Ymd");
    $jam_skrg = date("H:i:s");
		$sql_inv=mysql_query("INSERT INTO `invoice`(`invoice`, `pelanggan`, `user`, `meja`, `tgl_order`, `jam_order`, `total_bayar`,`diskon`, `pajak`, `jasa`)
					VALUES ('$_SESSION[invoice]','$_SESSION[nama_lengkap]','$_SESSION[namauser]','$_SESSION[meja]','$tgl_skrg','$jam_skrg','$_SESSION[tot_bayar]','$_SESSION[diskon]',0.1,0.025)
					");
					
	$sql_inv_detail=mysql_query("INSERT INTO `invoice_detail`(`invoice`, `id_menu`, `jumlah`,`jam`,`tgl_order`,`waiter`, `@harga`) SELECT '$_SESSION[invoice]', `id_menu`, `jumlah`,`jam`,`tgl_order`,`waiter`,`@harga` FROM orders_temp where meja='$_SESSION[meja]'");
	
	//2				
	$del_2=mysql_query("DELETE FROM orders_temp WHERE meja='$_SESSION[meja]'");			
	//3
	    
        $_SESSION['nama_lengkap']	= "";
		$_SESSION['meja']		= "";
		$_SESSION['lokasi']		= "";
		$_SESSION['diskon']		="";
	if($sql_inv==true)
	echo "<script>location='media.php?module=home&aksi=berhasil&id=$invoice'</script>";	
	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}

}


$sql_hitung=mysql_query("SELECT sum(harga*jumlah) as total_bayar FROM menu a,`orders_temp` b WHERE a.id_menu=b.id_menu and meja='$_SESSION[meja]'
					");				
		 $tb=mysql_fetch_array($sql_hitung);
		 $tdiskon=$tb['total_bayar']*$_SESSION['diskon'];
		 $total_bayar     = number_format(($tb['total_bayar']+($tb['total_bayar']*0.125))-$tdiskon,0, ".", ".");
		
		 $_SESSION['tot_bayar']     = $tb['total_bayar'];
		 
$sql_hitung_lp=mysql_query("SELECT sum(total_bayar) as subtotal FROM invoice where tgl_order=CURDATE()
					");				
		 $stb=mysql_fetch_array($sql_hitung_lp);
		 $total_totbayar     = number_format($stb['subtotal'],0, ".", ".");

$sql_invoice=mysql_query("SELECT max(no)+1 max FROM `invoice`
					");				
		 $inv=mysql_fetch_array($sql_invoice);
		 $invoice = date('dmy').$inv['max'];
		 $_SESSION['id_orders']     = $inv['max']; 
		 $_SESSION['invoice']     = $invoice; 
		 
if(isset($_POST['btn_pulang'])){

	echo "<script>location='media.php?module=home&nama=$_POST[namatxt]'</script>";	
}

?>


<div class="row">
        <!-- left column -->
        <div class="col-md-7">
		
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><img src="images/Coffee_32.png"> Transaksi</h3> <?php //echo $_SESSION['invoice']; ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body col-md-12">
                
					<table border="0">
					<tr>
				
				 
				  <td>
					<a href="#" data-toggle="modal" data-target="#modal_makanan" class="btn btn-default" style="min-width: 110px;border-radius: 0px;"><img src="images/icons/makanan.png"><br><b> Makanan</b></a>
					<a href="#" data-toggle="modal" data-target="#modal_minuman" class="btn btn-default" style="min-width: 110px;border-radius: 0px;"><img src="images/icons/minuman.png"><br><b> Minuman</b></a>
					<a href="#" data-toggle="modal" data-target="#modal_coffee" class="btn btn-default" style="min-width: 110px;border-radius: 0px;"><img src="images/icons/coffee_ico.png"><br><b> Coffee</b></a>
					<a href="#" data-toggle="modal" data-target="#modal_snack" class="btn btn-default" style="min-width: 110px;border-radius: 0px;"><img src="images/icons/snack.png"><br><b> Snack</b></a>
					
						
					</td></tr>
					</table>
			
              </div>
			  
			  
			  
              <!-- /.box-body -->

              
		    <!-- /.tabel -->	
			 <div class="box-body">
			 <table id="dataTables_keranjang" class="table-bordered" height="120px">
	
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
			$res = mysql_query("SELECT no,a.id_menu,menu,a.penyedia,sum(jumlah),harga*sum(jumlah) as total, pelanggan ,jam,tgl_order,harga FROM `menu` a,orders_temp b where a.id_menu=b.id_menu and meja='$_SESSION[meja]' group by menu asc");
			
			  while($row=mysql_fetch_array($res)){
				    $_SESSION['nama_lengkap']=$row['pelanggan'];
				    $link='<a class="btn icon-btn btn-default" href="media.php?module=home&meja='.$_SESSION['meja'].'&penyedia='.$row['penyedia'].'&menu='.$row['id_menu'].'&opr=kurang&rs_id='.$row['no'].'&jam='.$row['jam'].'&tgl='.$row['tgl_order'].'&harga='.$row['harga'].'"><i class="fa  fa-minus"></i></a>';
				    $link2='<a class="btn icon-btn btn-default" href="media.php?module=home&meja='.$_SESSION['meja'].'&penyedia='.$row['penyedia'].'&menu='.$row['id_menu'].'&opr=tambah&rs_id='.$row['no'].'&jam='.$row['jam'].'&tgl='.$row['tgl_order'].'&harga='.$row['harga'].'"><i class="fa fa-plus"></i></a>';
				echo '
				<tr>
					<td align=center>'.$no.'</td>
					<td >'.$row['menu'].'</td>
					<td align=center>Rp.'.number_format($row['total'],0, ".", ".").'</td>
					<td align=center>'.$link,str_repeat("&nbsp;", 3),$row['sum(jumlah)'],str_repeat("&nbsp;", 3),$link2.'</td>
					<td width=80px align=center>
					<a name="btn_hapus" class="btn icon-btn btn-danger" href="media.php?module=home&meja='.$_SESSION['meja'].'&opr=del&rs_id='.$row['id_menu'].'">
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
          <!--  <a href="http://localhost/cafe/media.php?module=home&opr=bersih" class="btn btn-default" style="min-width: 110px;border-radius: 0px;"><span class="glyphicon btn-glyphicon glyphicon-trash img-circle text-default"></span><b> Bersihkan Menu tanggal lama</b></a> -->
		  <p style="font-size:12px;"><a href="http://localhost/cafe/media.php?module=order">*Periksalah Menu pada Meja Order setelah selesai kerja jangan sampai ada yang terlewatkan !</a>
            <br>**Segera Print Orderan baru !, Print order menu baru hanya terbaca selama 10 menit.</p>  
			  </div>
            </form>
			
			
			
			
          </div>
          <!-- /.box -->
		
		<div class="box box-primary">
		  <div class="box-header with-border">
              <h3 class="box-title"><img src="images/bawa_plng_32.png"> Bawa Pulang</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">

              
		    <!-- /.tabel -->	
			 <div class="box-body">
			<?php
			$no = 1;
			$res = mysql_query("SELECT * FROM orders_temp a,meja b where a.meja=b.no_meja and b.lokasi='B.Pulang' group by meja order by status asc");
	
			//$res = mysql_query("SELECT * FROM `menu`");
			  while($rowp=mysql_fetch_array($res)){
																																					
				 $link='<a class="btn icon-btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Tambah Menu" href="media.php?module=home&opr=upd-meja&rs_id='.$rowp['meja'].'"><i class="fa  fa-plus"></i></a>';
				 $link2='';
				 if($rowp['status']==null){   
					$status='';
				 }elseif($rowp['status']==0){   
					$status='';
				 }elseif($rowp['status']==1){   
					$status='';	
				 }		
					
				 $res1=mysql_query("SELECT sum(harga*jumlah) as totbayar FROM orders_temp a, menu b where a.id_menu=b.id_menu and a.meja='$rowp[meja]'");
				   $r=mysql_fetch_array($res1);
				   
				echo '
		
					<div class="col-md-6 col-sm-6 col-xs-12">
						  <div class="info-box2">
						  <a href="media.php?module=p_menu&meja='.$rowp['meja'].'">
							<span class="info-box-icon"><img src="images/bawa_plng.png" height="82" width="90"></span>
						  </a>
							<div class="info-box-content">
							  <span class="info-box-text2">Pembeli: '.$rowp['lokasi'].'</span>
							  <span class="info-box-number2">Rp '.number_format($ppn,0, ".", ".").'</span>'.$status.'

							 <span class="info-box-number pull-right">'.$link2.' </span>
							  <span class="info-box-number pull-right">'.$link.'</span>
							</div>
							<!-- /.info-box-content -->
						  </div>
						  <!-- /.info-box -->
						</div>
				
				';
				$no++;
			
			}
			?>
	

	</div>  
			
            </form>
          </div>
		
		
        </div>
		
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-5">
          <!-- Horizontal Form -->
          <div class="box box-info">
		  <div class="box-header with-border">
	<?php	  
		  echo "
          <div class='info-box bg-aqua'>
            <span class='info-box-icon'><i class='fa fa-calendar'></i></span>

            <div class=info-box-content>
              <span class=info-box-text><b>Transaksi Hari Ini</b></span>
              <span class=info-box-number>$hari_ini</span>

              <div class=progress>
                <div class=progress-bar style=width: 40%></div>
              </div>
                  <span class=progress-description>
                   $tanggal_login
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>";
	?>	  
		  
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method=POST action='modul/mod_laporan/pdf2.php'>
            
            
				</table>  <!-- /.table -->
              
              <!-- /.box-body -->
              <div class="box-footer">
				<div class="table-responsive">
				<table border=0 class="table table-striped">
				<tr>
					<td width="40px"><label>Invoice</td><td width="10px"> #</td><td><?php echo $invoice; ?></label></td><td></td>
				</tr>
				<tr>
					<td width=>Nama</td><td> : </td><td><?php echo $_SESSION['nama_lengkap']; ?></td><td width="30px"><a href="#" data-toggle="modal" data-target="#modal_pelanggan" class="btn btn-default"><span class="glyphicon btn-glyphicon glyphicon-search img-circle text-default"></span><b></b></a>
				</td>
				</tr>
				<tr>
					<td>Meja</td><td> : </td><td><?php echo $_SESSION['meja'].' ('.$_SESSION['lokasi'].')'; ?></td><td width="30px"><a href="#" data-toggle="modal" data-target="#modal_meja" class="btn btn-default"><span class="glyphicon btn-glyphicon glyphicon-search img-circle text-default"></span><b></b></a>
				</td>
				</tr>
				<tr style="background-color: #ffd78c; border:1;">
					<td align="center" colspan="3"><h5><b>Diskon: <?php echo $ket_diskon=($_SESSION['diskon']*100); ?>%</b></h5></td><td><a href="#" data-toggle="modal" data-target="#modal_diskon" class="btn btn-default"><img src="images/diskon.png"><b></b></a></td>
				</tr>
				<tr style="background-color: #ffd78c; border:1;">
					<td align="center" colspan="3"><h5><b>Total: Rp <?php echo $total_bayar; ?>,-</b></h5></td><td></td>
				</tr>
				
				</table>  
				<table border=0 >
				<tr>
				
				<td>
				 <a href="?module=order" class="btn btn-primary icon-btn btn-default pull-left"><span class="fa fa-refresh fa-spin"></span> Meja Order</a>
				</td>
				<td>
				 <a href="#" data-toggle="modal" data-target="#modal_print_order" class="btn btn-primary icon-btn btn-default"><span class="fa fa-print"></span> Print Order</a>
				</td>
				<td>
				<a href="#" data-toggle="modal" data-target="#modal_bayar" class="btn btn-primary icon-btn btn-warning pull-right"><span class="fa fa-credit-card img-circle text-default"></span> Bayar</a>
				</td>
				</table>
			 <!-- /.table -->
              </div>
		
              <!-- /.box-body -->
              <div class="box-footer">
				<div class="table-responsive">
				
					<table id="table_inv" class="table-bordered">
	
        <thead>
            <tr class="blue">
               <th width="20px">NO.</th>
                
                <th>Invoice</th>
				<th>Qty</th>
				
                <th style=" text-align: center;">Total</th>
			
       
            </tr>
        </thead>
		
		<tbody>
			<?php 
			if ($_SESSION['leveluser']=='admin'){
			$no = 1;
			$res = mysql_query("SELECT a.invoice,sum(jumlah),total_bayar,(total_bayar*diskon) ds,(total_bayar*pajak) pj, (total_bayar*jasa) js from invoice a,invoice_detail b,menu c where a.tgl_order=CURDATE() and a.invoice=b.invoice and b.id_menu=c.id_menu GROUP by b.invoice order by a.invoice DESC");
			  while($rowd=mysql_fetch_array($res)){
				  
				echo '
				
				<tr>
					<td align=center>'.$no.'</td>
					<td >
					<a type="submit" target="_blank" class="" href="invoice-print.php?id='.$rowd['invoice'].'"><b>#'.$rowd['invoice'].'</b> </a>
					</td>
					<td align=center ><b>'.$rowd['sum(jumlah)'].'</b> </td>
					<td align=center>Rp. '.number_format($totalx=(($rowd['total_bayar']-$rowd['ds'])+$rowd['pj']+$rowd['js']),0, ".", ".").',-</td>
					
							
					
				</tr>
				';
				$totals = $totals+$totalx;
				$no++;
			  }
			}else{
				$no = 1;
			$res = mysql_query("SELECT a.invoice,sum(jumlah),total_bayar,(total_bayar*diskon) ds,(total_bayar*pajak) pj, (total_bayar*jasa) js from invoice a,invoice_detail b,menu c where user='$_SESSION[namauser]' and a.tgl_order=CURDATE() and a.invoice=b.invoice and b.id_menu=c.id_menu GROUP by b.invoice order by a.invoice DESC");
			  while($rowd=mysql_fetch_array($res)){
				  
				echo '
				
				<tr>
					<td align=center>'.$no.'</td>
					<td >
					<a type="submit" target="_blank" class="" href="invoice-print.php?id='.$rowd['invoice'].'"><b>#'.$rowd['invoice'].'</b> </a>
					</td>
					<td align=center ><b>'.$rowd['sum(jumlah)'].'</b> </td>
					<td align=center>Rp. '.number_format($totalx=(($rowd['total_bayar']-$rowd['ds'])+$rowd['pj']+$rowd['js']),0, ".", ".").',-</td>
					
							
					
				</tr>
				';
				$totals = $totals+$totalx;
				$no++;
			  }
			}
			?>
		</tbody>
	
		
		

	</table>  
				</div>
    
			   <div class="box-footer">
				<div class="table-responsive">
					<table class="table">
					  <tbody>
					  <tr>
						<th style="width:50%">Total:</th>
						<td align='right'>Rp. <?php echo  number_format($totals,0, ".", ".");  ?></td>
				<!--	  </tr>
					   <tr>
						<th style="width:50%">PPN 10%:</th>
						<td align='right'> <?php echo  number_format($ppn=($totals*0.1),0, ".", ".");  ?></td>
					  </tr>
					  <tr>
						<th style="width:50%">Jasa 2.5%:</th>
						<td align='right'> <?php echo  number_format($jasa=($totals*0.025),0, ".", ".");  ?></td>
					  </tr>
					   <tr>
						<th style="width:50%">Total Pendapatan:</th>
						<td align='right'><b>Rp <?php echo  number_format($totals+$ppn+$jasa,0, ".", ".");  ?></b></td>
					  </tr> -->
					 
					  
					  
					</tbody></table>
				</div>
				<?php
				if ($_SESSION['leveluser']=='admin'){
                ?>				
				<a href="invoice-today-print.php?user=<?php echo $_SESSION['namauser']; ?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
               <?php
				}else{
			   ?>			   
			   <a href="invoice-today-print-user.php?user=<?php echo $_SESSION['namauser']; ?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
			   <?php 
				}
			   ?>
              </div>
			   
			   
			   
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
         
        </div>
        <!--/.col (right) -->
      </div>


		
		
		
</div>		


<div class="modal modal-wide2 fade" id="modal_bayar" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-cart-arrow-down"></i> Pembayaran</h4>
              </div>
              <div class="modal-body"> 
	<form name="addem" method="POST" action="media.php?module=home" id="addem" >     
					<div class="callout callout-info">Total Bayar:
                <h4><span class="control-label"><br><b>Rp <?php echo $total_bayar;?></b> </span></h4>
				<hr>
                <p>Kembali: <span id="update"></span></p>
              </div>
			
				<div class="input-group">
                <span class="input-group-addon">Bayar</span>
                <input type="number" class="form-control" placeholder="Bayar" id="tb2" name="tb2txt" onkeyup="calc(this)"/>
				 <input type="hidden" id="total" name="total" value="0" />
              </div>	
			  <br>
				<div class="input-group">
				<span id="update"></span>
			    </div>

              </div>
             <div class="modal-footer">
             
				<a href="media.php?module=home&opr=invoice&id=<?php echo $_SESSION['invoice']; ?>" type="button" class="btn btn-primary">Bayar</a>
              </div>
	</form>			
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>  

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
  
<div class="modal modal-wide fade" id="modal_pelanggan" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pelanggan</h4>
              </div>
              <div class="modal-body">            	   
			   <?php  include "modul/mod_kasir/table_pelanggan.php"; ?>
              </div>
             
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
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
			   <?php  include "modul/mod_kasir/table_meja.php"; ?>
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
			   <?php  include "modul/mod_kasir/table_makanan.php"; ?>
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
			   <?php  include "modul/mod_kasir/table_snack.php"; ?>
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
			   <?php  include "modul/mod_kasir/table_coffee.php"; ?>
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
			   <?php  include "modul/mod_kasir/table_minuman.php"; ?>
              </div>
             
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal modal-wide fade" id="modal_diskon" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Diskon</h4>
              </div>
              <div class="modal-body">            	   
				   <form method='post' class='col-md-12' enctype='multipart/form-data' action="cek_diskon.php" >          
               	<div class="form-group">		
				<?php
				echo "<tr>
					  <select name='diskontxt' class='form-control' required/>
							<option value=0>-Pilih Diskon-</option>";
							$tampil=mysql_query("SELECT * FROM diskon order by no asc");
							while($r=mysql_fetch_array($tampil)){
							  echo "<option value=$r[diskon]>$r[keterangan]</option>";
							}
				echo "</select>";		
				?>
				</div>
				 <div class="form-group">
                    <input type="password" class="form-control" name="kodetxt" placeholder="kode diskon" required/>
                </div>
            
                
		   
				
		
           <!-- Modal akhir-->
	
        </div>
        <div class="modal-footer">
          <input type="submit" name="btn_sub" value="Simpan" class="btn btn-primary"/>
        </div>
      
      </form> 
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
	

		$('#table_inv').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
		
		
		;
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
            
            z = y - <?php echo ($tb['total_bayar'])+($tb['total_bayar']*0.125);?>;
            document.getElementById('total').value = 'Rp '+formatter.format(z);
            document.getElementById('update').innerHTML = 'Rp '+formatter.format(z);
        }
    </script>