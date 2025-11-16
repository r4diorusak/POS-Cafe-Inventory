<?php
error_reporting(0);

$id="";
$mn="";
$opr="";
$aksi="";

$pegawai="";

if(isset($_GET['opr']))

	$opr=$_GET['opr'];

if(isset($_GET['rs_id']))
	$id=$_GET['rs_id'];
if(isset($_GET['id']))
	$invoice=$_GET['id'];
if(isset($_GET['rs_menu']))
	$mn=$_GET['rs_menu'];
if(isset($_GET['aksi']))
	$aksi=$_GET['aksi'];

//===================================================================
if($opr=="meja"){
$cari=mysql_query("SELECT * FROM orders WHERE meja='$_SESSION[meja]'");
$ketemu=mysql_num_rows($cari);

 if ($_SESSION['tot_bayar']==""){ echo "<div class='alert alert-danger alert-dismissible'><b><i class='fa fa-warning'></i> Pilih Menu Terlebih Dahulu !</b></div>";
}else if ($ketemu > 0){
	
	$sql_inv=mysql_query("INSERT INTO orders_detail SELECT * FROM orders_temp");
	$del_sql=mysql_query("TRUNCATE orders_temp");	
	$del_sql=mysql_query("UPDATE `orders` SET `total_bayar`='$_SESSION[tot_bayar_upd]' WHERE meja='$_SESSION[meja]'");
}else{
	
	$tgl_skrg = date("Ymd");
    $jam_skrg = date("H:i:s");
	$sql_inv=mysql_query("INSERT INTO `orders`(`meja`, `tgl_order`, `jam_order`,`total_bayar`)
					VALUES ('$_SESSION[meja]','$tgl_skrg','$jam_skrg','$_SESSION[tot_bayar]')
					");	
					
	$sql_inv=mysql_query("INSERT INTO orders_detail SELECT * FROM orders_temp");
	
   //
    
	if($sql_inv==true){
	//2				
	$del_sql=mysql_query("TRUNCATE orders_temp");				
	//3
	$_SESSION['meja']    = "";
		

	
	echo "<script>location='media.php?module=home&aksi=berhasil</script>";	
	
	}else{
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
	}
	
}
}
//=======================================================================
if($opr=="invoice"){
	$tgl_skrg = date("Ymd");
    $jam_skrg = date("H:i:s");
	$sql_inv=mysql_query("INSERT INTO `invoice`(`invoice`, `meja`, `tgl_order`, `jam_order`,`total_bayar`)
					VALUES ('$_SESSION[invoice]','$_SESSION[meja]','$tgl_skrg','$jam_skrg','$_SESSION[sub_totbayar]')
					");	
					
    
	$sql_inv_detail=mysql_query("INSERT INTO invoice_detail(invoice,id_menu,jumlah) SELECT '$_SESSION[invoice]',id_menu,jumlah FROM orders_temp where meja='$_SESSION[meja]'");
	
	if($sql_inv==true){
	$del_2=mysql_query("DELETE FROM orders_temp WHERE meja='$_SESSION[meja]'");
	echo "<script>location='media.php?module=home&aksi=berhasil&id=$invoice'</script>";	
	
	}else{
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
	}

}

  if(isset($_POST['btn_pulang'])){

	echo "<script>location='media.php?module=bw_pulang&meja=$_POST[namatxt]'</script>";	
}

?>


<div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
           <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="fa fa-th-large fa-lg"></i>

              <h3 class="box-title">Meja Dalam</h3>

              
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">

              
		    <!-- /.tabel -->	
			 <div class="box-body">
			<?php
			$no = 1;
			$res = mysql_query("SELECT * FROM meja LEFT JOIN orders_temp ON meja.id_meja = orders_temp.meja WHERE id_meja > 0 and lokasi='dalam' group by meja.id_meja order by meja.id_meja asc");
			
			//$res = mysql_query("SELECT * FROM `menu`");
			  while($row=mysql_fetch_array($res)){
																																		
				    $link='<a class="btn icon-btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Tambah Menu" href="media.php?module=home&opr=upd-meja&rs_id='.$row['no_meja'].'"><i class="fa  fa-plus"></i></a>';
				    $link2='';
					//$status='<a class="btn icon-btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Sedang Dibuat" ><i class="fa fa-refresh fa-spin"></i></a>';
					if($row['status']==null){   
					$status='';
					 }elseif($row['status']==0){   
						$status='style="background: #f39c12;"';	
					 }elseif($row['status']==1){   
						$status='style="background: #52BE80;"';	
					 }		
					
				   $res1=mysql_query("SELECT sum(harga*jumlah) as totbayar FROM `meja` a,orders_temp b,menu c where a.no_meja=b.meja and b.id_menu=c.id_menu and a.no_meja=$row[no_meja]");
				   $r=mysql_fetch_array($res1);
				   $ppn= $r['totbayar'];//+($r['totbayar']*0.10);
				echo '
		
					<div class="col-md-4 col-sm-6 col-xs-12">
						  <div class="info-box2">
							<span class="info-box-icon" '.$status.'><img src="images/meja.png" height="82" width="90"></span>

							<div class="info-box-content">
							  <span class="info-box-text2">Meja '.$row['no_meja'].'</span>
							  <span class="info-box-number2">Rp '.number_format($ppn,0, ".", ".").'</span>
							 
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
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
       
      </div>
	  
	  
	  
<div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
           <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="fa fa-th-large fa-lg"></i>

              <h3 class="box-title">Meja Luar</h3>

              
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">

              
		    <!-- /.tabel -->	
			 <div class="box-body">
			<?php
			$no = 1;
			$res = mysql_query("SELECT * FROM meja LEFT JOIN orders_temp ON meja.id_meja = orders_temp.meja WHERE id_meja > 0 and lokasi='luar' group by meja.id_meja order by meja.id_meja asc");
	
			//$res = mysql_query("SELECT * FROM `menu`");
			  while($row=mysql_fetch_array($res)){
																																		
				    $link='<a class="btn icon-btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Tambah Menu" href="media.php?module=home&opr=upd-meja&rs_id='.$row['no_meja'].'"><i class="fa  fa-plus"></i></a>';
				    $link2='';
					//$status='<a class="btn icon-btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Sedang Dibuat" ><i class="fa fa-refresh fa-spin"></i></a>';
					if($row['status']==null){   
					$status='';
					 }elseif($row['status']==0){   
						$status='style="background: #f39c12;"';	
					 }elseif($row['status']==1){   
						$status='style="background: #52BE80;"';	
					 }			
					
				   $res1=mysql_query("SELECT sum(harga*jumlah) as totbayar FROM `meja` a,orders_temp b,menu c where a.no_meja=b.meja and b.id_menu=c.id_menu and a.no_meja=$row[no_meja]");
				   $r=mysql_fetch_array($res1);
				   $ppn= $r['totbayar'];//+($r['totbayar']*0.10);
				echo '
		
					<div class="col-md-4 col-sm-6 col-xs-12">
						  <div class="info-box2">
							<span class="info-box-icon" '.$status.'><img src="images/meja.png" height="82" width="90"></span>

							<div class="info-box-content">
							  <span class="info-box-text2">Meja '.$row['no_meja'].'</span>
							  <span class="info-box-number2">Rp '.number_format($ppn,0, ".", ".").'</span>
							 
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
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
       
      </div>


<div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
           <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="fa fa-th-large fa-lg"></i>

              <h3 class="box-title">Meja Meeting</h3>

              
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">

              
		    <!-- /.tabel -->	
			 <div class="box-body">
			<?php
			$no = 1;
			$res = mysql_query("SELECT * FROM meja LEFT JOIN orders_temp ON meja.id_meja = orders_temp.meja WHERE id_meja > 0 and lokasi='R.Meeting' group by meja.id_meja order by meja.id_meja asc");
	
			//$res = mysql_query("SELECT * FROM `menu`");
			  while($row=mysql_fetch_array($res)){
																																		
				    $link='<a class="btn icon-btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Tambah Menu" href="media.php?module=home&opr=upd-meja&rs_id='.$row['no_meja'].'"><i class="fa  fa-plus"></i></a>';
				    $link2='';
					//$status='<a class="btn icon-btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Sedang Dibuat" ><i class="fa fa-refresh fa-spin"></i></a>';
					if($row['status']==null){   
					$status='';
					  }elseif($row['status']==0){   
						$status='style="background: #f39c12;"';	
					 }elseif($row['status']==1){   
						$status='style="background: #52BE80;"';	
					 }		
					
				   $res1=mysql_query("SELECT sum(harga*jumlah) as totbayar FROM `meja` a,orders_temp b,menu c where a.no_meja=b.meja and b.id_menu=c.id_menu and a.no_meja=$row[no_meja]");
				   $r=mysql_fetch_array($res1);
				   $ppn= $r['totbayar'];//+($r['totbayar']*0.10);
				echo '
		
					<div class="col-md-4 col-sm-6 col-xs-12">
						  <div class="info-box2">
							<span class="info-box-icon" '.$status.'><img src="images/meja.png" height="82" width="90"></span>

							<div class="info-box-content">
							  <span class="info-box-text2">Meja '.$row['no_meja'].'</span>
							  <span class="info-box-number2">Rp '.number_format($ppn,0, ".", ".").'</span>
							 
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
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
       
      </div>	  

<div class="modal modal-wide fade" id="modal_bantuan" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Bantuan</h4>
              </div>
              <div class="modal-body">            	   
			  <img src="images/waiter.jpg" class="img" width="100%">
              </div>
             
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<!-- Modal -->
  <div class="modal fade" id="modal_bw_pulang" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Nama Pembeli</h4>
        </div>
        <div class="modalc-body">
          	   
		 <!-- Modal mulai-->
           <form method='post' class='col-md-12' enctype='multipart/form-data' name='addroomS'>
				<br>   
              <div class="calloutc">
				 <div class="form-group">	
					<input type="text" class="form-control" name="namatxt" placeholder="Nama" required/>
				</div>

              </div>

           <!-- Modal akhir-->
	
        </div>
        <div class="modal-footer">
          <input type="submit" name="btn_pulang" value="Pesan" class="btn btn-primary"/>
        </div>
      </div>
      </form> 
    </div>
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