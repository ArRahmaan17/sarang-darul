<?php
session_start();
// var_dump($_SESSION);
if ($_SESSION['nama_pelanggan'] !== null) {
    include '../conn.php';
    $title = "Dashboard Pelanggan";
    $id_pelanggan = $_SESSION['id_pelanggan'];
    $querypesanan = "SELECT * FROM pesanan JOIN detail_pesanan ON pesanan.kode_transaksi = detail_pesanan.kode_transaksi JOIN pelanggan ON detail_pesanan.id_pelanggan = pelanggan.id_pelanggan JOIN kandang ON detail_pesanan.id_kandang = kandang.id_kandang WHERE pesanan.status_pesanan = 'proses' AND pesanan.id_pelanggan = $id_pelanggan";
    $querykandangmanuk = "SELECT * FROM kandang";
    $execpesanan = mysqli_query($conn, $querypesanan);
    $execkandang = mysqli_query($conn, $querykandangmanuk);
    if ($execpesanan) {
        $datapesanan = mysqli_fetch_all($execpesanan, MYSQLI_ASSOC);
        $jumlahdatapesanan = mysqli_num_rows($execpesanan);
    }
    if ($execkandang) {
        $datakandang = mysqli_fetch_all($execkandang, MYSQLI_ASSOC);
    }

    if (isset($_GET['tambahkekeranjang'])) {
        $id_kandang = $_GET['tambahkekeranjang'];
        $querycheckcountpesanan = "SELECT * FROM pesanan";
        $execcheckcountpesanan = mysqli_query($conn, $querycheckcountpesanan);
        $jumlahdatacheckpesanan = mysqli_num_rows($execcheckcountpesanan);
        $kodetransaksi = "$id_pelanggan" . date("Ymd") . $jumlahdatacheckpesanan;
        $_SESSION['kodetransaksi'] = $kodetransaksi;
        $querycheckkeranjang = "SELECT * FROM detail_pesanan WHERE id_pelanggan = $id_pelanggan AND id_kandang = $id_kandang AND checkout = 0";
        // var_dump($querycheckkeranjang);
        $execcheckkeranjang = mysqli_query($conn, $querycheckkeranjang);
        $jumlahdatacheck = mysqli_num_rows($execcheckkeranjang);
        $datacheck = mysqli_fetch_array($execcheckkeranjang, MYSQLI_ASSOC);
        if ($jumlahdatacheck > 0 && $datacheck['id_kandang'] == $id_kandang && $datacheck['checkout'] == 0 && $datacheck['id_pelanggan'] == $id_pelanggan) {
            $jumlahbarang = $datacheck['jumlah_barang'] + 1;
            $queryaddtocart = "UPDATE detail_pesanan SET jumlah_barang = $jumlahbarang WHERE id_kandang = $id_kandang AND id_pelanggan = $id_pelanggan AND checkout = 0";
        } else {
            $queryaddtocart = "INSERT INTO detail_pesanan VALUES(null, $kodetransaksi, $id_pelanggan, $id_kandang, 1, 0)";
        }
        $querykeranjang = "SELECT * FROM detail_pesanan JOIN pelanggan ON detail_pesanan.id_pelanggan = pelanggan.id_pelanggan WHERE pelanggan.id_pelanggan = $id_pelanggan AND checkout = 0";
        $execkeranjang = mysqli_query($conn, $querykeranjang);
        if ($execkeranjang) {
            $jumlahkeranjang = mysqli_num_rows($execkeranjang);
            $_SESSION['datakeranjang'] = $jumlahkeranjang;
        }
        $exec = mysqli_query($conn, $queryaddtocart);
        header("location:dashboard.php?pesan=berhasil");
    }

    $querykeranjang = "SELECT * FROM detail_pesanan JOIN pelanggan ON detail_pesanan.id_pelanggan = pelanggan.id_pelanggan WHERE pelanggan.id_pelanggan = $id_pelanggan AND checkout = 0";
    $execkeranjang = mysqli_query($conn, $querykeranjang);
    if ($execkeranjang) {
        $jumlahkeranjang = mysqli_num_rows($execkeranjang);
        $_SESSION['datakeranjang'] = $jumlahkeranjang;
    }
}
?>

