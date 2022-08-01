<?php
session_start();
$title = "Login Pelanggan";
// include file conn.php agar variable $conn bisa di pakai di setiap mysqli_query
include '../conn.php';
// cek apakah session dengan key nama_pelanggan sudah memiliki nilai atau belum
if (isset($_SESSION['nama_pelanggan'])) {
  // jika sudah memiliki nilai website akan menuju file dashboard.php
  header('Location:dashboard.php');
}
if (isset($_SESSION['role'])) {
  if ($_SESSION['role'] === 'admin') {
    header('Location:/service/pegawai/dashboardadmin.php');
  } else {
    header('Location:/service/pegawai/dashboardteknisi.php');
  }
}
?>
<!-- kebalikan dari cek session dengan key nama_pelanggan sudah memiliki nilai atau belum -->
<?php if (!isset($_SESSION['nama_pelanggan'])) : ?>
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
    <div class="container col-xl-12 col-xxl-8 px-4 py-5">
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
                  <a class="nav-link" href="daftar.php">Daftar</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../pegawai/">Login Pegawai</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <?php if (isset($_GET['pesan'])) : ?>
          <div class="alert alert-danger" role="alert">
            Login Gagal, Silahkan Cek Username Atau Passoword Anda
          </div>
        <?php endif ?>
        <div class="col-md-10 mx-auto col-lg-5">
          <form autocomplete="off" action="proses.php" method="POST">
            <h1 class="h3 mb-3 fw-normal"><?= $title ?></h1>
            <div class="form-floating mb-2">
              <input required type="text" class="form-control" value="<?= (isset($_SESSION['username'])) ? $_SESSION['username'] : ''; ?>" id="floatingInput" name="username" placeholder="Username">
              <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-2">
              <input required type="password" class="form-control" value="<?= (isset($_SESSION['password'])) ? $_SESSION['password'] : ''; ?>" id="floatingPassword" name="password" placeholder="Password">
              <label for="floatingPassword">Password</label>
            </div>
            <input class="w-100 btn btn-lg btn-primary" type="submit" name="login" value="Sign In">
            <p class="mt-1 mb-5 text-end mx-3"><a class="text-decoration-none" href="daftar.php"> <span class="text-dark">Dont Have Account?</span> Register</a></p>
          </form>
        </div>
        <div class="col-10 col-sm-8 col-lg-6">
          <img src="../assets/img/connected.svg" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="500" height="300" loading="lazy">
        </div>
      </div>
    </div>
    <script src="/service/assets/js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  </body>

  </html>
<?php endif ?>