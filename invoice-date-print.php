
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
    top:  90px;
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
    left: 60px;
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
    font-size: 14px;
    font-style: normal;
    color: -internal-quirk-inherit;
    text-align: start;
    font-variant: normal;
}
</style>

<?php
error_reporting(0);
include "config/koneksi.php";

$mulai=$_POST[thn_mulai].'-'.$_POST[bln_mulai].'-'.$_POST[tgl_mulai];
$selesai=$_POST[thn_selesai].'-'.$_POST[bln_selesai].'-'.$_POST[tgl_selesai];

$pegawai=$_POST[pegawaitxt];

$edit = mysql_query("SELECT a.invoice,sum(jumlah),total_bayar,a.tgl_order from invoice a,invoice_detail b,menu c where a.invoice=b.invoice and b.id_menu=c.id_menu and a.tgl_order BETWEEN '$mulai' AND '$selesai' GROUP by b.invoice order by a.invoice ASC");
$r    = mysql_fetch_array($edit);
$tgl = date("d-m-Y", strtotime($r['tgl_order']));


 

?>

<body onload="window.print();">

<table  width="295px" border=0>

<tr>
<td td colspan="2">
<div class="container"> <img src="images/icons/coffee2.png" width="52px"><p><b>D'COFFEE KEDAN</b><br>Jl.K.H Wahid Hasyim No.54 Babura, Medan Baru<br>0813-7021-8989 
<br>-----------------------------------</p>

  <div class="top-left">
  <span class="ket">
  <table>
  <b>LAPORAN PENDAPATAN</b><br>
  Pegawai :<?php echo $pegawai;?><br>
  Tanggal :<?php echo $mulai;?> ~ <?php echo $selesai;?><br>  
  ===============================
  </table>
  </span>

 
  <?php 
  $cari_user1=mysql_query("SELECT * from invoice a, invoice_detail b where a.invoice=b.invoice and user='$pegawai'");
  $cari_user2=mysql_query("SELECT * from invoice a, invoice_detail b where a.invoice=b.invoice and waiter='$pegawai'");
  
  $ketemu1=mysql_num_rows($cari_user1);
  $ketemu2=mysql_num_rows($cari_user2);
  $r1=mysql_fetch_array($cari_user1);
  $r2=mysql_fetch_array($cari_user2);
  
  
  if($pegawai==""){
  $list= mysql_query("SELECT a.invoice,sum(jumlah)as qty,total_bayar,(total_bayar*diskon) ds,(total_bayar*pajak) pj, (total_bayar*jasa) js, a.tgl_order from invoice a,invoice_detail b,menu c where a.invoice=b.invoice and b.id_menu=c.id_menu and a.tgl_order BETWEEN '$mulai' AND '$selesai' GROUP by b.invoice order by a.invoice ASC");
  }elseif($ketemu1 > 0){
   $list= mysql_query("SELECT a.invoice,sum(jumlah)as qty,total_bayar,(total_bayar*diskon) ds,(total_bayar*pajak) pj, (total_bayar*jasa) js, a.tgl_order from invoice a,invoice_detail b,menu c where a.invoice=b.invoice and b.id_menu=c.id_menu and user='$pegawai' and a.tgl_order BETWEEN '$mulai' AND '$selesai' GROUP by b.invoice order by a.invoice ASC");
  }elseif ($ketemu2 > 0) {
   $list= mysql_query("SELECT a.invoice,sum(jumlah)as qty,total_bayar,(total_bayar*diskon) ds,(total_bayar*pajak) pj, (total_bayar*jasa) js, a.tgl_order from invoice a,invoice_detail b,menu c where a.invoice=b.invoice and b.id_menu=c.id_menu and waiter='$pegawai' and a.tgl_order BETWEEN '$mulai' AND '$selesai' GROUP by b.invoice order by a.invoice ASC");	
	}
  
  
	echo " <table width=280px>
  <thead>
        <tr><th align=left>No</th><th align=left>Invoice</th><th>Qty</th><th>Bayar</th></tr>
  </thead>";
	$no = 1;
    while($s=mysql_fetch_array($list)){
		echo '
		
		<tr>
		<td align=left>'.$no.'</td><td>#'.$s['invoice'].'</td><td align=center>'.$s['qty'].'</td>
		<td align=center>Rp. '.number_format($totalx=(($s['total_bayar']-$s['ds'])+$s['pj']+$s['js']),0, ".", ".").'</td>
		</tr>';
			 $total = $total+$totalx;
		$no++;	
	}
  ?>
   </table>
  <div class="total">
  <table width="275px" border=0>
  
    <?php 
	echo   
			"-------------------------------- + <br>
			<tr><td>Total:</td><td align=right>Rp. ".number_format($total,0,",",".")."</td></tr>
			
			</table>
			===================================
			<table width=275px class=tabel1 border=0>
			<b><label>Menu:</label></b>
			";
	if($pegawai==""){					
    $list2= mysql_query("SELECT b.id_menu,c.menu,sum(jumlah) as jmlh from invoice a,invoice_detail b,menu c where a.invoice=b.invoice and b.id_menu=c.id_menu and a.tgl_order BETWEEN '$mulai' AND '$selesai' GROUP by b.id_menu order by c.kategori ASC");
    }elseif($ketemu1 > 0){
   $list2= mysql_query("SELECT b.id_menu,c.menu,sum(jumlah) as jmlh from invoice a,invoice_detail b,menu c where a.invoice=b.invoice and b.id_menu=c.id_menu and user='$pegawai' and a.tgl_order BETWEEN '$mulai' AND '$selesai' GROUP by b.id_menu order by c.kategori ASC");
	}elseif ($ketemu2 > 0) {
   $list2= mysql_query("SELECT b.id_menu,c.menu,sum(jumlah) as jmlh from invoice a,invoice_detail b,menu c where a.invoice=b.invoice and b.id_menu=c.id_menu and waiter='$pegawai' and a.tgl_order BETWEEN '$mulai' AND '$selesai' GROUP by b.id_menu order by c.kategori ASC");	
	}
	$no2 = 1;
	while($s2=mysql_fetch_array($list2)){
		echo "<tr><td align=left>$no2.$s2[menu] x$s2[jmlh]</td></tr>";
			 
		$no2++;		
	}
		
		
   ?>
   </tr>
   </table>
   </div>
 

  </div>

 

</div>

</td>
</tr>
</table>
  <!-- /.content -->

<!-- ./wrapper -->
</body>

