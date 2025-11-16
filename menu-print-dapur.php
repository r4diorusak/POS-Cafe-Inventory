
<style>
.container {
    position: relative;
    text-align: left;
	font-family: "Lucida Console";
	font-size: 18px;
	line-height: 1.5;	
}

.total {
    position: relative;
    text-align: left;
	font-family: "Lucida Console";
	font-size: 14px;
	line-height: 1.5;	
}


.bottom-left {
    position: absolute;
    bottom: 18px;
    left: 16px;
}

.top-left {
    position: absolute;
    top:  1px;
    left: 0px;
	right: 0px;
}

.top-right {
    position: absolute;
    top: 8px;
    right: 16px;
	
}

.bottom-right {
    position: absolute;
    bottom: 1px;
    right: 10px;
}

.centered {
    position: absolute;
   bottom: 5px;
    left: 90px;
}

@page {
    margin-top: 1px;
    margin-bottom: 1px;
    margin-left: 0px;
    margin-right: 0px;
}

img {
  
  float: left;
  margin-top: 2px;
  margin-right: 5px;
  margin-bottom: 10px;
}

p {
 font-family: "Lucida Console";
	font-size: 13px;
	
}
.ket {
	font-family: "Lucida Console";
	
	font-size: 15px;
}

body {
display: block;
	margin-top: 0px;
    margin-bottom: 1px;
    margin-left: 30px;
    margin-right: 0px;
}

table {
    white-space: normal;
    line-height: normal;
    font-weight: normal;
    font-size: 15px;
    font-style: normal;
    color: -internal-quirk-inherit;
    text-align: start;
    font-variant: normal;
}
</style>

<?php
date_default_timezone_set('Asia/Jakarta');
include "config/koneksi.php";
$no_meja = $_GET['meja'];
$edit = mysql_query("SELECT * FROM `orders_temp` a, menu b WHERE a.id_menu=b.id_menu and b.penyedia='Bar' and meja='$no_meja'");
$r    = mysql_fetch_array($edit);

$meja = $r['meja'];
error_reporting(0);


?>

<head>
    <script type="text/javascript">
      window.onbeforeunload = function() {
          return "return confirm('Are you sure?')";	  
      }
	    // window.onUnLoad=window.open("http://localhost/cafe/media.php?module=home");        
    </script>
</head>

<body onload="window.print();">

<div class="wrapper">

<table  width="200px">

<tr>
<td td colspan="2">
<div class="container"> 
  <div class="top-left">
  <span class="ket">
 <b>Dapur</b> <br>
<?php
 echo $t=date("H:i:s");
 echo" - ";
 echo date("d/m/Y"); ?></span>
  =======================
  
  <table width="275px" border=0>
  
   <?php 
   echo   "
			
			<table width=275px class=tabel1 border=0>
			Menu Baru:
			";
			
    $list2= mysql_query("SELECT menu,sum(jumlah) as qty,b.penyedia,jam FROM `orders_temp` a, menu b WHERE a.id_menu=b.id_menu and b.penyedia='Dapur' and meja='$no_meja' and status='0' group by menu");
    $no2 = 1;
	while($s2=mysql_fetch_array($list2)){
		echo "<tr><td align=left>$no2.$s2[menu] x$s2[qty]</td></tr>";
			 $total = $total+$s['total_bayar'];
		$no2++;		
	}
		
	$upd_sql=mysql_query("UPDATE `orders_temp` SET `status`='1' WHERE meja='$no_meja' and status='0' and penyedia='Dapur'");		
   ?>
   
   </table>
   =======================
   <br><br>
   
   <div class="centered"><b>Meja <?php echo $no_meja;?></b></div>
   
  </div>

 

</div>

</td>
</tr>
</table>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>


