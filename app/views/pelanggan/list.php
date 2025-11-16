<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Data Pelanggan - POS Cafe Inventory</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../../assets/plugins/datatables/dataTables.bootstrap.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .page-header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content-box {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar {
            background-color: #2c3e50;
            margin-bottom: 20px;
        }
        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }
        table {
            margin-top: 20px;
        }
        .action-buttons a {
            margin-right: 5px;
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
                <li><a href="../../../index.php?controller=home&action=index" style="color: white;"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="../../../index.php?controller=auth&action=logout" style="color: white;"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <h1><i class="fa fa-users"></i> Data Pelanggan</h1>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="content-box">
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-6">
                    <a href="../../../index.php?controller=pelanggan&action=create" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Pelanggan Baru
                    </a>
                </div>
                <div class="col-md-6">
                    <form method="POST" action="../../../index.php?controller=pelanggan&action=search" class="form-inline pull-right">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari pelanggan...">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Cari</button>
                    </form>
                </div>
            </div>

            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat</th>
                        <th>No Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (isset($data['pelanggan']) && !empty($data['pelanggan'])):
                        foreach ($data['pelanggan'] as $row):
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['nama_lengkap']; ?></td>
                        <td><?php echo $row['alamat']; ?></td>
                        <td><?php echo $row['no_telp']; ?></td>
                        <td class="action-buttons">
                            <a href="../../../index.php?controller=pelanggan&action=edit&id=<?php echo $row['id_pelanggan']; ?>" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="../../../index.php?controller=pelanggan&action=delete&id=<?php echo $row['id_pelanggan']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?');">
                                <i class="fa fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php 
                        endforeach;
                    else:
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data pelanggan</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../../../assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
