<?php

require_once 'config/koneksi.php';

$id_resep = $_GET['id'];

$q_resep = $koneksi->query("SELECT * FROM resep INNER JOIN signa_m ON signa_m.signa_id=resep.id_signa WHERE id_resep='$id_resep'");
$row = $q_resep->fetch_assoc();

if ($row['jenis_resep'] == '0') {
    $jenis_resep = 'Non-Racikan';
} else {
    $jenis_resep = 'Racikan';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Data</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>

<body>
    <div class="container">
        <h4 class="text-center mt-5"> <b>Resep Obat</b></h4>
        <hr class="my-2" style="border: solid 2px black">
        <div class="row mt-3">
            <label for="jenis-resep" class="col-md-4 col-form-label">Jenis Resep</label>
            <div class="col-md-8">
                <p id="jenis-resep"><?= $jenis_resep ?></p>
            </div>
        </div>
        <div class="row">
            <label for="signa" class="col-md-4 col-form-label">Signa</label>
            <div class="col-md-8">
                <p id="signa"><?= $row['signa_nama'] ?></p>
            </div>
        </div>
        <div class="row">
            <table class="table table-hover mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Obat</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody id="list-obat">
                    <tr>
                        <td valign='top' colspan='3' class='text-center'>No data available in table</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        function listObat() {
            var id_resep = '<?= $id_resep ?>'
            $.ajax({
                type: "POST",
                url: 'config/data.php?action=list_obat',
                dataType: "JSON",
                data: {
                    id_resep: id_resep
                },
                success: function(data) {
                    if (data.message == 'success') {
                        $('#list-obat').html(data.list_obat)
                    }
                }
            })
        }
        listObat();

        function print_window() {
            return function() {
                window.print();
                window.onmouseover = function() {
                    setTimeout(function() {
                        close();
                    }, 300)
                }
            }
        }
        setTimeout(print_window(), 400);
    </script>
</body>