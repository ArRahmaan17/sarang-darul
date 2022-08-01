<?php
session_start();
if ($_SESSION['nama_petugas'] !== null) {
    include '../conn.php';
    $title = "Data User";
    $querydatapelanggan = "SELECT * FROM pelanggan";
    $execdatapelanggan = mysqli_query($conn, $querydatapelanggan);
    $datapelanggan = mysqli_fetch_all($execdatapelanggan, MYSQLI_ASSOC);
    $querydataadmin = "SELECT * FROM admin WHERE id_petugas != " . $_SESSION['id_petugas'];
    $execdataadmin = mysqli_query($conn, $querydataadmin);
    $dataadmin = mysqli_fetch_all($execdataadmin, MYSQLI_ASSOC);
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
                    <?php if (isset($_GET['pesan'])) : ?>
                        <?php if ($_GET['pesan'] === "berhasil") : ?>
                            <div class="alert alert-success m-4" role="alert">
                                Berhasil
                            </div>
                        <?php elseif ($_GET['pesan'] === "gagal") : ?>
                            <div class="alert alert-danger m-4" role="alert">
                                Gagal
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                    <?php if (!isset($_GET['proses']) && !isset($_GET['kode'])) : ?>
                        <div class="container col-xxl-12 mb-3">
                            <div class="row flex-lg py-3">
                                <div class="col-12 offset-10">
                                    <a class="btn btn-info" href="daftar.php">Tambah Pegawai</a>
                                </div>
                                <div class="col-6">
                                    <div class="table-responsive mt-4">
                                        <table class="table caption-top">
                                            <caption class="btn-warning text-center rounded disabled fw-bold">List User</caption>
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Nama Pelanggan</th>
                                                    <th scope="col">Kode Transaksi</th>
                                                    <th scope="col">Account Status</th>
                                                    <th>Proses Pesanan</th>
                                                </tr>
                                            </thead>
                                            <tbody class="align-middle">
                                                <?php $no = 0 ?>
                                                <?php if (isset($datapelanggan)) : ?>
                                                    <?php foreach ($datapelanggan as $dp) { ?>
                                                        <?php $no++ ?>
                                                        <tr>
                                                            <th scope="row"><?= $no ?></th>
                                                            <td><?= $dp['nama_pelanggan'] ?></td>
                                                            <td><?= "0" . $dp['nomer_pelanggan'] ?></td>
                                                            <td><?= "Account " . $dp['account'] ?></td>
                                                            <td>
                                                                <a class="btn btn-<?= ($dp['account'] == 'admin') ? 'info' : 'warning' ?>" href="updateuser.php?id_pelanggan=<?= $dp['id_pelanggan'] ?>">Edit Data</a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php else : ?>
                                                    <?= $pesan ?>
                                                <?php endif ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="table-responsive mt-4">
                                        <table class="table caption-top">
                                            <caption class="btn-success text-center rounded disabled fw-bold">List Admin</caption>
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Nama Pelanggan</th>
                                                    <th scope="col">Kode Transaksi</th>
                                                    <th>Status Pesanan</th>
                                                </tr>
                                            </thead>
                                            <tbody class="align-middle">
                                                <?php $no = 0 ?>
                                                <?php if (isset($dataadmin)) : ?>
                                                    <?php foreach ($dataadmin as $da) { ?>
                                                        <?php $no++ ?>
                                                        <tr>
                                                            <th scope="row"><?= $no ?></th>
                                                            <td><?= $da['nama_petugas'] ?></td>
                                                            <td><?= "0" . $da['nomer_petugas'] ?></td>
                                                            <td>
                                                                <a class="btn btn-warning" href="updateuser.php?id_admin=<?= $da['id_petugas'] ?>">Edit Data</a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php else : ?>
                                                    <?= $pesan ?>
                                                <?php endif ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['proses']) && isset($_GET['kode'])) : ?>
                        <a class="text-decoration-none text-end mt-5 d-block" href="dashboard.php">Kembali</a>
                        <div class="row mt-3">
                            <div class="pb-2 h3">Tanggal Pesan: <?= $datadetailpesanan[0]['tanggal_pesan']  ?> & Kode Transaksi: <?= $datadetailpesanan[0]['kode_transaksi'] ?></div>
                            <?php foreach ($datadetailpesanan as $d) : ?>
                                <div class="col-md-8 mt-4">
                                    <div class="row">
                                        <div class="col-md-6">Bahan Kandang: <?= $d['bahan_kandang'] ?> & Ukuran Kandang: <?= $d['ukuran_kandang'] ?></div>
                                        <div class="col-md-6">Model Kandang: <?= $d['nama_kandang'] ?></div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <?php if ($d['foto_kandang']) : ?>
                                        <img height="150px" alt="Foto Kandang" src="../assets/img/foto-kandang/<?= $d['foto_kandang'] ?>">
                                    <?php endif ?>
                                </div>
                            <?php endforeach ?>
                            <?php if ($datadetailpesanan[0]['status_pesanan'] == 'selesai') { ?>
                                <div class="d-flex mt-5">
                                    <div class="col-6 m-2">
                                        <a class="form-control btn-info text-center text-decoration-none" target="blank" href="https://wa.me/<?= $d['nomer_pelanggan'] ?>">Cetak</a>
                                    </div>
                                    <div class="col-6 m-2">
                                        <a class="form-control btn-success text-center text-decoration-none" target="blank" href="https://wa.me/<?= $d['nomer_pelanggan'] ?>">Hubungi Pelanggan</a>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <?php $textpesan = "Bpk/Ibu " . $datadetailpesanan[0]['nama_pelanggan'] . " Pesanana Anda Sudah Mulai Kami Proses. \n Tertanda\n Admin"; ?>
                                <div class="col-12 my-2">
                                    <a class="form-control btn-success text-center text-decoration-none" target="blank" href="https://wa.me/<?= $d['nomer_pelanggan'] ?>?text=<?= $textpesan ?>">Hubungi Pelanggan</a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                </div>
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