<?php if ($_SESSION['nama_pelanggan'] !== null) : ?>
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
                <div class="sidebar-heading border-bottom col-12 bg-light text-truncate "><?= $title ?></div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= ($title === "Dashboard Pelanggan") ? 'active' : ''; ?>" href="dashboard.php">Dashboard</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= ($title === "Pesanan Sedang Proses") ? 'active' : ''; ?>" href="pesanandiproses.php">Pesanan Sedang Proses</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= ($title === "Pesanan Siap Kirim") ? 'active' : ''; ?>" href="pesanansiap.php">Pesanan Siap Kirim</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= ($title === "Riwayat Pesanan") ? 'active' : ''; ?>" href="riwayatpesanan.php">Riwayat Pesanan</a>
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
                                <li class="nav-item m-2">
                                    <a class="align-middle text-muted position-relative <?= ($jumlahkeranjang == 0) ? 'd-none' : ''; ?>" href="keranjang.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
                                            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5z" />
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= $jumlahkeranjang ?></span>
                                        </svg>
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['nama_pelanggan'] ?></a>
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
                                Berhasil Menambahkan antrian
                            </div>
                        <?php elseif ($_GET['pesan'] === "gagal") : ?>
                            <div class="alert alert-danger m-4" role="alert">
                                Gagal Menambahkan Antrian
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                    <?php if (isset($pesan)) : ?>
                        <h1> <?= $pesan; ?> </h1>
                    <?php endif ?>
                    <div class="container col-xxl-12 mb-3">
                        <div class="row">
                            <h3>Daftar Pesanan Kandang Manuk</h3>
                            <?php if (isset($jumlahdatapesanan)) : ?>
                                <div class="col-lg-12 d-flex table-responsive" style="overflow-x: scroll;">
                                    <?php if ($jumlahdatapesanan > 0) { ?>
                                        <?php foreach ($datapesanan as $p) : ?>
                                            <div class="card m-1" style="min-width:540px;">
                                                <div class="row g-0">
                                                    <div class="col-md-4">
                                                        <img src="../assets/img/foto-kandang/<?= $p['foto_kandang'] ?>" class="img-fluid rounded-start" alt="<?= $p['foto_kandang'] ?>">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Pesanan Kandang <?= $p['nama_kandang'] ?></h5>
                                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                                            <p class="card-text"><small class="text-muted">Tanggal Pesan <?= $p['tanggal_pesan'] ?> Status Pesanan <?php if ($datapesananproses[$i]['status_pesanan'] == 'jeruji') {
                                                                                                                                                                        echo "Pembuatan Jejuri";
                                                                                                                                                                    } elseif ($datapesananproses[$i]['status_pesanan'] == 'rangka') {
                                                                                                                                                                        echo "Pembuatan Rangka";
                                                                                                                                                                    } else {
                                                                                                                                                                        echo $datapesananproses[$i]['status_pesanan'];
                                                                                                                                                                    }
                                                                                                                                                                    ?></small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php } else { ?>
                                        <?= "<h5>Belum memiliki Pesanan nih</h5>" ?>
                                    <?php } ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <hr>
                    <div class="container col-xxl-12 mb-3">
                        <div class="row flex-lg align-items-center g-1 py-3">
                            <div class="col-lg-12">
                                <h3>Daftar Kandang Manuk</h3>
                                <table class="table caption-top">
                                    <caption>Kandang Yang Dapat Di Pesan</caption>
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Kandang</th>
                                            <th scope="col">Ukuran Kandang</th>
                                            <th scope="col">Bahan Kandang</th>
                                            <th scope="col">Foto Kandang</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="align-middle">
                                        <?php $no = 0 ?>
                                        <?php foreach ($datakandang as $k) : ?>
                                            <?php $no++ ?>
                                            <tr>
                                                <th scope="row"><?= $no ?></th>
                                                <td><?= $k['nama_kandang'] ?></td>
                                                <td><?= $k['ukuran_kandang'] ?></td>
                                                <td><?= $k['bahan_kandang'] ?></td>
                                                <td><img class="img-fluid" width="70px" src="../assets/img/foto-kandang/<?= $k['foto_kandang'] ?>" alt="<?= 'Foto ' . $k['nama_kandang'] ?>"></td>
                                                <td><a class="btn btn-info" href="?tambahkekeranjang=<?= $k['id_kandang'] ?>">Tambah</a></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
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
    </body>

    </html>

<?php else : ?>

    <?php header("location:index.php") ?>

<?php endif ?>