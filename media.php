<?php
session_start();
error_reporting(0);
date_default_timezone_set("Asia/Bangkok");
include "config/koneksi.php";
session_start();

if (empty($_SESSION[username]) AND empty($_SESSION[passuser])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
}
else{

require_once "layout/head.php"; 
require_once "layout/header.php"; 
 ?>
<div id="wrapper" style="height: auto; min-height: 900px;">
       
		
          <div class="content-wrapper">
		      <section class="content">
			
			<?php require_once "content.php"; ?>								
			
			    </section>
		   </div>
 </div>	
		


<?php require_once "layout/footer.php"; ?>
<?php
}
?>

 <?php

//gambar	
	if (!isset($_FILES['imgmenu']['tmp_name'])) {
	echo "";
	}else{
	
	$file=$_FILES['imgmenu']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['imgmenu']['tmp_name']));
	$image_name= addslashes($_FILES['imgmenu']['name']);	
	
	move_uploaded_file($_FILES["imgmenu"]["tmp_name"],"photos/menu/" . $_FILES["imgmenu"]["name"]);
	echo "<script>location='media.php?module=menu&aksi=berhasil'</script>";	
				
			
	}
?>