<?php
$notif = mysql_query("SELECT COUNT(status) as notifikasi FROM `permintaan_data` where status='' OR status IS NULL");
$notif2 = mysql_query("SELECT id_orders,COUNT(id_orders)as jlmitem FROM `permintaan_data` where status='' OR status IS NULL GROUP BY id_orders ORDER BY id_orders DESC");
$r=mysql_fetch_array($notif);

?>
  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" ><img src="images/panel_48.png"></span>
      <!-- logo for regular state and mobile devices -->
	  
      <span><img src="images/panel_48.png"> Admin Panel</span>
    </a>
	
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <div>
	  
	  <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
       
      </a>
	 
     <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php  echo $r['notifikasi']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><b>Notifikasi</b></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
               
                  <?php
				  while($nt=mysql_fetch_array($notif2)){
					   
					   echo "<li>
                
                      <a href=?module=order&act=detailorder&id=$nt[id_orders]>
					  <i class='fa fa-users text-aqua'></i> Pesanan baru no order  $nt[id_orders] <small class='label pull-right bg-yellow'>$nt[jlmitem]</small>
					  </a>
                    
                  </li>
				  
								 
								 ";
				   }
				            
                 ?>
                
                </ul>
              </li>
              <li class="footer"><a href="media.php?module=order">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
         
             
           
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="images/Cash.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['namauser']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="images/Cash.png" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['namauser']; ?>
                 
                </p>
              </li>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="media.php?module=password" class="btn btn-default btn-flat"><i class="fa fa-cog fa-spin"></i> Seting</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat"><i class="fa fa-refresh fa-spin"></i> LogOut</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
         
        </ul>
      </div>
    </nav>
  </header>
  
  
   
  
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar" >
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: 1900px;">
      <!-- Sidebar user panel -->

      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class='header'>Transaksi</li>  
        <li><a href=?module=home><i class="fa fa-cart-plus fa-lg"></i><span><b> Kasir</b></span></a></li>
		
        <?php include "menu.php"; ?>
       
      </ul>
		
	   
    </section>
    <!-- /.sidebar -->
	
	
 </aside> 
