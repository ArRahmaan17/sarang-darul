<?php
session_start();
if ($_SESSION['nama_pelanggan'] !== null) {
  include '../conn.php';
  $id_pelanggan = $_SESSION['id_pelanggan'];
  $querykeranjang = "SELECT * FROM detail_pesanan JOIN pelanggan ON detail_pesanan.id_pelanggan = pelanggan.id_pelanggan WHERE pelanggan.id_pelanggan = $id_pelanggan AND checkout = 0";
  $execkeranjang = mysqli_query($conn, $querykeranjang);
  if ($execkeranjang) {
    $jumlahkeranjang = mysqli_num_rows($execkeranjang);
    $_SESSION['datakeranjang'] = $jumlahkeranjang;
  }
  $title = "Pesanan Sedang Proses";
  $id = $_SESSION['id_pelanggan'];
  if (isset($_GET['detailpesanan'])) {
    if ($_GET['detailpesanan'] == "") {
      header("location:pesanandiproses.php");
    }
    $kodetransaksi = $_GET['detailpesanan'];
    $querydetail = "SELECT * FROM pesanan JOIN detail_pesanan ON pesanan.kode_transaksi = detail_pesanan.kode_transaksi JOIN pelanggan ON detail_pesanan.id_pelanggan = pelanggan.id_pelanggan JOIN kandang ON detail_pesanan.id_kandang = kandang.id_kandang WHERE pesanan.kode_transaksi = '$kodetransaksi'";
    // var_dump($querydetail);
    $execdetail = mysqli_query($conn, $querydetail);
    $datadetail = mysqli_fetch_all($execdetail, MYSQLI_ASSOC);
  }

  $querypesanan = "SELECT * FROM pesanan JOIN pelanggan ON pesanan.id_pelanggan = pelanggan.id_pelanggan WHERE pesanan.status_pesanan = 'proses' OR pesanan.status_pesanan = 'jeruji' OR pesanan.status_pesanan = 'rangka' OR pesanan.status_pesanan = 'perangkaian' OR pesanan.status_pesanan = 'finishing' AND pesanan.id_pelanggan = $id";
  $exec = mysqli_query($conn, $querypesanan);
  if ($exec) {
    $jumlahdata = mysqli_num_rows($exec);
    $data = mysqli_fetch_all($exec, MYSQLI_ASSOC);
    if ($jumlahdata > 0) {
      $pesan = "<td colspan='6' class='text-center'>Belum Ada Pesanan Nih</td>";
    } else {
      $pesan = "<td colspan='6' class='text-center'>Tidak Ada Data</td>";
    }
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
          <?php if (!isset($_GET['detailpesanan'])) { ?>
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <caption>List dari Kandang dipesan</caption>
                <thead class="table-dark">
                  <tr>
                    <td class="text-center">Nomer</td>
                    <td class="text-center">Kode Transaksi</td>
                    <td class="text-center">Tanggal Pesan</td>
                    <td class="text-center">Status Pesanan</td>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($jumlahdata > 0) { ?>
                    <?php $no = 0 ?>
                    <?php foreach ($data as $p) : ?>
                      <?php $no++ ?>
                      <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td class="text-center"><a class="text-decoration-none text-dark" href="?detailpesanan=<?= $p['kode_transaksi'] ?>"><?= $p['kode_transaksi'] ?></a></td>
                        <td class="text-center"><?= $p['tanggal_pesan'] ?></td>
                        <td class="text-center">
                          <h5>
                            <span class="badge badge-lg rounded-pill bg-secondary text-light">
                              <?= strtoupper(($p['status_pesanan'] == 'jeruji') ? 'Pembuatan Jeruji' : ($p['status_pesanan'] == 'rangka') ? 'Pembuatan Rangka' : $p['status_pesanan']) ?></span>
                          </h5>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  <?php } else { ?>
                    <tr>
                      <?= $pesan ?>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          <?php } ?>
          <?php if (isset($_GET['detailpesanan'])) : ?>
            <div class="container">
              <a class="text-decoration-none text-end mt-5 d-block" href="pesanandiproses.php">Kembali</a>
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
                <div class="col-12 my-4">
                  <a class="form-control btn-success text-center text-decoration-none" target="blank" href="https://wa.me/62<?= $nomeradmin ?>">Hubungi Petugas</a>
                </div>
              </div>
            </div>
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