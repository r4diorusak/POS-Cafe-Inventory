<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

	 echo "<div class='box box-primary col-md-12'>
		  <div class='box-header'><h4>Invoice</h4></div>
			<div class='box-body'>";

             include "modul/mod_invoice/table.php";

	echo '</div></div>';
			

          
}

?>
