<?php
session_start();
// include file conn.php agar variable $conn bisa di pakai di setiap mysqli_query
include '../conn.php' ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../assets/img/logoweb.png" rel="icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Daftar Pelanggan</title>
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
  <div class="container-fluid col-xl-12 col-xxl-8">
    <div class="row align-items-center g-lg-5 py-5 rounded px-4 py-5 shadow-sm">
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
                <a class="nav-link active" aria-current="page" href="../pelanggan/">Back</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <?php if (isset($_GET['pesan'])) : ?>
        <div class="alert alert-danger" role="alert">
          Gagal Mendaftar, Silahkan Cek Kembali
        </div>
      <?php endif ?>
      <div class="col-md-10 mx-auto col-lg-5">
        <form autocomplete="off" action="proses.php" method="POST">
          <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="logo perusahaan" width="72" height="57">
          <h1 class="h3 mb-3 fw-normal">Sign Up</h1>
          <div class="form-floating mb-2">
            <!-- pengecekan apabila session nama memiliki nilai maka value dari input nama akan berisi session nama -->
            <input value="<?= (isset($_SESSION['nama'])) ? $_SESSION['nama'] : ''; ?>" required type="text" class="form-control" id="floatingInput" name="nama" placeholder="Nama Pelanggan">
            <label for="floatingInput">Nama Pelanggan</label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">+62</span>
            <input type="text" class="form-control" placeholder="Nomer Pelanggan" required type="number" value="<?= (isset($_SESSION['nomer'])) ? $_SESSION['nomer'] : ''; ?>" name="nomer">
          </div>
          <div class="form-floating mb-2">
            <!-- pengecekan apabila session name memiliki nilai maka value dari input username akan berisi session username -->
            <input value="<?= (isset($_SESSION['username'])) ? $_SESSION['username'] : ''; ?>" required type="text" class="form-control" id="floatingInput" name="username" placeholder="Username">
            <label for="floatingInput">Username</label>
          </div>
          <div class="form-floating mb-2">
            <!-- pengecekan apabila session password memiliki nilai maka value dari input password akan berisi session password -->
            <input value="<?= (isset($_SESSION['password'])) ? $_SESSION['password'] : ''; ?>" required type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
            <label for="floatingPassword">Password</label>
          </div>
          <div class="form-floating mb-2">
            <!-- pengecekan apabila session alamat memiliki nilai maka value dari input alamat akan berisi session alamat -->
            <input value="<?= (isset($_SESSION['alamat'])) ? $_SESSION['alamat'] : ''; ?>" required type="text" class="form-control" id="floatingInput" name="alamat" placeholder="Alamat">
            <label for="floatingInput">Alamat</label>
          </div>
          <input class="w-100 btn btn-lg btn-primary" type="submit" name="register" value="Sign UP">
        </form>
      </div>
      <div class="col-10 col-sm-8 col-lg-6">
        <img src="../assets/img/sign_up.svg" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>

</html>