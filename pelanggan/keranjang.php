<?php
session_start();
if (isset($_SESSION['datakeranjang'])) {
  $title = "Keranjang Pesanan";
  // include file conn.php agar variable $conn bisa di pakai di setiap mysqli_query
  include '../conn.php';
  $id_pelanggan = $_SESSION['id_pelanggan'];
  $queryselectkodetransaksi = "SELECT * FROM detail_pesanan WHERE id_pelanggan = $id_pelanggan AND checkout = 0";
  $querytotalbayar = "SELECT sum(harga_kandang * jumlah_barang) as total_bayar FROM detail_pesanan JOIN kandang ON kandang.id_kandang = detail_pesanan.id_kandang WHERE id_pelanggan = $id_pelanggan AND checkout = 0";
  // var_dump($querytotalbayar);
  $execselectkodetransaksi = mysqli_query($conn, $queryselectkodetransaksi);
  $exectotalbayar = mysqli_query($conn, $querytotalbayar);
  $datatotalbayar = mysqli_fetch_array($exectotalbayar, MYSQLI_ASSOC);
  $datakodetransaksi = mysqli_fetch_array($execselectkodetransaksi, MYSQLI_ASSOC);
  $kodetransaksi = $datakodetransaksi['kode_transaksi'];
  $querydatapelanggan = "SELECT * FROM detail_pesanan JOIN kandang ON kandang.id_kandang = detail_pesanan.id_kandang JOIN pelanggan ON pelanggan.id_pelanggan = detail_pesanan.id_pelanggan WHERE detail_pesanan.kode_transaksi = $kodetransaksi AND detail_pesanan.checkout = 0";
  $execdatapelanggan = mysqli_query($conn, $querydatapelanggan);
  $datakeranjang = mysqli_fetch_all($execdatapelanggan, MYSQLI_ASSOC);
  $jumlahkeranjang = mysqli_num_rows($execdatapelanggan);
  // cek apakah session dengan key nama_pelanggan sudah memiliki nilai atau belum
  if ($jumlahkeranjang < 0) {
    header("dashboard.php");
  }
  if (!isset($_SESSION['nama_pelanggan'])) {
    header('Location:index.php');
  }
  if (isset($_GET['hapus'])) {
    $id_kandang = $_GET['hapus'];
    $querydelete = "DELETE FROM detail_pesanan WHERE id_pelanggan = $id_pelanggan AND id_kandang = $id_kandang AND checkout = 0";
    $execquerydelete = mysqli_query($conn, $querydelete);
    if ($execquerydelete) {
      header("location:keranjang.php");
    }
  }
  if (isset($_GET['kurang'])) {
    $id_kandang = $_GET['kurang'];
    $queryupdate = "UPDATE detail_pesanan SET jumlah_barang = (jumlah_barang -1) WHERE id_pelanggan = $id_pelanggan AND id_kandang = $id_kandang AND checkout = 0";
    $execqueryupdate = mysqli_query($conn, $queryupdate);
    if ($execqueryupdate) {
      header("location:keranjang.php");
    }
  }
}

