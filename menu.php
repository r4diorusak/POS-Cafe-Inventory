<?php

if ($_SESSION[leveluser]=='admin'){
  $sql=mysql_query("select * from modul where status='admin' and aktif='Y' and menu='input' order by urutan");
  $sql1=mysql_query("select * from modul where status='admin' and aktif='Y' and menu='laporan' order by urutan");
  
  
   echo "<li class='header'>Input Data</li>";
	while ($m=mysql_fetch_array($sql)){
	  echo "<li><a href='$m[link]'><i class='$m[ico]'></i> <span>  $m[nama_modul]</span></a></li>";

}		 
//=============================================================================================
 echo "<li class='header'>Laporan</li>";			 
 while ($m=mysql_fetch_array($sql1)){
	  echo "<li><a href='$m[link]'><i class='$m[ico]'></i> <span>  $m[nama_modul]</span></a></li>";

}


//=============================================================================================


}

if ($_SESSION[leveluser]=='kasir'){
  $sql=mysql_query("select * from modul where status='kasir' and aktif='Y' and menu='input' order by urutan");
  $sql1=mysql_query("select * from modul where status='kasir' and aktif='Y' and menu='laporan' order by urutan");
  
  
   echo "<li class='header'>Input Data</li>";
	while ($m=mysql_fetch_array($sql)){
	  echo "<li><a href='$m[link]'><i class='$m[ico]'></i> <span>  $m[nama_modul]</span></a></li>";

}		 
//=============================================================================================
 echo "<li class='header'>Laporan</li>";			 
 while ($m=mysql_fetch_array($sql1)){
	  echo "<li><a href='$m[link]'><i class='$m[ico]'></i> <span>  $m[nama_modul]</span></a></li>";

}


//=============================================================================================


}
?>
