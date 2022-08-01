<?php
session_start();
if ($_SESSION['nama_petugas'] !== null) {
    include '../conn.php';
    $title = "Daftar Kandang";
    $querykandang = "SELECT * FROM kandang";
    $execkandang = mysqli_query($conn, $querykandang);
    $datakandang = mysqli_fetch_all($execkandang, MYSQLI_ASSOC);
    $pesan = "<td colspan='6' class='text-center'>Belum Ada Pesanan Selesai Nih</td>";
}
if (isset($_GET['update'])) {
    $id_kandang = $_GET['update'];
    $queryselecdatakandang = "SELECT * FROM kandang where id_kandang = $id_kandang";
    $execdatakandang = mysqli_query($conn, $queryselecdatakandang);
    $datakandangupdate = mysqli_fetch_array($execdatakandang, MYSQLI_ASSOC);
    $satuan[] = explode(" ", $datakandangupdate['lama_pengerjaan']);
    $fotolama = $datakandangupdate['foto_kandang'];
}
if (isset($_GET['delete'])) {
    $id_kandang = $_GET['delete'];
    if (mysqli_query($conn, "DELETE FROM kandang WHERE id_kandang = $id_kandang")) {
        header("location:?pesan=berhasil");
    } else {
        header("location:?pesan=gagal");
    }
}
if (isset($_POST['update'])) {
    $id_kadang = $_POST['id_kandang'];
    $nama_kandang = $_POST['nama-kandang'];
    $ukuran_kandang = $_POST['ukuran-kandang'];
    $harga_kandang = $_POST['harga-kandang'];
    $lamapengerjaan = $_POST['satuan-angka'] . " " . $_POST['satuan-waktu'];
    if ($fotolama == $_FILES['foto-kandang']['name']) {
        $foto_kandang = $fotolama;
    } elseif ($_FILES['foto-kandang']['name'] == '') {
        $foto_kandang = $fotolama;
    } else {
        $rand = rand();
        $ekstensi =  array('png', 'jpg', 'jpeg', 'gif');
        $filename = $_FILES['foto-kandang']['name'];
        $ukuran = $_FILES['foto-kandang']['size'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $ekstensi)) {
            header("location:daftarkandang.php?pesan=gagal_ekstensi");
        } else {
            if ($ukuran < 1044070) {
                $foto_kandang = $rand . '_' . $filename;
                move_uploaded_file($_FILES['foto-kandang']['tmp_name'], "../assets/img/foto-kandang/" . $foto_kandang);
            } else {
                header("location:daftarkandang.php?pesan=gagal_ukuran");
            }
        }
    }
    if (mysqli_query($conn, "UPDATE kandang SET nama_kandang = '$nama_kandang', ukuran_kandang= '$ukuran_kandang',foto_kandang = '$foto_kandang', lama_pengerjaan = '$lamapengerjaan', harga_kandang = '$harga_kandang' WHERE id_kandang = '$id_kandang'")) {
        header("location:daftarkandang.php?pesan=berhasil");
    } else {
        header("location:daftarkandang.php?pesan=gagal");
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
                        <?php endif ?>
                    <?php endif ?>
                    <div class="container col-xxl-12 mb-3">
                        <div class="row flex-lg align-items-center g-1 py-3">
                            <?php if (!isset($_GET['update'])) { ?>
                                <div class="col-12">
                                    <div class="table-responsive mt-4">
                                        <table class="table caption-top">
                                            <caption class="btn-warning text-center rounded disabled fw-bold">List Kandang</caption>
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Nama Kandang</th>
                                                    <th scope="col">Bahan Kandang</th>
                                                    <th scope="col">Lama Pengerjaan</th>
                                                    <th scope="col">Foto Kandang</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="align-middle">
                                                <?php $no = 0 ?>
                                                <?php if (count($datakandang) > 0) : ?>
                                                    <?php foreach ($datakandang as $kandang) { ?>
                                                        <?php $no++ ?>
                                                        <tr>
                                                            <th scope="row"><?= $no ?></th>
                                                            <td><?= $kandang['nama_kandang'] ?></td>
                                                            <td><?= $kandang['bahan_kandang'] ?></td>
                                                            <td><?= $kandang['lama_pengerjaan'] ?></td>
                                                            <td><img width="70px" src="../assets/img/foto-kandang/<?= $kandang['foto_kandang'] ?>" alt="" srcset=""></td>
                                                            <td>
                                                                <a class="btn btn-warning" href="?update=<?= $kandang['id_kandang'] ?>">UPDATE</a>
                                                                <a class="btn btn-danger" href="?delete=<?= $kandang['id_kandang'] ?>">DELETE</a>
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
                            <?php } ?>
                            <?php if (isset($_GET['update'])) { ?>
                                <a class="text-decoration-none text-end mt-5 d-block" href="daftarkandang.php">Kembali</a>
                                <form autocomplete="off" action="" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id_kandang" value="<?= $datakandangupdate['id_kandang'] ?>">
                                    <div class="my-3">
                                        <label for="nama-kandang" class="form-label">Nama Kandang</label>
                                        <input required type="text" class="form-control" name="nama-kandang" id="nama-kandang" value="<?= $datakandangupdate['nama_kandang'] ?>">
                                    </div>
                                    <div class="row">
                                        <label class="mb-1" for="ukuran-kandang">Ukuran Kandang</label>
                                        <div class="col-8 mt-1">
                                            <select class="form-select" name="ukuran-kandang" id="ukuran-kandang" aria-label="Default select example">
                                                <option <?php ($datakandangupdate['ukuran_kandang'] == 'Sedang') ? 'selected' : ''; ?> value="sedang">Sedang</option>
                                                <option <?php ($datakandangupdate['ukuran_kandang'] == 'Besar') ? 'selected' : ''; ?> value="besar">Besar</option>
                                            </select>
                                        </div>
                                        <div class="col-4 mt-1">
                                            <input required type="number" name="harga-kandang" value="<?= $datakandangupdate['harga_kandang'] ?>" min="1" class="form-control" placeholder="Angka">
                                            <div id="emailHelp" class="form-text">Harga kandang</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="mb-1" for="satuan-angka">Lama Pengerjaan Kandang</label>
                                        <div class="col-4 mt-1">
                                            <input required type="number" name="satuan-angka" id="satuan-angka" value="<?= $satuan[0][0] ?>" min="1" class="form-control" placeholder="Angka">
                                            <div id="emailHelp" class="form-text">Angka Hari / Minggu</div>
                                        </div>
                                        <div class="col-8 mt-1">
                                            <select class="form-select" name="satuan-waktu" id="satuan-waktu" aria-label="Default select example">
                                                <option <?= ($satuan[0][1] == "Minggu") ? 'selected' : '' ?> value="minggu">Minggu</option>
                                                <option <?= ($satuan[0][1] == "Bulan") ? 'selected' : '' ?> value="bulan">Bulan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Foto Kandang</label>
                                            <input class="form-control" name="foto-kandang" type="file" id="formFile">
                                            <input type="hidden" value="<?= $fotolama ?>">
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-warning mt-4 form-control" name="update" value="Update Data">
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <!-- Core theme JS-->
        <script src="../assets/js/sidebars.js"></script>
    </body>

    </html>
<?php else : ?>

    <?php header("location:index.php") ?>

<?php endif ?>