
<?php
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";
include "config/class_paging.php";
include "config/fungsi_rupiah.php";



$aksi="";
if(isset($_GET['aksi']))
	$aksi=$_GET['aksi'];

// Bagian Home
if ($_GET[module]=='home'){
	$tanggal_login=tgl_indo(date('Y m d')).' | '.date("H:i:s").'WIB'; 
	
	if($aksi=="berhasil"){ 
	$link = "invoice-print.php?id=".$_GET['id'];	
		  echo"<script type='text/javascript'>
			   window.open('$link', '_blank');
			</script>";
		} 
if($aksi=="berhasil"){ echo "<div class='alert alert-success'><b>Berhasi</b></div>";}

if($aksi=="gagal"){
		
echo "<div class='alert alert-danger'><b>Gagal Ulangi Lagi</b></div>";
	}
  
   if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir'){
	include "modul/mod_kasir/kasir.php";
	}else{
	include "modul/mod_waiter/waiter.php";
	}
  
}

// Bagian Modul
elseif ($_GET[module]=='modul'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_modul/modul.php";
  }
}

// Bagian order
elseif ($_GET[module]=='p_menu'){
  
    include "modul/mod_order/p_menu.php";
  
}

// Bagian meja order
elseif ($_GET[module]=='p_cart'){
  
    include "modul/mod_order/p_cart.php";
}


// Bagian Menu
elseif ($_GET[module]=='menu'){
 if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir'){
    include "modul/mod_menu/menu.php";
  }
}

// Bagian Kategori
elseif ($_GET[module]=='kategori'){
   if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir'){
    include "modul/mod_kategori/kategori.php";
  }
}

// order
elseif ($_GET[module]=='order'){
   if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir'){
    include "modul/mod_order/order.php";
  }
}

// Meja
elseif ($_GET[module]=='meja'){
   if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir'){
    include "modul/mod_meja/meja.php";
  }
}

// pelanggan
elseif ($_GET[module]=='pelanggan'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir'){
    include "modul/mod_pelanggan/pelanggan.php";
  }
}

// pegawai
elseif ($_GET[module]=='pegawai'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_pegawai/pegawai.php";
  }
}

// Bagian Order
elseif ($_GET[module]=='order'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_order/order.php";
  }
}

// Bagian bawa pulang
elseif ($_GET[module]=='bw_pulang'){
  
    include "modul/mod_waiter/bawa_pulang.php";
 
}

// Bagian Profil
elseif ($_GET[module]=='profil'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_profil/profil.php";
  }
}


// Bagian Kota/tarif
elseif ($_GET[module]=='tarif'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_tarif/tarif.php";
  }
}

// Bagian Password
elseif ($_GET[module]=='password'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir'){
    include "modul/mod_password/password.php";
  }
}

// Bagian Laporan
elseif ($_GET[module]=='laporan'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_laporan/laporan.php";
  }
}

// Bagian Laporan
elseif ($_GET[module]=='lp_bagi'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir'){
    include "modul/mod_lp_bagi/laporan.php";
  }
}

// Bagian Laporan
elseif ($_GET[module]=='invoice'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir'){
    include "modul/mod_invoice/invoice.php";
  }
}


// Apabila modul tidak ditemukan
else{
  echo "<p><b>MODUL BELUM ADA ATAU BELUM LENGKAP</b></p>";
}
?>


