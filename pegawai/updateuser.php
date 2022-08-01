<?php
session_start();
include '../conn.php';
if (isset($_GET)) {
  if (isset($_GET['id_pelanggan'])) {
    $id_pelanggan = $_GET['id_pelanggan'];
    $queryudpateuser = "SELECT * FROM pelanggan WHERE id_pelanggan = $id_pelanggan";
  } elseif (isset($_GET['id_admin'])) {
    $id_admin = $_GET['id_admin'];
    $queryudpateuser = "SELECT * FROM admin WHERE id_petugas = $id_admin";
  } else {
    $queryudpateuser = "SELECT * FROM admin WHERE id_petugas = '" . $_SESSION['id_petugas'] . "'";
  }
}
$exec = mysqli_query($conn, $queryudpateuser);
$jumlahdata = mysqli_num_rows($exec);
$getAllData = mysqli_fetch_array($exec);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../assets/img/logoweb.png" rel="icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Jasa Service</title>
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
  </style>
  <link href="../assets/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">
  <main class="form-signin">
    <div class="p-5 mb-4 bg-light rounded-3 shadow">
      <nav class="navbar navbar-expand-sm navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="../assets/img/logo.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
            Company
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="../pegawai/">Back</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <?php if (isset($_GET['pesan'])) : ?>
        <div class="alert alert-danger" role="alert">
          Gagal Update Account, Silahkan Cek Kembali
        </div>
      <?php endif ?>
      <div class="container-fluid py-5 rounded">
        <form autocomplete="off" action="proses.php" method="POST">
          <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="logo perusahaan" width="72" height="57">
          <h1 class="h3 mb-3 fw-normal">Update User Account</h1>
          <input type="hidden" name="id" value="<?php if (isset($id_pelanggan)) {
                                                  echo $getAllData['id_pelanggan'];
                                                } elseif (isset($id_admin)) {
                                                  echo $getAllData['id_petugas'];
                                                } else {
                                                  echo $getAllData['id_petugas'];
                                                } ?>">
          <input type="hidden" name="tabel" value="<?php if (isset($id_pelanggan)) {
                                                      echo 'pelanggan';
                                                    } elseif (isset($id_admin)) {
                                                      echo 'admin';
                                                    } else {
                                                      echo 'admin';
                                                    } ?>">
          <div class="form-floating mb-2">
            <input value="<?php if (isset($id_pelanggan)) {
                            echo $getAllData['nama_pelanggan'];
                          } elseif (isset($id_admin)) {
                            echo $getAllData['nama_petugas'];
                          } else {
                            echo $getAllData['nama_petugas'];
                          } ?>" required type="text" class="form-control" id="floatingInput" name="nama" placeholder="Nama User">
            <label for="floatingInput">Nama User</label>
          </div>
          <div class="form-floating mb-2">
            <input value="<?= $getAllData['username'] ?>" required type="text" class="form-control" id="floatingInput" name="username" placeholder="Username">
            <label for="floatingInput">Username</label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">+62</span>
            <input value="<?php if (isset($id_pelanggan)) {
                            echo $getAllData['nomer_pelanggan'];
                          } elseif (isset($id_admin)) {
                            echo $getAllData['nomer_petugas'];
                          } else {
                            echo $getAllData['nomer_petugas'];
                          } ?>" required type="number" class="form-control" id="floatingInput" name="nomer" placeholder="Nomer Telpon">
          </div>
          <div class="form-floating mb-2">
            <input value="<?php if (isset($id_pelanggan)) {
                            echo $getAllData['alamat_pelanggan'];
                          } elseif (isset($id_admin)) {
                            echo $getAllData['alamat_petugas'];
                          } else {
                            echo $getAllData['alamat_petugas'];
                          } ?>" required type="text" class="form-control" id="floatingInput" name="alamat" placeholder="Alamat">
            <label for="floatingInput">Alamat</label>
          </div>
          <input class="w-100 btn btn-lg btn-primary" type="submit" name="update" value="Update User">
        </form>
      </div>
    </div>
  </main>


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>

</html>