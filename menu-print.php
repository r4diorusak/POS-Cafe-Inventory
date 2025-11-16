
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
    margin-left: 0px;
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
include "config/koneksi.php";
$no_meja = $_GET['meja'];
$edit = mysql_query("SELECT * FROM `orders_temp` a, menu b WHERE a.id_menu=b.id_menu and meja='$no_meja'");
$r    = mysql_fetch_array($edit);

$meja = $r['meja'];
error_reporting(0);


?>



</head>
<body onload="window.print();">
<div class="wrapper">


<table  width="200px">

<tr>
<td td colspan="2">
<div class="container"> 
  <div class="top-left">
  <span class="ket">
 Tanggal:<?php echo date("d/m/Y");?></span>
  ========================
 
  <?php 
  $list= mysql_query("SELECT * FROM `orders_temp` a, menu b WHERE a.id_menu=b.id_menu and meja='$no_meja'");
	echo " <table width=280px> 
  <thead>
        <tr><th align=left>No</th><th>Menu</th></tr>
  </thead>";
	$no = 1;
    while($s=mysql_fetch_array($list)){
		echo "
		
		<tr><td align=center>$no.</td><td>$s[menu] X $s[jumlah]</td></tr>";
			 $total = $total+$s['total'];
		$no++;	
	}
  ?>
   </table>
  
   <?php 
	while($s1=mysql_fetch_array($list)){
		
	}
		
   ?>
    ========================
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


