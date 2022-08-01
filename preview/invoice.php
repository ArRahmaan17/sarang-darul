<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-size: 4pt;
            width: 80mm;
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            /** border-left: 1px solid #fff;
        border-top: 1px solid #fff; **/
            border-spacing: 0;
            border-collapse: collapse;
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>

<body>
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
</body>

</html>