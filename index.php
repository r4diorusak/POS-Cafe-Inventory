<?php
  //header('location:home'); 
 $aksi="";
if(isset($_GET['aksi']))
	$aksi=$_GET['aksi'];
?>
<head>
<title>Login</title>
<script language="javascript">
function validasi(form){
  if (form.username.value == ""){
    alert("Anda belum mengisikan Username.");
    form.username.focus();
    return (false);
  }
     
  if (form.password.value == ""){
    alert("Anda belum mengisikan Password.");
    form.password.focus();
    return (false);
  }
  return (true);
}
</script>

<?php include "layout/head_login.php"; ?>

</head>


 <div class="row">

<div class="col-sm-6 col-sm-offset-3 form-box">

<?php  if($aksi=="berhasil"){
		
echo "<div class='alert alert-success'>Pendaftaran Berhasi Silahkan Login</div>";
	}
if($aksi=="gagal"){
		
echo "<div class='alert alert-danger'>Gagal Ulangi Lagi</div>";
	}
if($aksi=="gagal2"){
		
echo "<div class='alert alert-danger'>Pasword Tidak sama Ulangi Lagi</div>";
	}	
	
?>
<br><br><br>
                        	<div class="form-top login100-form-title" style="background-image: url(images/bg-01.jpg);">
							
                        		<div class="form-top-left">
                        			<h3>Login</h3>
                            		<p>Masukan Username dan Password:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
<div class="form-bottom">


<form name="login" action="cek_login.php" method="POST" onSubmit="return validasi(this)" class="login-form">
	<div class="form-group">
		<label class="sr-only" for="form-username">Username</label>
		<input type="text" name="username" class="form-username form-control" placeholder="Username..."></td></tr>
	</div>
	<div class="form-group">
	<label class="sr-only" for="form-password">Password</label>
	<input type="password" name="password" class="form-password form-control" placeholder="Password..."></td></tr>
	</div>
	
	<input type="submit" class="login-btn" value="Login">
	
</form>


</div>
</div>
</div>

<?php include "layout/footer_login.php"; ?>












