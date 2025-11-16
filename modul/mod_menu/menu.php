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
if(isset($_GET['rs_menu']))
	$mn=$_GET['rs_menu'];
if(isset($_GET['aksi']))
	$aksi=$_GET['aksi'];

if($aksi=="berhasil"){
		
echo "<div class='alert alert-success'>Berhasi</div>";
	}
	
//--------------Add data-----------------	
if(isset($_POST['btn_sub'])){
	
	$n_menu=$_POST['menutxt'];
	$n_kategori=$_POST['kategoritxt'];
	$n_jenis=$_POST['jenistxt'];
	$n_penyedia=$_POST['penyediatxt'];
	$n_gbr="photos/menu/" . $_FILES["imgmenu"]["name"];
	$n_harga=$_POST['hargatxt'];
						
$sql_ins=mysql_query("INSERT INTO `menu`(`menu`, `kategori`, `jenis`, `penyedia`, `gambar`, `harga`) 
					VALUES ('$n_menu','$n_kategori','$n_jenis','$n_penyedia','$n_gbr','$n_harga')
					");
$sql_persediaan=mysql_query("INSERT INTO persediaan (id_menu) SELECT max(id_menu) FROM menu
					");
					
if($sql_ins==true)
	echo "<script>location='media.php?module=menu&aksi=berhasil'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
	
}


//------------------update data----------
if(isset($_POST['btn_rubah'])){
	
	$n_menu=$_POST['menutxt'];
	$n_kategori=$_POST['kategoritxt'];
	$n_jenis=$_POST['jenistxt'];
	$n_penyedia=$_POST['penyediatxt'];
	$n_harga=$_POST['hargatxt'];
	
	if(empty($_FILES['imgmenu']['name'])){
	$n_gbr=$_POST['imgoritxt'];
	}else{
	$n_gbr="photos/menu/" . $_FILES["imgmenu"]["name"];
	}
	$sql_update=mysql_query("UPDATE `menu` SET 
							`menu`='$n_menu',
							`kategori`='$n_kategori',
							`jenis`='$n_jenis',
							`penyedia`='$n_penyedia',
							`gambar`='$n_gbr',
							`harga`='$n_harga'						
							WHERE 
								`id_menu`='$id'
							");
																					
							
	if($sql_update==true)
	echo "<script>location='media.php?module=menu&aksi=berhasil'</script>";	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
	}
	
if(isset($_POST['btn_del'])){
	
	$del_sql=mysql_query("DELETE FROM menu WHERE id_menu='$id'");
	$del_sqlp=mysql_query("DELETE FROM persediaan WHERE id_menu='$id'");
	if($del_sql==true)
		
	
	echo "<script>location='media.php?module=menu&aksi=berhasil'</script>";	
	
else
	echo "<div class='alert alert-error'>Gagal Ulangi Lagi !!!</div>";	
}

	
?>


<!-- form start -->

<div class='box box-primary'>
		  <div class='box-header'> 
<a class="btn icon-btn btn-primary" href="#" data-toggle="modal" data-target="#modal_simpan">
<span class="glyphicon btn-glyphicon glyphicon-plus img-circle text-default"></span>
Tambah
</a></div>

           <!-- end isi -->
         <?php include "modul/mod_menu/table.php"; ?> 
</div>
	 


  <!-- Modal -->
 <div id="modal_delete" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hapus</h4>
            </div>
            <div class="modal-body">
                <form method="post">
				  <div class="calloutc">
					<?php 
					
					
					
					echo "<span><b>Hapus ?</b></span>"; 
					
					
					?>
					</div>
                    <div class="modal-footer">
					<input type="submit" name="btn_del" value="Hapus" class="btn btn-danger"/>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>

                               		
   <!-- Modal -->
      
	  
<!-- Modal -->
  <div class="modal fade" id="modal_simpan" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Menu</h4>
        </div>
        <div class="modalc-body">
          	   
		 <!-- Modal mulai-->
           <form method='post' class='col-md-12' enctype='multipart/form-data' name='addroomS'>
				<br>   
              <div class="calloutc">
				 <div class="form-group">	
					<input type="text" class="form-control" name="menutxt" placeholder="Nama Menu" required/>
				</div>
				 <div class="form-group">
					
					<input type='file' name='imgmenu' class='form-control' >
				</div>
				
				
                
               	<div class="form-group">		
				<?php
				echo "<tr>
					  <select name='kategoritxt' class='form-control' required/>
							<option value=1>-Pilih Kategori-</option>";
							$tampil=mysql_query("SELECT * FROM kategori ORDER BY nama_kategori");
							while($r=mysql_fetch_array($tampil)){
							  echo "<option value=$r[id_kategori]>$r[nama_kategori]</option>";
							}
				echo "</select>";		
				?>
				</div>
			<div class="form-group">
				<select name="jenistxt" class='form-control' required/>
					<option value="">-Jenis Makanan-</option>
					<option value="Paket">Paket</option>
					<option value="Nasi goreng">Nasi Goreng</option>
					<option value="Ayan">Ayam</option>
					<option value="Kari">Kari</option>
					<option value="Mie">Mie</option>
					<option value="Indomie">Indomie</option>
					<option value="Snack">Snack</option>
					<option value="Soup">Soup</option>
					<option value="Sayur">Sayur</option>
					<option value="Western">Western</option>
					<option value="Sapi">Sapi</option>
					<option value="Coffee">Coffee</option>
					<option value="Non Coffee">Non Coffee</option>
					<option value="Ice Blend Coffee">Ice Blend Coffee</option>
					<option value="Ice Blend Non Coffee">Ice Blend Non Coffee</option>
					<option value="Moktail">Moktail</option>
					<option value="Ice Cream">Ice Cream</option>
					<option value="Fruit Juice">Fruit Juice</option>
				
				
				</select>
              </div>	
			<div class="form-group">
				<select name="penyediatxt" class='form-control' required/>
					<option value="">-Penyedia-</option>
					<option value="Dapur">Dapur</option>
					<option value="Bar">Bar</option>
				
				</select>
              </div>
            
				
				
				 <div class="form-group">
                    <input type="text" class="form-control" name="hargatxt" placeholder="Harga" maxlength="10" required/>
                </div>
              </div>
                
		   
				
		
           <!-- Modal akhir-->
	
        </div>
        <div class="modal-footer">
          <input type="submit" name="btn_sub" value="Simpan" class="btn btn-primary"/>
        </div>
      </div>
      </form> 
    </div>
  </div>
   <!-- Modal -->  
	  
	  

   
  <?php

if($opr=="upd")
{
	$sql_upd=mysql_query("SELECT * FROM menu a, kategori b WHERE a.kategori=b.id_kategori and id_menu='$id'");
	$rs_upd=mysql_fetch_array($sql_upd);
	
?>  
   
<!-- Modal -->
  <div class="modal fade" id="modal_edit" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Rubah</h4>
        </div>
       <div class="modalc-body">
		
	   
		 <!-- Modal mulai-->
          <form method='post' class='col-md-12' enctype='multipart/form-data' name='addroomS'>
				<br>
				   <div class="calloutc">
				 <div class="form-group">	
					<input type="text" class="form-control" name="menutxt" value="<?php echo $rs_upd['menu']; ?>">
				</div>
				 <div class="form-group">
					<?php echo $rs_upd['gambar']; ?></p>
					<input type='text' name='imgoritxt' value="<?php echo $rs_upd['gambar']; ?>" hidden>
					<input type='file' name='imgmenu' class='form-control' >
				</div>
				
				<div class="form-group">		
				<?php
				echo "<select name='kategoritxt' class='form-control' required/>
					  <option value=$rs_upd[kategori]> > $rs_upd[nama_kategori]</option>";
					  $tampil=mysql_query('SELECT * FROM kategori ORDER BY nama_kategori');

						  while($w=mysql_fetch_array($tampil)){
							if ($r[id_kategori]==$w[id_kategori]){
							  echo "<option value=$w[id_kategori] selected>$w[nama_kategori]</option>";
							}
							else{
							  echo "<option value=$w[id_kategori]>$w[nama_kategori]</option>";
							}
						  }
				 echo "</select></td></tr>";
				?>
				 
              </div>
				<div class="form-group">
				<select name="jenistxt" class='form-control' required/>
					<option value="<?php echo $rs_upd['jenis']; ?>">-<?php echo $rs_upd['jenis']; ?>-</option>
					<option value="Paket">Paket</option>
					<option value="Nasi goreng">Nasi Goreng</option>
					<option value="Ayan">Ayam</option>
					<option value="Kari">Kari</option>
					<option value="Mie">Mie</option>
					<option value="Indomie">Indomie</option>
					<option value="Snack">Snack</option>
					<option value="Soup">Soup</option>
					<option value="Sayur">Sayur</option>
					<option value="Western">Western</option>
					<option value="Sapi">Sapi</option>
					<option value="Coffee">Coffee</option>
					<option value="Non Coffee">Non Coffee</option>
					<option value="Ice Blend Coffee">Ice Blend Coffee</option>
					<option value="Ice Blend Non Coffee">Ice Blend Non Coffee</option>
					<option value="Moktail">Moktail</option>
					<option value="Ice Cream">Ice Cream</option>
					<option value="Fruit Juice">Fruit Juice</option>
				
				
				</select>
              </div>	
			<div class="form-group">
				<select name="penyediatxt" class='form-control' required/>
					<option value="<?php echo $rs_upd['penyedia']; ?>">-<?php echo $rs_upd['penyedia']; ?>-</option>
					<option value="Dapur">Dapur</option>
					<option value="Bar">Bar</option>
				
				</select>
              </div>
            
				
				 <div class="form-group">
                    <input type="text" class="form-control" name="hargatxt" value="<?php echo $rs_upd['harga']; ?>" maxlength="10" required/></br>
                </div>
              </div>
				
		<!-- Modal akhir-->

        </div>
        <div class="modal-footer">
          <input type="submit" name="btn_rubah" value="Rubah" class="btn btn-primary"/>
        </div>
      </div>
      </form> 
    </div>
  </div>
   <!-- Modal -->   
  <?php
}           
?>	 
   
<div>
	
<?php
	
	if($opr=="upd"){
	$get=$id;	
echo"<script type='text/javascript'>
	$(document).ready(function(){
		$('#modal_edit').modal('show');
	});
</script>";

	}
	
	if($opr=="del"){
	$get=$id;	
echo"<script type='text/javascript'>
	$(document).ready(function(){
		$('#modal_delete').modal('show');
	});
</script>";
	}
		
	?>
</div>	
   
   
   
   
   
   <script name="test" type="text/javascript">  
			<?php echo $jsArray1; ?>
							
			function changeValue1(id){
					
			document.getElementById("gambartxt").src = p_menu[id].j_gambar;
			document.getElementById("hargatxt").value =p_menu[id].j_harga;	
			};
			
			
			function munculkan(){
			
			
			
			$("#myId").removeClass('hidden');
				
			};	
	</script>

	<script type="text/javascript">

       function PrintDoc() {

        var toPrint = document.getElementById('printarea');

        var popupWin = window.open('', '_blank', 'width=595,height=842,location=no,left=200px');

        popupWin.document.open();

        popupWin.document.write('<html><title>::Preview::</title><link rel="stylesheet" type="text/css" href="print.css" /></head><body onload="window.print()">')

        popupWin.document.write(toPrint.innerHTML);

        popupWin.document.write('</html>');

        popupWin.document.close();

    }
	
	

</script>
	

   

   
   
   
   
   
  