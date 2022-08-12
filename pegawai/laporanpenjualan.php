<?php
session_start();
include '../conn.php';
$title = "Laporan Penjualan";
$querypesanan = "SELECT * FROM pesanan JOIN pelanggan ON pelanggan.id_pelanggan = pesanan.id_pelanggan";
$querydetail = "SELECT detail_pesanan.*, kandang.id_kandang, kandang.nama_kandang, kandang.harga_kandang FROM pesanan JOIN pelanggan ON pelanggan.id_pelanggan = pesanan.id_pelanggan JOIN detail_pesanan ON detail_pesanan.kode_transaksi = pesanan.kode_transaksi JOIN kandang ON kandang.id_kandang = detail_pesanan.id_kandang";
$execpesanan = mysqli_query($conn, $querypesanan);
$execdetail = mysqli_query($conn, $querydetail);
$jumlahpesanan = mysqli_num_rows($execpesanan);
$pesan = "<td colspan='6' class='text-center'>Tidak Ada Data</td>";
$datapesanan = '';
if ($execpesanan && $execdetail) {
    $datapesanan = mysqli_fetch_all($execpesanan, MYSQLI_ASSOC);
    $datadetail = mysqli_fetch_all($execdetail, MYSQLI_ASSOC);
    $querydetailpesanan = "SELECT * FROM pesanan JOIN detail_pesanan ON detail_pesanan.kode_transaksi = pesanan.kode_transaksi JOIN kandang ON kandang.id_kandang = detail_pesanan.id_kandang WHERE detail_pesanan.checkout = 1";
    $execdetailpesanan = mysqli_query($conn, $querydetailpesanan);
    $datadetailpesanan = mysqli_fetch_all($execdetailpesanan, MYSQLI_ASSOC);
    foreach ($datadetailpesanan as $data) {
        $pendapatanan = 0;
        $pendapatantotal[] = $pendapatanan += $data['jumlah_barang'] * $data['harga_kandang'];
        $pendapattotal = 0;
        foreach ($pendapatantotal as $total) {
            $pendapattotal += $total;
        }
    }
} else {
    $pesan = "<td colspan='6' class='text-center'>Belum Ada Pesanan Yang DiProses Nih</td>";
}
if (isset($_POST['cari'])) {
    unset($datapesanan);
    unset($datadetail);
    $tanggalsekarang = date('Y-m-d');
    $queryfilter = "SELECT * FROM pesanan JOIN pelanggan ON pelanggan.id_pelanggan = pesanan.id_pelanggan ";
    $querydetail = "SELECT detail_pesanan.*, kandang.id_kandang, kandang.nama_kandang, kandang.harga_kandang FROM pesanan JOIN pelanggan ON pelanggan.id_pelanggan = pesanan.id_pelanggan JOIN detail_pesanan ON detail_pesanan.kode_transaksi = pesanan.kode_transaksi JOIN kandang ON kandang.id_kandang = detail_pesanan.id_kandang ";
    $tanggalawal = $_POST['tanggalawal'];
    $tanggalakhir = $_POST['tanggalakhir'];
    $kodetransaksi = $_POST['kodetranksaksi'];
    $statuspesaan = $_POST['status_pesanan'];

    if ($_POST != '') {
        $queryfilter .= "WHERE ";
        $querydetail .= "WHERE ";
        if (($tanggalawal and $tanggalakhir) != '') {
            $queryfilter .= " (tanggal_pesan BETWEEN '$tanggalawal' AND '$tanggalakhir') ";
            $querydetail .= " (tanggal_pesan BETWEEN '$tanggalawal' AND '$tanggalakhir') ";
        } elseif ($kodetransaksi != '') {
            $queryfilter .= " kode_transaksi = '$kodetransaksi' ";
            $querydetail .= " kode_transaksi = '$kodetransaksi' ";
        } elseif ($statuspesaan != '' && $statuspesaan != 'Semua Pesanan') {
            $queryfilter .= " status_pesanan = '$statuspesaan'";
            $querydetail .= " status_pesanan = '$statuspesaan'";
        } else {
            $queryfilter .= "(tanggal_pesan BETWEEN '2010-01-01' AND '$tanggalsekarang') ";
            $querydetail .= "(tanggal_pesan BETWEEN '2010-01-01' AND '$tanggalsekarang') ";
        }
    }

    $execfilter = mysqli_query($conn, $queryfilter);
    $execdetail = mysqli_query($conn, $querydetail);

    $jumlahfilter = mysqli_num_rows($execfilter);
    if ($jumlahfilter > 0) {
        $jumlahpesanan = $jumlahfilter;
        $print = "yes";
        $datapesanan = mysqli_fetch_all($execfilter, MYSQLI_ASSOC);
        $datadetail = mysqli_fetch_all($execdetail, MYSQLI_ASSOC);
        $querydetailpesanan = "SELECT * FROM pesanan JOIN detail_pesanan ON detail_pesanan.kode_transaksi = pesanan.kode_transaksi JOIN kandang ON kandang.id_kandang = detail_pesanan.id_kandang WHERE detail_pesanan.checkout = 1";
        $execdetailpesanan = mysqli_query($conn, $querydetailpesanan);
        $datadetailpesanan = mysqli_fetch_all($execdetailpesanan, MYSQLI_ASSOC);
        foreach ($datadetailpesanan as $data) {
            $pendapatanan = 0;
            $pendapatantotal[] = $pendapatanan += $data['jumlah_barang'] * $data['harga_kandang'];
            $pendapattotal = 0;
            foreach ($pendapatantotal as $total) {
                $pendapattotal += $total;
            }
        }
    }
    // var_dump($datapesanan);
    // var_dump($datadetail);
    // die();
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
        <style>
            @media print {
                div.form-pencarian {
                    display: none;
                }

                div.laporan {
                    display: block;
                }
            }
        </style>
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
                    <div class="container col-xxl-12 mb-3">
                        <div class="row flex-lg align-items-end g-1 py-3">
                            <div class="col-12 mt-4 form-pencarian">
                                <form class="row g-3" method="POST">
                                    <div class="col-auto">
                                        <label for="tanggalawal" class="visually-hidden">tanggal awal</label>
                                        <input type="date" class="form-control" max="<?= date('Y-m-d') ?>" name="tanggalawal" id="tanggalawal" placeholder="Password">
                                    </div>
                                    <div class="col-auto">
                                        <label for="tanggalakhir" class="visually-hidden">tanggal akhir</label>
                                        <input type="date" class="form-control" max="<?= date('Y-m-d') ?>" name="tanggalakhir" id="tanggalakhir" placeholder="Password">
                                    </div>
                                    <div class="col-auto">
                                        <label for="kodetranksaksi" class="visually-hidden">kode transaksi</label>
                                        <input type="text" class="form-control" placeholder="masukan kode transaksi" name="kodetranksaksi" id="kodetransaksi" placeholder="Password">
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select" name="status_pesanan" aria-label="Default select example">
                                            <option selected>Semua Pesanan</option>
                                            <option value="jeruji">Pembuatan Jeruji</option>
                                            <option value="2">Pembuatan Rangka</option>
                                            <option value="3">Perangkaian</option>
                                            <option value="4">Finishing</option>
                                            <option value="5">Sipa Kirim</option>
                                            <option value="6">Selesai</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <input type="submit" name="cari" value="Cari Dan Cetak" class="btn btn-primary mb-3">
                                    </div>
                                </form>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive mt-2">
                                    <table class="table caption-top">
                                        <caption class="btn-warning text-center rounded disabled fw-bold">List Pesanan Kandang</caption>
                                        <thead class="table-dark">
                                            <tr>
                                                <th>No</th>
                                                <th scope="col">Nama Pelanggan</th>
                                                <th scope="col">Nama Kandang</th>
                                                <th>Status Pesanan</th>
                                                <th scope="col">Total Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody class="align-middle">
                                            <?php $no = 0 ?>
                                            <?php if (isset($datapesanan)) : ?>
                                                <?php for ($i = 0; $i < $jumlahpesanan; $i++) { ?>

                                                    <?php $no++ ?>
                                                    <tr>
                                                        <td class="col"><?= $no ?></td>
                                                        <td class="col"><?= $datapesanan[$i]['nama_pelanggan'] ?></td>
                                                        <td class="col">
                                                            <?php foreach ($datadetail as $key) {
                                                                if ($datapesanan[$i]['kode_transaksi'] == $key['kode_transaksi']) { ?>
                                                                    <?= "Model Kandang " . $key['nama_kandang'] . "<br>" ?>
                                                            <?php }
                                                            } ?>
                                                        </td>
                                                        <td class="col"><?= strtoupper(($datapesanan[$i]['status_pesanan'] == 'jeruji') ? 'Pembuatan Jeruji' : ($datapesanan[$i]['status_pesanan'] == 'rangka') ? 'Pembuatan Rangka' : $datapesanan[$i]['status_pesanan']) ?></td>
                                                        <td class="col">
                                                            <?php foreach ($datadetail as $key) {
                                                                if ($datapesanan[$i]['kode_transaksi'] == $key['kode_transaksi']) {
                                                                    echo number_format($key['jumlah_barang'] * $key['harga_kandang'], 2, ".", ",") . "<br>";
                                                                } ?>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php else : ?>
                                                <?= $pesan ?>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                    <div class="laporan">
                                        <tr>
                                            <td>Total Pesanan</td>
                                            <td>:</td>
                                            <td><b><?= $jumlahpesanan ?></b>, </td>
                                            <td>Pendapatan Total</td>
                                            <td>:</td>
                                            <td>Rp.<?= number_format($pendapattotal, 2, ".", ",") ?></td>
                                        </tr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <!-- Core theme JS-->
        <script src="../assets/js/sidebars.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <?php if (isset($print)) { ?>
            <script>
                $(document).ready(function() {
                    window.print()
                });
            </script>
        <?php } ?>

    </body>

    </html>

<?php else : ?>
    <?php header("location:index.php") ?>
<?php endif ?>