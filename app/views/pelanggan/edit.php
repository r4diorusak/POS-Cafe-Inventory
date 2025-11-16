<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Pelanggan - POS Cafe Inventory</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/font-awesome/css/font-awesome.min.css">
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
            max-width: 600px;
        }
        .navbar {
            background-color: #2c3e50;
            margin-bottom: 20px;
        }
        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }
        .form-group label {
            font-weight: bold;
            color: #333;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 30px;
        }
        .btn-submit:hover {
            opacity: 0.9;
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
            <h1><i class="fa fa-edit"></i> Edit Pelanggan</h1>
        </div>

        <!-- Content -->
        <div class="content-box">
            <?php 
            if (isset($data['pelanggan']) && !empty($data['pelanggan'])):
                $pelanggan = $data['pelanggan'];
            ?>
            <form method="POST" action="../../../index.php?controller=pelanggan&action=update&id=<?php echo $pelanggan['id_pelanggan']; ?>">
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $pelanggan['nama_lengkap']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="4"><?php echo $pelanggan['alamat']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="telepon">No Telepon</label>
                    <input type="text" class="form-control" id="telepon" name="telepon" value="<?php echo $pelanggan['no_telp']; ?>">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-submit"><i class="fa fa-save"></i> Simpan Perubahan</button>
                    <a href="../../../index.php?controller=pelanggan&action=index" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
            <?php else: ?>
                <div class="alert alert-danger">
                    Data pelanggan tidak ditemukan
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="../../../assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
