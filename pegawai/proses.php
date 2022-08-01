<?php
session_start();
include '../conn.php';
if (isset($_POST['checkout'])) {
  var_dump($_POST);
  $id_pelanggan = $_POST['id-pelanggan'];
  $kodetransaksi = $_POST['kodetransaksi'];
  $date = date("Y-m-d");
  $querypesanan = "INSERT INTO pesanan (kode_transaksi,id_pelanggan,tanggal_pesan) VALUES ('$kodetransaksi',$id_pelanggan,$date)";
  $queryupdate = "UPDATE detail_pesanan SET checkout = 1 WHERE kode_transaksi = $kodetransaksi";

  if (mysqli_query($conn, $querypesanan) && mysqli_query($conn, $queryupdate)) {
    header("location:dashboard.php?pesan=berhasil");
  } else {
    header("location:dashboard.php?pesan=gagal");
  }
}
if (isset($_POST['tambah'])) {
  $nama = $_POST['nama-kandang'];
  $ukurankandang = $_POST['ukuran-kandang'];
  $harga = $_POST['harga-kandang'];
  $lamapengerjaan = $_POST['satuan-angka'] . " " . $_POST['satuan-waktu'];
  $rand = rand();
  $ekstensi =  array('png', 'jpg', 'jpeg', 'gif');
  $filename = $_FILES['foto-kandang']['name'];
  $ukuran = $_FILES['foto-kandang']['size'];
  $ext = pathinfo($filename, PATHINFO_EXTENSION);
  if (!in_array($ext, $ekstensi)) {
    header("location:tambahkandang?pesan=gagal_ekstensi");
  } else {
    if ($ukuran < 1044070) {
      $xx = $rand . '_' . $filename;
      move_uploaded_file($_FILES['foto-kandang']['tmp_name'], "../assets/img/foto-kandang/" . $xx);
      mysqli_query($conn, "INSERT INTO kandang VALUES(NULL,'$nama','$ukurankandang','kayu','$xx','$lamapengerjaan','$harga')");
      header("location:tambahkandang.php?pesan=berhasil");
    } else {
      header("location:tambahkandang.php?pesan=gagal_ukuran");
    }
  }
}
if (isset($_POST['register'])) {
  $name = $_POST['nama'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $nomer = $_POST['nomer'];
  $alamat = $_POST['alamat'];
  $query = "INSERT INTO admin VALUES (null, '$name',$nomer,'$username', '$password', '$alamat')";
  $exec = mysqli_query($conn, $query);
  if ($exec) {
    header("Location:dashboard.php?pesan=berhasil");
  } else {
    $_SESSION['nama'] = $_POST['nama'];
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['nomer'] = $_POST['nomer'];
    $_SESSION['alamat'] = $_POST['alamat'];
    header("Location:daftar.php?pesan=gagal");
  }
}
if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
  $exec = mysqli_query($conn, $query);

  $data = mysqli_fetch_array($exec, MYSQLI_ASSOC);
  $jumlahdata = mysqli_num_rows($exec);
  if ($jumlahdata == 1) {
    $_SESSION['nama_petugas'] = $data["nama_petugas"];
    $_SESSION['id_petugas'] = $data["id_petugas"];
    header("Location:dashboard.php");
  } else {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    header("Location:index.php?pesan=gagal");
  }
}
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $tabel = $_POST['tabel'];
  $name = $_POST['nama'];
  $username = $_POST['username'];
  $nomer = $_POST['nomer'];
  $alamat = $_POST['alamat'];
  $query = "UPDATE $tabel SET nama_$tabel = '$name', nomer_$tabel = $nomer, username = '$username', password = '$password', alamat_$tabel = '$alamat' WHERE id_$tabel = $id";
  echo $query;
  die();
  $exec = mysqli_query($conn, $query);
  if ($exec) {
    $_SESSION['nama_pelanggan'] = $name;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['nomer'] = $nomer;
    $_SESSION['alamat'] = $alamat;
    header("Location:dashboard.php");
  } else {
    $_SESSION['nama'] = $_POST['nama'];
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['nomer'] = $_POST['nomer'];
    $_SESSION['alamat'] = $_POST['alamat'];
    header("Location:updateuser.php?pesan=gagal");
  }
}
