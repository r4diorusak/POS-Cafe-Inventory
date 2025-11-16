
<style>
.container {
    position: relative;
    text-align: left;
	font-family: "Lucida Console";
	font-size: 18px;
	line-height: 1.5;
	font-weight: bold;
}


.bottom-left {
    position: absolute;
    bottom: 18px;
    left: 16px;
}

.top-left {
    position: absolute;
    top:  80px;
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
   bottom: 1px;
    left: 50px;
}

@page {
    margin-top: 1cm;
    margin-bottom: 1cm;
    margin-left: 1cm;
    margin-right: 1cm;
}

img {
  
  float: left;
  padding: 0px 3px;
}

p {
	
	font-size: 11px;
}

.ket {
	
	font-size: 14px;
}
</style>

<?php
include "config/koneksi.php";
$no_invoice = $_GET['id'];
$edit = mysql_query("SELECT a.invoice,meja,tgl_order,total_bayar, GROUP_CONCAT(menu SEPARATOR ', ') as keterangan from invoice a,invoice_detail b,menu c where a.invoice=b.invoice and b.id_menu=c.id_menu and a.invoice='$no_invoice'");
$r    = mysql_fetch_array($edit);
$tgl = date("d-m-Y", strtotime($r['tgl_order']));
$meja = $r['meja'];
error_reporting(0);


?>



</head>
<body onload="window.print();">
<div class="wrapper">


<table  width="250px">

<tr>
<td td colspan="2">
<div class="container"> <img src="images/print.png" width="52px"><b><p>Cafe xxx</b><br> Gg.Solo Helvetia Tengah Medan Sumatera Utara, 20124</p>
 <div align="center">---------------------</div>
  <div class="top-left">
  <b><span class="ket">Invoice:#<?php echo $no_invoice;?> <br>
 Tanggal:<?php echo $tgl;?> Meja:<?php echo $meja;?> </span></b>
  =======================
 
  <?php 
  $list= mysql_query("SELECT menu,meja,jumlah,harga*jumlah as total from invoice a,invoice_detail b,menu c where a.invoice=b.invoice and b.id_menu=c.id_menu and a.invoice='$no_invoice'");
	echo " <table>
  <thead>
        <tr><th align=left>No</th><th>Menu</th><th>Harga</th></tr>
  </thead>";
	$no = 1;
    while($s=mysql_fetch_array($list)){
		echo "
		
		<tr><td align=center>$no.</td><td>$s[menu]x$s[jumlah]</td><td align=center>".number_format($s['total'],0,",",".")."</td></tr>";
			 $total = $total+$s['total'];
		$no++;	
	}
  ?>
   </table>
  
   <?php 
	while($s1=mysql_fetch_array($list)){
		
	}
		echo   
			"<div align=right>--------------------+</div><div>Total: Rp ".number_format($total,0,",",".")."</div>";
   ?>
    =======================
   <br><br>
   
   <div align="center"><b>Terima Kasih</b></div>
   
  </div>

 

</div>

</td>
</tr>
</table>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>


