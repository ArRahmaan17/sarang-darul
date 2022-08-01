<?php
session_start();
if ($_SESSION['nama_petugas'] !== null) {
    include '../conn.php';
    $title = "Tambah Pesanan";
    $queryaccountadmin = "SELECT * FROM pelanggan where account = 'admin'";
    $querydatakandang = "SELECT * FROM kandang";
    $execaccountadmin = mysqli_query($conn, $queryaccountadmin);
    $execdatakandang = mysqli_query($conn, $querydatakandang);
    $id_pelanggan = '';
    if ($execaccountadmin) {
        $dataaccountadmin = mysqli_fetch_array($execaccountadmin, MYSQLI_ASSOC);
        if (count($dataaccountadmin) > 0) {
            $datakandang = mysqli_fetch_all($execdatakandang, MYSQLI_ASSOC);
            $id_pelanggan = $dataaccountadmin['id_pelanggan'];
            $querycheckpesanan = "SELECT * FROM pesanan";
            $execcheckpesanan = mysqli_query($conn, $querycheckpesanan);
            $jumlahpesanan = mysqli_num_rows($execcheckpesanan);
        } else {
            header("location:dashboard.php?pesan=nothing");
        }
    }
    $querydatakeranjang = "SELECT * FROM detail_pesanan JOIN kandang ON kandang.id_kandang = detail_pesanan.id_kandang JOIN pelanggan ON pelanggan.id_pelanggan = detail_pesanan.id_pelanggan WHERE pelanggan.id_pelanggan = $id_pelanggan AND checkout = 0";
    $execdatakeranjang = mysqli_query($conn, $querydatakeranjang);
    if ($execdatakeranjang) {
        $datakeranjang = mysqli_fetch_all($execdatakeranjang, MYSQLI_ASSOC);
        $jumlahdatakeranjang = mysqli_num_rows($execdatakeranjang);
        if ($datakeranjang != null) {
            $kodetransaksi = $datakeranjang[0]['kode_transaksi'];
        } else {
            $querycheckcountpesanan = "SELECT * FROM pesanan";
            $execcheckcountpesanan = mysqli_query($conn, $querycheckcountpesanan);
            $jumlahdatacheckpesanan = mysqli_num_rows($execcheckcountpesanan);
            $kodetransaksi = "$id_pelanggan" . date("Ymd") . $jumlahdatacheckpesanan;
        }
    } else {
        $pesan = "<td colspan='6' class='text-center'>Tidak Ada Data</td>";
    }
    if (isset($_GET['tambahkekeranjang'])) {
        $id_kandang = $_GET['tambahkekeranjang'];
        $querycheckduplicatedata = "SELECT * FROM detail_pesanan JOIN kandang ON kandang.id_kandang = detail_pesanan.id_kandang JOIN pelanggan ON pelanggan.id_pelanggan = detail_pesanan.id_pelanggan WHERE detail_pesanan.id_pelanggan = $id_pelanggan AND detail_pesanan.id_kandang = $id_kandang AND checkout = 0";
        $execcheckduplicate = mysqli_query($conn, $querycheckduplicatedata);
        $datacheckduplicate = mysqli_fetch_array($execcheckduplicate, MYSQLI_ASSOC);
        if ($jumlahdatakeranjang > 0 && $datacheckduplicate['id_pelanggan'] == $id_pelanggan && $datacheckduplicate['id_kandang'] == $id_kandang && $datacheckduplicate['checkout'] == 0) {
            $jumlah_barang = $datacheckduplicate['jumlah_barang'] += 1;
            $querykekeranjang = "UPDATE detail_pesanan SET jumlah_barang = $jumlah_barang WHERE id_pelanggan = $id_pelanggan AND id_kandang = $id_kandang AND checkout = 0";
            $execkekeranjang = mysqli_query($conn, $querykekeranjang);
        } else {
            $querykekeranjang = "INSERT INTO detail_pesanan VALUES(null, '$kodetransaksi', $id_pelanggan, $id_kandang, 1, 0)";
            $execkekeranjang = mysqli_query($conn, $querykekeranjang);
        }
        if ($execkekeranjang) {
            header("location:?pesan=berhasil");
        } else {
            header("location:?pesan=gagal");
        }
    }
    if (isset($_GET['delete'])) {
        $id_kandang = $_GET['delete'];
        $querydetele = "DELETE FROM detail_pesanan WHERE id_pelanggan = $id_pelanggan AND id_kandang = $id_kandang AND kode_transaksi = '$kodetransaksi'";
        $execdelete = mysqli_query($conn, $querydetele);
        if ($execdelete) {
            header("location:tambahpesanan.php");
        }
    }
    if (isset($_GET['kurang'])) {
        $id_kandang = $_GET['kurang'];
        $queryidkandang = "SELECT * FROM detail_pesanan WHERE id_kandang = $id_kandang AND checkout = 0 AND id_pelanggan = $id_pelanggan";
        $execidkandang = mysqli_query($conn, $queryidkandang);
        $dataidkandang = mysqli_fetch_array($execidkandang, MYSQLI_ASSOC);
        $jumlah_barang = $dataidkandang['jumlah_barang'] -= 1;
        $queryupdate = "UPDATE detail_pesanan SET jumlah_barang = (jumlah_barang -1) WHERE id_pelanggan = $id_pelanggan AND id_kandang = $id_kandang";
        $execupdate = mysqli_query($conn, $queryupdate);
        if ($execupdate) {
            header("location:tambahpesanan.php");
        }
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
                                Berhasil Menambahkan Kekeranjang
                            </div>
                        <?php elseif ($_GET['pesan'] === "gagal") : ?>
                            <div class="alert alert-danger m-4" role="alert">
                                Gagal Menambahkan Kekeranjang
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                    <div class="container mt-5 col-8 mx-auto">
                        <h3>Form Tambah Pesanan</h3>
                        <form action="proses.php" method="POST">
                            <div class="my-3">
                                <label for="floatingInput">Kode Transaksi</label>
                                <input type="<?= (isset($kodetransaksi)) ? 'text' : 'hidden' ?>" class="form-control" name="kodetransaksi" id="floatingInput" value="<?= (isset($kodetransaksi)) ? $kodetransaksi : '' ?>" readonly>
                            </div>
                            <div class="my-3">
                                <label for="nama-pelanggan" class="form-label">Nama Pelanggan</label>
                                <select class="form-select" id="nama-pelanggan" disabled>
                                    <option selected value="<?= $id_pelanggan ?>"><?= $dataaccountadmin['nama_pelanggan'] ?> - <?= "62" . $dataaccountadmin['nomer_pelanggan'] ?></option>
                                </select>
                                <input type="hidden" name="id-pelanggan" value="<?= $id_pelanggan ?>">
                            </div>
                            <div class="container col-12 mt-4 p-3 mx-auto border table-responsive">
                                <table class="table caption-top">
                                    <caption class="btn-success text-center rounded disabled fw-bold">list Kandang</caption>
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Model Kandang</th>
                                            <th scope="col">Keterangan</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0 ?>
                                        <?php foreach ($datakandang as $dt) { ?>
                                            <?php $no++ ?>
                                            <tr>
                                                <th scope="row"><?= $no ?></th>
                                                <td><?= $dt['nama_kandang'] ?></td>
                                                <td>
                                                    <li>Ukuran Kandang <?= $dt['ukuran_kandang'] ?></li>
                                                    <li>Bahan Kandang <?= $dt['bahan_kandang'] ?></li>
                                                    <li>Lama Pengerjaan <?= $dt['lama_pengerjaan'] ?></li>
                                                    <li>Harga Kandang <?= $dt['harga_kandang'] ?></li>
                                                </td>
                                                <td><a class="btn btn-success" href="?tambahkekeranjang=<?= $dt['id_kandang'] ?>&id=<?= $id_pelanggan ?>" role="button">Tambah</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <input type="submit" class="btn btn-info mt-4 form-control <?= (!isset($jumlahdatakeranjang)) ? 'disabled opacity-25' : '' ?>" name="checkout" value="Tambah Pesanan">
                        </form>
                    </div>
                    <hr>
                    <div class="container col-6 mt-4 p-3 mx-auto border table-responsive">
                        <table class="table caption-top">
                            <caption class="btn-info text-center rounded disabled fw-bold">list Pesanan</caption>
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Model Kandang</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0 ?>
                                <?php foreach ($datakeranjang as $dt) { ?>
                                    <?php $no++ ?>
                                    <tr class="align-middle">
                                        <th scope="row"><?= $no ?></th>
                                        <td><?= $dt['nama_kandang'] ?></td>
                                        <td><?= $dt['jumlah_barang'] ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-warning" href="?kurang=<?= $dt['id_kandang'] ?>" role="button">Kurang</a>
                                            <a class="btn btn-danger" href="?delete=<?= $dt['id_kandang'] ?>" role="button">Hapus</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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