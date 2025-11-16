<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard - POS Cafe Inventory</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/LTE/css/AdminLTE.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .dashboard-header h1 {
            margin: 0;
            font-size: 32px;
        }
        .dashboard-header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .stat-box {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            text-align: center;
        }
        .stat-box h3 {
            color: #999;
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .stat-box .number {
            color: #667eea;
            font-size: 32px;
            font-weight: bold;
        }
        .stat-box.total-invoice .number {
            color: #00a8e1;
        }
        .stat-box.total-revenue .number {
            color: #00c084;
        }
        .navbar {
            background-color: #2c3e50;
            margin-bottom: 30px;
        }
        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }
        .logout-btn {
            color: #fff !important;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <span class="navbar-brand"><i class="fa fa-cutlery"></i> POS Cafe Inventory</span>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" class="logout-btn"><i class="fa fa-user"></i> <?php echo $_SESSION['namauser']; ?></a></li>
                <li><a href="../../index.php?controller=auth&action=logout" class="logout-btn"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- Header -->
        <div class="dashboard-header">
            <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            <p>Selamat datang di sistem POS Cafe Inventory</p>
        </div>

        <!-- Stats Row -->
        <div class="row">
            <div class="col-md-6">
                <div class="stat-box total-invoice">
                    <h3>Total Invoice Hari Ini</h3>
                    <div class="number"><?php echo isset($data['totalInvoiceHari']) ? $data['totalInvoiceHari'] : 0; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-box total-revenue">
                    <h3>Total Penjualan Hari Ini</h3>
                    <div class="number"><?php echo format_rupiah(isset($data['totalPenjualanHari']) ? $data['totalPenjualanHari'] : 0); ?></div>
                </div>
            </div>
        </div>

        <!-- Menu -->
        <div class="row">
            <div class="col-md-12">
                <h2>Menu Utama</h2>
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <a href="../../index.php?controller=pelanggan&action=index" class="btn btn-block btn-primary" style="padding: 20px; margin-bottom: 10px;">
                            <i class="fa fa-users fa-2x"></i><br>
                            Data Pelanggan
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="../../index.php?controller=menu&action=index" class="btn btn-block btn-info" style="padding: 20px; margin-bottom: 10px;">
                            <i class="fa fa-list fa-2x"></i><br>
                            Daftar Menu
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="../../index.php?controller=invoice&action=index" class="btn btn-block btn-warning" style="padding: 20px; margin-bottom: 10px;">
                            <i class="fa fa-file-text fa-2x"></i><br>
                            Invoice
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="../../index.php?controller=laporan&action=index" class="btn btn-block btn-success" style="padding: 20px; margin-bottom: 10px;">
                            <i class="fa fa-bar-chart fa-2x"></i><br>
                            Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
