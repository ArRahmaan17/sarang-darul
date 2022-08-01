<?php
session_start();
if ($_SESSION['nama_petugas'] !== null) {
    include '../conn.php';
    $title = "Riwayat Pesanan";
    if (isset($_GET['detailpesanan'])) {
        if ($_GET['detailpesanan'] == "") {
            header("location:pesanandiproses.php");
        }
        $kodetransaksi = $_GET['detailpesanan'];
        $querydetail = "SELECT * FROM pesanan JOIN detail_pesanan ON pesanan.kode_transaksi = detail_pesanan.kode_transaksi JOIN pelanggan ON pelanggan.id_pelanggan = pesanan.id_pelanggan JOIN kandang ON detail_pesanan.id_kandang = kandang.id_kandang WHERE pesanan.kode_transaksi = '$kodetransaksi'";
        $execdetail = mysqli_query($conn, $querydetail);
        $datadetail = mysqli_fetch_all($execdetail, MYSQLI_ASSOC);
    }
    $querypesanan = "SELECT * FROM pesanan JOIN pelanggan ON pelanggan.id_pelanggan = pesanan.id_pelanggan WHERE pesanan.status_pesanan = 'selesai'";
    $exec = mysqli_query($conn, $querypesanan);
    if ($exec) {
        $data = mysqli_fetch_all($exec, MYSQLI_ASSOC);
        $jumlahdata = mysqli_num_rows($exec);
    } else {
        $pesan = "<td colspan='6' class='text-center'>Belum Ada Riwayat Pesanan Nih</td>";
    }
    $pesan = "<td colspan='6' class='text-center'>Tidak Ada Data</td>";
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
                <div class="sidebar-heading border-bottom col-12 bg-light text-truncate"><?= $title ?></div>
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
                    <?php if (!isset($_GET['detailpesanan'])) : ?>
                        <div class="table-responsive mt-4">
                            <table class="table caption-top">
                                <caption class="btn-success text-center rounded disabled fw-bold">List Kandang Selesai dipesan</caption>
                                <thead class="table-dark">
                                    <tr>
                                        <td class="text-center">No</td>
                                        <td class="text-center">Kode Transaksi</td>
                                        <td class="text-center">Tanggal Pesan</td>
                                        <td class="text-center">Status Pesanan</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0 ?>
                                    <?php if ($jumlahdata) { ?>
                                        <?php foreach ($data as $p) : ?>
                                            <?php $no++ ?>
                                            <tr>
                                                <td class="text-center"><?= $no ?></td>
                                                <td class="text-center"><a class="text-decoration-none text-dark" href="?detailpesanan=<?= $p['kode_transaksi'] ?>"><?= $p['kode_transaksi'] ?></a></td>
                                                <td class="text-center"><?= $p['tanggal_pesan'] ?></td>
                                                <td class="text-center">
                                                    <h5>
                                                        <span class="badge badge-lg rounded-pill bg-secondary text-light"><?= $p['status_pesanan'] ?></span>
                                                    </h5>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php } else { ?>
                                        <?= $pesan ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php elseif (isset($_GET['detailpesanan'])) : ?>
                        <a class="text-decoration-none text-end mt-5 d-block" href="dashboard.php">Kembali</a>
                        <div class="row mt-3">
                            <div class="pb-2 h3">Tanggal Pesan: <?= $datadetail[0]['tanggal_pesan']  ?> & Kode Transaksi: <?= $datadetail[0]['kode_transaksi'] ?></div>
                            <?php foreach ($datadetail as $d) : ?>
                                <div class="col-md-8 mt-4">
                                    <div class="row">
                                        <div class="col-md-6">Bahan Kandang: <?= $d['bahan_kandang'] ?> & Ukuran Kandang: <?= $d['ukuran_kandang'] ?></div>
                                        <div class="col-md-6">Model Kandang: <?= $d['nama_kandang'] ?></div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <img height="150px" alt="Foto Kandang" src="../assets/img/foto-kandang/<?= $d['foto_kandang'] ?>">
                                </div>
                            <?php endforeach ?>
                            <div class="d-flex justify-content-center mt-5">
                                <div class="col-6 m-2">
                                    <a class="form-control btn-secondary text-center text-decoration-none" target="blank" href="../cetak.php?id=<?= $d['id_pelanggan'] ?>&kode=<?= $d['kode_transaksi'] ?>">Cetak</a>
                                </div>
                                <div class="col-6 m-2">
                                    <a class="form-control btn-success text-center text-decoration-none" target="blank" href="https://wa.me/<?= $d['nomer_pelanggan'] ?>">Hubungi Pelanggan</a>
                                </div>
                            </div>
                        <?php else : ?>
                            <h1> <?= $pesan; ?> </h1>
                        <?php endif ?>
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