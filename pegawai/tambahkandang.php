<?php
session_start();
if ($_SESSION['nama_petugas'] !== null) {
    include '../conn.php';
    $title = "Tambah Kandang";
}

?>

<?php if ($_SESSION['nama_petugas'] !== null) : ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?= $title ?></title>
        <!-- Favicon-->
        <link href="../assets/img/logoweb.png" rel="icon">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    </head>

    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light"><?= $title ?></div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= ($title === "Dashboard Petugas") ? 'active' : ''; ?>" href="dashboard.php">Dashboard</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= ($title === "Pesanan Sedang Proses") ? 'active' : ''; ?>" href="pesanandiproses.php">Pesanan Sedang Proses</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= ($title === "Pesanan Siap Kirim") ? 'active' : ''; ?>" href="pesanansiap.php">Pesanan Siap Kirim</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= ($title === "Riwayat Pesanan") ? 'active' : ''; ?>" href="riwayatpesanan.php">Riwayat Pesanan</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= ($title === "Daftar Kandang") ? 'active' : ''; ?>" href="daftarkandang.php">Daftar Kandang</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= ($title === "Tambah Kandang") ? 'active' : ''; ?>" href="tambahkandang.php">Tambah Data Kandang</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= ($title === "Tambah Pesanan") ? 'active' : ''; ?>" href="tambahpesanan.php">Tambah Pesanan</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= ($title === "Laporan Penjualan") ? 'active' : ''; ?>" href="laporanpenjualan.php">Laporan Penjualan Kandang</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= ($title === "Data User") ? 'active' : ''; ?>" href="datauser.php">Data User</a>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-sm navbar-light bg-light border-bottom">
                    <div class="container-fluid">
                        <button class="btn btn-primary d-sm-block d-md-none d-lg-none" id="sidebarToggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                            </svg>
                        </button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['nama_petugas'] ?></a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="updateuser.php">Update Account</a>
                                        <a class="dropdown-item" href="../logout.php">Logout</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- Page content-->
                <div class="container">
                    <?php if (isset($_GET['pesan'])) : ?>
                        <?php if ($_GET['pesan'] === "berhasil") : ?>
                            <div class="alert alert-success m-4" role="alert">
                                Berhasil Menambahkan Data
                            </div>
                        <?php elseif ($_GET['pesan'] === "gagal") : ?>
                            <div class="alert alert-danger m-4" role="alert">
                                Gagal Menambahkan Data
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                    <div class="container mt-5 col-8 mx-auto">
                        <h3>Form Tambah Data Kandang</h3>
                        <form autocomplete="off" action="proses.php" method="POST" enctype="multipart/form-data">
                            <div class="my-3">
                                <label for="nama-kandang" class="form-label">Nama Kandang</label>
                                <input required type="text" class="form-control" name="nama-kandang" id="nama-kandang">
                            </div>
                            <div class="row">
                                <label class="mb-1" for="ukuran-kandang">Ukuran Kandang</label>
                                <div class="col-8 mt-1">
                                    <select class="form-select" name="ukuran-kandang" id="ukuran-kandang" aria-label="Default select example">
                                        <option selected> --- Pilih Ukuran Kandang ---</option>
                                        <option value="sedang">Sedang</option>
                                        <option value="besar">Besar</option>
                                    </select>
                                </div>
                                <div class="col-4 mt-1">
                                    <input required type="number" name="harga-kandang" value="100000" min="1" class="form-control" placeholder="Angka">
                                    <div id="emailHelp" class="form-text">Harga kandang</div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="mb-1" for="satuan-angka">Lama Pengerjaan Kandang</label>
                                <div class="col-4 mt-1">
                                    <input required type="number" name="satuan-angka" id="satuan-angka" value="1" min="1" class="form-control" placeholder="Angka">
                                    <div id="emailHelp" class="form-text">Angka Hari / Minggu</div>
                                </div>
                                <div class="col-8 mt-1">
                                    <select class="form-select" name="satuan-waktu" id="satuan-waktu" aria-label="Default select example">
                                        <option selected> --- Lama Pengerjaan ---</option>
                                        <option value="minggu">Minggu</option>
                                        <option value="bulan">Bulan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="my-3">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Foto Kandang</label>
                                    <input required class="form-control" name="foto-kandang" type="file" id="formFile">
                                </div>
                            </div>
                            <input type="submit" class="btn btn-warning mt-4 form-control" name="tambah" value="Tambah Data">
                        </form>
                    </div>
                </div>
            </div>
            <!-- Bootstrap core JS-->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
            <!-- Core theme JS-->
            <script src="../assets/js/sidebars.js"></script>
    </body>

    </html>

<?php else : ?>

    <?php header("location:index.php") ?>

<?php endif ?>