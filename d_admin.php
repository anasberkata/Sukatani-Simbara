<?php
require 'function.php';

$barang = mysqli_query($koneksi, 'SELECT * FROM nama_barang');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inventory TB Sukatani</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Awal Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3">TB Sukatani</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <hr class="sidebar-divider">

            <!-- Nav Item - Tables -->
            <?php
            $role = $_SESSION['role'];
            if ($role == "admin"):
                ?>
                <li class="nav-item active">
                    <a class="nav-link" href="d_admin.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
            <?php else: ?>
                <li class="nav-item active">
                    <a class="nav-link" href="d_user.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link" href="stockout.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Stock Out</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="stockin.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Stock In</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="listorder.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Order List</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adduser.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Add User</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

        </ul>
        <!-- Akhir Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- judul page dan button -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Inventory</h1>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                            Tambah Barang
                        </button>
                    </div>

                    <!-- The Modal add barang -->
                    <div class="modal" id="addModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Tambah Barang</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <form method="post">
                                    <div class="modal-body">
                                        <input type="text" name="namabarang" placeholder="Nama Barang"
                                            class="form-control" required>
                                        <br>
                                        <input type="num" name="hargabeli" placeholder="Harga Beli" class="form-control"
                                            required>
                                        <br>
                                        <input type="num" name="hargajual" placeholder="Harga Jual" class="form-control"
                                            required>
                                        <br>
                                        <button type="submit" class="btn btn-primary" name="addbarang">Simpan</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>






                    <!-- Awal tabel Barang -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Harga Beli</th>
                                            <th>Harga Jual</th>
                                            <th>Jumlah Stok</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($barang as $b): ?>
                                            <tr>
                                                <td>
                                                    <?= $i; ?>
                                                </td>
                                                <td>
                                                    <?= $b["namabarang"] ?>
                                                </td>
                                                <td>
                                                    <?= $b["hargabeli"] ?>
                                                </td>
                                                <td>
                                                    <?= $b["hargajual"] ?>
                                                </td>
                                                <td>
                                                    <?= $b["stock"] ?>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                        data-target="#editModal<?= $b["id_barang"] ?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteModal<?= $b["id_barang"] ?>">
                                                        Delete
                                                    </button>
                                                </td>

                                            </tr>

                                            <!-- The Modal edit barang -->
                                            <div class="modal" id="editModal<?= $b["id_barang"] ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Ubah Barang</h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_barang"
                                                                    value="<?= $b["id_barang"] ?>">
                                                                <input type="text" name="namabarang"
                                                                    value="<?= $b["namabarang"] ?>" class="form-control"
                                                                    required>
                                                                <br>
                                                                <input type="num" name="hargabeli"
                                                                    value="<?= $b["hargabeli"] ?>" class="form-control"
                                                                    required>
                                                                <br>
                                                                <input type="num" name="hargajual"
                                                                    value="<?= $b["hargajual"] ?>" class="form-control"
                                                                    required>
                                                                <br>
                                                                <button type="submit" class="btn btn-primary"
                                                                    name="editbarang">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- The Modal delete barang -->
                                            <div class="modal" id="deleteModal<?= $b["id_barang"] ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Barang</h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_barang"
                                                                    value="<?= $b["id_barang"] ?>">
                                                                <p>Yakin ingin menghapus
                                                                    <?= $b["namabarang"] ?>
                                                                </p>
                                                                <br>
                                                                <button type="submit" class="btn btn-primary"
                                                                    name="deletebarang">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; TB SUKATANI</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>