?>
<?php if (isset($_SESSION['datakeranjang'])) { ?>
  <?php if (!isset($kodetransaksi) && $jumlahkeranjang <= 0) { ?>
    <?= header("Location:dashboard.php"); ?>
  <?php } else { ?>
    <!doctype html>
    <html lang="en">

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="../assets/img/logoweb.png" rel="icon">
      <title><?= $title  ?></title>
      <link href="../assets/css/bootstrap.css" rel="stylesheet">

      <style>
        .bd-placeholder-img {
          font-size: 1.125rem;
          text-anchor: middle;
          -webkit-user-select: none;
          -moz-user-select: none;
          user-select: none;
        }

        @media (min-width: 768px) {
          .bd-placeholder-img-lg {
            font-size: 3.5rem;
          }
        }

        .b-example-divider {
          height: 3rem;
          background-color: rgba(0, 0, 0, .1);
          border: solid rgba(0, 0, 0, .15);
          border-width: 1px 0;
          box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
          flex-shrink: 0;
          width: 1.5rem;
          height: 100vh;
        }

        .bi {
          vertical-align: -.125em;
          fill: currentColor;
        }

        .nav-scroller {
          position: relative;
          z-index: 2;
          height: 2.75rem;
          overflow-y: hidden;
        }

        .nav-scroller .nav {
          display: flex;
          flex-wrap: nowrap;
          padding-bottom: 1rem;
          margin-top: -1px;
          overflow-x: auto;
          text-align: center;
          white-space: nowrap;
          -webkit-overflow-scrolling: touch;
        }
      </style>


      <!-- Custom styles for this template -->
      <link href="form-validation.css" rel="stylesheet">
    </head>

    <body class="bg-light">

      <div class="container">
        <main>
          <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
            <h2>Checkout form</h2>
          </div>

          <div class="row g-5">
            <div class="col-md-5 col-lg-4 order-md-last">
              <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Keranjang Anda</span>
                <span class="badge bg-primary rounded-pill"><?= $jumlahkeranjang ?></span>
              </h4>
              <ul class="list-group mb-3">
                <?php foreach ($datakeranjang as $k) : ?>
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0"><?= "Kandang " . $k['nama_kandang'] . ", Jumlah " . $k['jumlah_barang'] ?></h6>
                      <small class="text-muted"><?= "Ukuran Kandang " . $k['ukuran_kandang'] . " Bahan Kandang " . $k['bahan_kandang'] ?></small>
                    </div>
                    <div class="d-flex p-2"><a class="btn btn-warning align-middle m-1" href="?kurang=<?= $k['id_kandang'] ?>">Kurang</a><a class="btn btn-danger align-middle m-1" href="?hapus=<?= $k['id_kandang'] ?>">Hapus</a></div>
                  </li>
                <?php endforeach ?>
                <li class="list-group-item d-flex justify-content-between">
                  <span>Total</span>
                  <strong>Rp <?= number_format($datatotalbayar['total_bayar'], 2, ',', '.') ?></strong>
                </li>
              </ul>
            </div>
            <div class="col-md-7 col-lg-8">
              <form class="needs-validation" action="proses.php" method="POST">
                <div class="row g-3">
                  <input type="hidden" name="id_keranjang" value="<?= $datakeranjang[0]['id_keranjang'] ?>">
                  <div class="col-12">
                    <label for="kodetransaksi" class="form-label">Kode Transaksi</label>
                    <input type="text" class="form-control" id="kodetransaksi" name="kodetransaksi" value="<?= $datakeranjang[0]['kode_transaksi'] ?>" required readonly>
                  </div>
                  <div class="col-12">
                    <label for="firstName" class="form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="firstName" value="<?= $datakeranjang[0]['nama_pelanggan'] ?>" required readonly disabled>
                  </div>

                  <div class="col-12">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text">@</span>
                      <input type="text" class="form-control" id="username" value="<?= $datakeranjang[0]['username'] ?>" required readonly disabled>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="address" class="form-label">Nomer Pelanggan</label>
                    <input type="text" class="form-control" id="address" value="<?= "0" . $datakeranjang[0]['nomer_pelanggan'] ?>" required readonly disabled>
                  </div>

                  <div class="col-12">
                    <label for="address2" class="form-label">Alamat Pelanggan</label>
                    <input type="text" class="form-control" id="address2" value="<?= $datakeranjang[0]['alamat_pelanggan'] ?>" readonly disabled>
                  </div>
                </div>
                <hr class="my-4">
                <input type="submit" name="checkout" value="Checkout" class="w-100 btn btn-primary btn-lg">
              </form>
            </div>
          </div>
        </main>
      </div>
    </body>

    </html>
  <?php } ?>
<?php } else {
  header('Location:dashboard.php');
} ?>