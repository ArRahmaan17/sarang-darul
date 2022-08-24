<?php
session_start();
if ($_SESSION['nama_petugas'] !== null) {
    include '../conn.php';
    $title = "Dashboard Petugas";
    $querypesananproses = "SELECT * FROM pesanan JOIN pelanggan ON pelanggan.id_pelanggan = pesanan.id_pelanggan WHERE pesanan.status_pesanan = 'proses' OR pesanan.status_pesanan = 'jeruji' OR pesanan.status_pesanan = 'rangka' OR pesanan.status_pesanan = 'perangkaian' OR pesanan.status_pesanan = 'finishing'";
    $querypesananselesai = "SELECT * FROM pesanan JOIN pelanggan ON pelanggan.id_pelanggan = pesanan.id_pelanggan WHERE pesanan.status_pesanan = 'selesai'";
    $querypesanansiap = "SELECT * FROM pesanan JOIN pelanggan ON pelanggan.id_pelanggan = pesanan.id_pelanggan WHERE pesanan.status_pesanan = 'siapkirim'";
    if (isset($_GET['proses']) && isset($_GET['kode'])) {
        $kodetransaksi = $_GET['kode'];
        $id_pesanan = $_GET['proses'];
        $querydetail = "SELECT * FROM pesanan JOIN detail_pesanan ON pesanan.kode_transaksi = detail_pesanan.kode_transaksi JOIN pelanggan ON pelanggan.id_pelanggan = pesanan.id_pelanggan JOIN kandang ON detail_pesanan.id_kandang = kandang.id_kandang WHERE pesanan.kode_transaksi = '$kodetransaksi'";
        $execdetailpesanan = mysqli_query($conn, $querydetail);
        $datadetailpesanan = mysqli_fetch_all($execdetailpesanan, MYSQLI_ASSOC);
    }
    if (isset($_GET['update'])) {
        $kodetransaksi = $_GET['kode'];
        $update = $_GET['update'];
        $queryupdate = "UPDATE pesanan SET status_pesanan = '$update' WHERE kode_transaksi = '$kodetransaksi'";
        // var_dump($queryupdate);
        // die();
        mysqli_query($conn, $queryupdate);
        header("location:dashboard.php?pesan=berhasil");
    }
    $execpesananproses = mysqli_query($conn, $querypesananproses);
    $execpesananselesai = mysqli_query($conn, $querypesananselesai);
    $execpesanansiap = mysqli_query($conn, $querypesanansiap);
    $jumlahpesananproses = mysqli_num_rows($execpesananproses);
    $jumlahpesanansiap = mysqli_num_rows($execpesanansiap);
    $jumlahpesananselesai = mysqli_num_rows($execpesananselesai);
    if ($execpesananproses) {
        $datapesananproses = mysqli_fetch_all($execpesananproses, MYSQLI_ASSOC);
        $jumlahdatapesanan = mysqli_num_rows($execpesananproses);
        $pesan = "<td colspan='6' class='text-center'>Tidak Ada Data</td>";
    } else {
        $pesan = "<td colspan='6' class='text-center'>Belum Ada Pesanan Yang DiProses Nih</td>";
    }
    if ($execpesananselesai) {
        $datapesananselesai = mysqli_fetch_all($execpesananselesai, MYSQLI_ASSOC);
        $jumlahdatapesanan = mysqli_num_rows($execpesananselesai);
        $pesan = "<td colspan='6' class='text-center'>Tidak Ada Data</td>";
    } else {
        $pesan = "<td colspan='6' class='text-center'>Belum Ada Pesanan Selesai Nih</td>";
    }
    if ($execpesanansiap) {
        $datapesanansiap = mysqli_fetch_all($execpesanansiap, MYSQLI_ASSOC);
        $jumlahdatapesanan = mysqli_num_rows($execpesanansiap);
        $pesan = "<td colspan='6' class='text-center'>Tidak Ada Data</td>";
    } else {
        $pesan = "<td colspan='6' class='text-center'>Belum Ada Pesanan Selesai Nih</td>";
    }
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
                        <?php elseif ($_GET['pesan'] === "nothing") : ?>
                            <div class="alert alert-danger m-4" role="alert">
                                Account Admin Belum Di Miliki
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                    <?php if (!isset($_GET['proses']) && !isset($_GET['kode'])) : ?>
                        <div class="container col-xxl-12 mb-3">
                            <div class="row flex-lg align-items-center g-1 py-3">
                                <div class="col-12">
                                    <div class="table-responsive mt-4">
                                        <table class="table caption-top">
                                            <caption class="btn-warning text-center rounded disabled fw-bold">List Kandang Sedang diProses</caption>
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Nama Pelanggan</th>
                                                    <th scope="col">Kode Transaksi</th>
                                                    <th>Proses Pesanan</th>
                                                </tr>
                                            </thead>
                                            <tbody class="align-middle">
                                                <?php $no = 0 ?>
                                                <?php if (count($datapesananproses) > 0) : ?>
                                                    <?php for ($i = 0; $i < $jumlahpesananproses; $i++) { ?>
                                                        <?php $no++ ?>
                                                        <tr>
                                                            <th scope="row"><?= $no ?></th>
                                                            <td><?= $datapesananproses[$i]['nama_pelanggan'] ?></td>
                                                            <td>
                                                                <?= $datapesananproses[$i]['kode_transaksi'] ?>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-info" href="?proses=<?= $datapesananproses[$i]['id_pesanan'] ?>&kode=<?= $datapesananproses[$i]['kode_transaksi']; ?>">
                                                                    <?php if ($datapesananproses[$i]['status_pesanan'] == 'jeruji') {
                                                                        echo "Pembuatan Jejuri";
                                                                    } elseif ($datapesananproses[$i]['status_pesanan'] == 'rangka') {
                                                                        echo "Pembuatan Rangka";
                                                                    } else {
                                                                        echo $datapesananproses[$i]['status_pesanan'];
                                                                    }
                                                                    ?>
                                                                </a>
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
                                <div class="col-12">
                                    <div class="table-responsive mt-4">
                                        <table class="table caption-top">
                                            <caption class="btn-info text-center rounded disabled fw-bold">List Kandang Siap Dikirim</caption>
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
                                                <?php if (count($datapesanansiap) > 0) : ?>
                                                    <?php for ($i = 0; $i < $jumlahpesanansiap; $i++) { ?>
                                                        <?php $no++ ?>
                                                        <tr>
                                                            <th scope="row"><?= $no ?></th>
                                                            <td><?= $datapesanansiap[$i]['nama_pelanggan'] ?></td>
                                                            <td>
                                                                <?= $datapesanansiap[$i]['kode_transaksi'] ?>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-success" href="?proses=<?= $datapesanansiap[$i]['id_pelanggan'] ?>&kode=<?= $datapesanansiap[$i]['kode_transaksi']; ?>">SIAP KIRIM</a>
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
                                <div class="col-12">
                                    <div class="table-responsive mt-4">
                                        <table class="table caption-top">
                                            <caption class="btn-success text-center rounded disabled fw-bold">List Kandang Selesai dipesan</caption>
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
                                                <?php if (count($datapesananselesai) > 0) : ?>
                                                    <?php for ($i = 0; $i < $jumlahpesananselesai; $i++) { ?>
                                                        <?php $no++ ?>
                                                        <tr>
                                                            <th scope="row"><?= $no ?></th>
                                                            <td><?= $datapesananselesai[$i]['nama_pelanggan'] ?></td>
                                                            <td>
                                                                <?= $datapesananselesai[$i]['kode_transaksi'] ?>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-success" href="?proses=<?= $datapesananselesai[$i]['id_pelanggan'] ?>&kode=<?= $datapesananselesai[$i]['kode_transaksi']; ?>">SELESAI</a>
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
                                    <?php if (isset($d['foto_pembayaran'])) { ?>
                                        <img height="150px" alt="Foto Kandang" data-bs-toggle="modal" data-bs-target="#fotopembayaran" src="../assets/img/foto-pembayaran/<?= $d['foto_pembayaran'] ?>">
                                    <?php } ?>
                                    <img height="150px" alt="Foto Kandang" src="../assets/img/foto-kandang/<?= $d['foto_kandang'] ?>">
                                </div>
                            <?php endforeach ?>
                            <?php if ($datadetailpesanan[0]['status_pesanan'] == 'selesai') { ?>
                                <div class="d-flex justify-content-center mt-5">
                                    <div class="col-6 m-2">
                                        <a class="form-control btn-secondary text-center text-decoration-none" target="blank" href="../cetak.php?id=<?= $d['id_pelanggan'] ?>&kode=<?= $d['kode_transaksi'] ?>">Cetak</a>
                                    </div>
                                    <div class="col-6 m-2">
                                        <a class="form-control btn-success text-center text-decoration-none" target="blank" href="https://wa.me/62<?= $d['nomer_pelanggan'] ?>?text=<?= $textpesan ?>">Hubungi Pelanggan</a>
                                    </div>
                                </div>
                            <?php } elseif ($datadetailpesanan[0]['status_pesanan'] == 'siapkirim') { ?>
                                <div class="d-flex justify-content-center mt-5">
                                    <div class="col-4 m-2">
                                        <a class="form-control btn btn-info text-center text-decoration-none <?= ($datadetailpesanan[0]['foto_pembayaran'] == null) ? 'disabled' : ''; ?>" role="button" href="?update=selesai&kode=<?= $datadetailpesanan[0]['kode_transaksi'] ?>" aria-disabled="true">Selesaikan Pesanan</a>
                                    </div>
                                    <div class="col-4 m-2">
                                        <?php $textpesan = "Bpk/Ibu " . $datadetailpesanan[0]['nama_pelanggan'] . " Pesanana Anda Sudah Siap Dikirim Mohon Untuk Melakukan Pembayaran . \n Tertanda\n Admin"; ?>
                                        <a class="form-control btn-success text-center text-decoration-none" target="blank" href="https://wa.me/62<?= $d['nomer_pelanggan'] ?>?text=<?= $textpesan ?>">Hubungi Pelanggan Siap Kirim</a>
                                    </div>
                                </div>
                                <div class="col-12 m-2">
                                    <a class="form-control btn-secondary text-center text-decoration-none" target="blank" href="../cetak.php?id=<?= $d['id_pelanggan'] ?>&kode=<?= $d['kode_transaksi'] ?>">Cetak</a>
                                </div>
                            <?php } else { ?>
                                <div class="d-flex justify-content-center mt-5">
                                    <?php if ($datadetailpesanan[0]['status_pesanan'] == 'proses') { ?>
                                        <div class="col-4 m-2">
                                            <a class="form-control btn-warning text-center text-decoration-none" href="?update=jeruji&kode=<?= $datadetailpesanan[0]['kode_transaksi'] ?>">Update Pembuatan Jeruji</a>
                                        </div>
                                    <?php } ?>
                                    <?php if ($datadetailpesanan[0]['status_pesanan'] == 'jeruji') { ?>
                                        <div class="col-4 m-2">
                                            <a class="form-control btn-warning text-center text-decoration-none" href="?update=rangka&kode=<?= $datadetailpesanan[0]['kode_transaksi'] ?>">Update Pembuatan Rangka</a>
                                        </div>
                                    <?php } ?>
                                    <?php if ($datadetailpesanan[0]['status_pesanan'] == 'rangka') { ?>
                                        <div class="col-4 m-2">
                                            <a class="form-control btn-warning text-center text-decoration-none" href="?update=perangkaian&kode=<?= $datadetailpesanan[0]['kode_transaksi'] ?>">Update Proses Perangkaian</a>
                                        </div>
                                    <?php } ?>
                                    <?php if ($datadetailpesanan[0]['status_pesanan'] == 'perangkaian') { ?>
                                        <div class="col-4 m-2">
                                            <a class="form-control btn-warning text-center text-decoration-none" href="?update=finishing&kode=<?= $datadetailpesanan[0]['kode_transaksi'] ?>">Update Proses Finishing</a>
                                        </div>
                                    <?php } ?>
                                    <?php if ($datadetailpesanan[0]['status_pesanan'] == 'finishing') { ?>
                                        <div class="col-4 m-2">
                                            <a class="form-control btn-warning text-center text-decoration-none" href="?update=siapkirim&kode=<?= $datadetailpesanan[0]['kode_transaksi'] ?>">Update Siap Kirim</a>
                                        </div>
                                    <?php } ?>
                                    <div class="col-4 m-2">
                                        <?php $textpesan = "Bpk/Ibu " . $datadetailpesanan[0]['nama_pelanggan'] . " Pesanana Anda Sudah Mulai Kami Proses. \n Tertanda\n Admin"; ?>
                                        <a class="form-control btn-success text-center text-decoration-none" target="blank" href="https://wa.me/62<?= $d['nomer_pelanggan'] ?>?text=<?= $textpesan ?>">Hubungi Pelanggan</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="modal fade" id="fotopembayaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> -->
                    <div class="modal-body">
                        <div class="col-12 align_middle text-center">
                            <img alt="Foto Kandang" src="../assets/img/foto-pembayaran/<?= $d['foto_pembayaran'] ?>">
                        </div>
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