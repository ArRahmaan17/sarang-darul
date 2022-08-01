<?php
include 'conn.php';
// var_dump($_GET);
if (isset($_GET['id']) && isset($_GET['kode'])) {
  $kodetransaksi = $_GET['kode'];
  $idpelanggan = $_GET['id'];
  $queryselectdetailpesanan = "SELECT * FROM detail_pesanan LEFT JOIN kandang ON kandang.id_kandang = detail_pesanan.id_kandang WHERE detail_pesanan.checkout = 1 AND detail_pesanan.kode_transaksi = '$kodetransaksi'";
  $execselectdetailpesanan = mysqli_query($conn, $queryselectdetailpesanan);
  $datadetailpesanan = mysqli_fetch_all($execselectdetailpesanan, MYSQLI_ASSOC);
  $queryselectpesanan = "SELECT * FROM pesanan  LEFT JOIN pelanggan ON pelanggan.id_pelanggan = pesanan.id_pelanggan WHERE pesanan.kode_transaksi = '$kodetransaksi' AND pesanan.id_pelanggan = $idpelanggan";
  $execselectpesanan = mysqli_query($conn, $queryselectpesanan);
  $datapesanan = mysqli_fetch_array($execselectpesanan, MYSQLI_ASSOC);
  $html = '';
  $peritem = '';
  $total = [];
  foreach ($datadetailpesanan as $data) {
    $total[] = $jumlah = $data['jumlah_barang'] * $data['harga_kandang'];
    $html .= '<li>Kandang ' . $data['nama_kandang'] . ' Jumlah ' . $data['jumlah_barang'] . ' Harga Rp.' . $data['harga_kandang'] . '</li>';
    $peritem .= '<li>Jumlah Bayar Rp.' . $jumlah . '</li>';
  }
  $totalbayar = 0;
  for ($i = 0; $i < count($total); $i++) {
    $totalbayar += $total[$i];
  }
}
// die();
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [80, 65]]);
// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Folio']);


// $mpdf = new \Mpdf\Mpdf('utf-8', 'A4',  0, '', 0, 0, 0, 0, 0, 'L');
$mpdf->WriteHTML('
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    *{
      margin:0 !important;
      padding:0 !important;
      box-sizing:border-box;
    }
    body{

      font-size:4pt;
        margin:0;
        padding:-200px;
    }
    p{
        margin:0;
        padding:0;
    }
    table
    {
      padding:-200px;
        width:100%;
        border-spacing:0;
        border-collapse: collapse; 
        margin:0 !important;
    }
    </style>
</head>
<body>
  <div style="margin:0;padding:-50px;box-sizing:border-box">
      <table>
      <tr>
          <td><img src="./assets/img/logoweb.png" width="40px" alt="" srcset=""></td>
          <td>
              <h6>Teguh Sangkar</h6>
              <p>dodogan gede RT 04/RW 01 kelurahan Salakan kecamatan Teras kabupaten Boyolali</p>
          </td>
      </tr>
    </table>
      <hr>
    <table>
      <tr>
        <td>Kode Transaksi</td>
        <td>:</td>
        <td>' . $datapesanan['kode_transaksi'] . '</td>
      </tr>
      <tr>
        <td>Nama Pelanggan</td>
        <td>:</td>
        <td>' . $datapesanan['nama_pelanggan'] . '</td>
      </tr>
      <tr>
        <td>Tanggal Pesan</td>
        <td>:</td>
        <td>' . $datapesanan['tanggal_pesan'] . '</td>
      </tr>
      <tr>
        <td>List Pesanan</td>
        <td>:</td>
        <td>' . $html . '</td>
      </tr>
      <tr>
        <td>Jumlah Per@</td>
        <td>:</td>
        <td>' . $peritem . '</td>
      </tr>
      <tr>
        <td>Total Seluruhnya</td>
        <td>:</td>
        <td>' . "Rp." . $totalbayar . '</td>
      </tr>
    </table>
  </div>

</body>
</html>
');
$mpdf->Output();
