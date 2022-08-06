  <?php
  session_start();
  include '../conn.php';
  if (isset($_POST['foto'])) {
    $kodetransaksi = $_POST['kodetransaksi'];
    $rand = rand();
    $ekstensi =  array('png', 'jpg', 'jpeg', 'gif');
    $filename = $_FILES['foto-pembayaran']['name'];
    $ukuran = $_FILES['foto-pembayaran']['size'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array($ext, $ekstensi)) {
      header("location:pesanansiap?pesan=gagal_ekstensi");
    } else {
      if ($ukuran < 10044070) {
        $xx = $rand . '_' . $filename;
        move_uploaded_file($_FILES['foto-pembayaran']['tmp_name'], "../assets/img/foto-pembayaran/" . $xx);
        // move_uploaded_file($_FILES['foto-pembayaran']['tmp_name'], "" . $xx);
        if (mysqli_query($conn, "UPDATE pesanan SET foto_pembayaran = '$xx' WHERE kode_transaksi = '$kodetransaksi'")) {
          header("location:pesanansiap.php?pesan=berhasil");
        } else {
          header("location:pesanansiap.php?pesan=gagal");
        }
      } else {
        header("location:pesanansiap.php?pesan=gagal_ukuran");
      }
    }
  }
  if (isset($_POST['checkout'])) {
    $id_keranjang = $_POST['id_keranjang'];
    $tanggal = date("Y-m-d");
    $kode = $_POST['kodetransaksi'];
    $id_pelanggan = $_SESSION['id_pelanggan'];
    $querypesan = "INSERT INTO pesanan (kode_transaksi,id_pelanggan,tanggal_pesan,status_pesanan) VALUES('$kode',$id_pelanggan ,'$tanggal', 'proses')";
    $execpesan = mysqli_query($conn, $querypesan);
    if ($execpesan) {
      mysqli_query($conn, "UPDATE detail_pesanan SET checkout = 1 WHERE kode_transaksi = $kode");
      header("location:dashboard.php?pesan=berhasil");
    } else {
      header("location:keranjang.php");
    }
  }
  if (isset($_POST['register'])) {
    $name = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nomer = $_POST['nomer'];
    $alamat = $_POST['alamat'];
    $query = "INSERT INTO pelanggan VALUES (null, '$name',$nomer,'$username', '$password', '$alamat','pelanggan')";
    $exec = mysqli_query($conn, $query);
    if ($exec) {
      header("Location:index.php");
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

    $query = "SELECT * FROM pelanggan WHERE username = '$username' AND password = '$password' AND account = 'pelanggan'";
    $exec = mysqli_query($conn, $query);

    $data = mysqli_fetch_array($exec, MYSQLI_ASSOC);
    $jumlahdata = mysqli_num_rows($exec);
    if ($jumlahdata == 1) {
      $_SESSION['nama_pelanggan'] = $data["nama_pelanggan"];
      $_SESSION['id_pelanggan'] = $data["id_pelanggan"];
      header("Location:dashboard.php");
    } else {
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['password'] = $_POST['password'];
      header("Location:index.php?pesan=gagal");
    }
  }
  if (isset($_POST['update'])) {
    $id = $_SESSION['id_pelanggan'];
    $name = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nomer = $_POST['nomer'];
    $alamat = $_POST['alamat'];
    $query = "UPDATE pelanggan SET nama_pelanggan = '$name', nomer_pelanggan = $nomer, username = '$username', password = '$password', alamat_pelanggan = '$alamat' WHERE id_pelanggan = $id";
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
