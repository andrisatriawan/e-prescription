<div class="card">
    <div class="card-body">
        <a href="?page=tambah" class="btn btn-primary mb-3">Buat Resep</a>
        <table id="tb-resep" class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Racikan</th>
                    <th>Nama Racikan</th>
                    <th>Signa</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $koneksi->query('SELECT * FROM resep INNER JOIN signa_m ON resep.id_signa=signa_m.signa_id ORDER BY resep.created_date DESC');
                $no = 1;
                while ($row = $query->fetch_array()) {
                    $id_resep = $row['id_resep'];
                    if ($row['jenis_resep'] != '0') {
                        $jenis_resep = 'Racikan';
                ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $jenis_resep ?></td>
                            <td><?= $row['nama_racikan'] ?></td>
                            <td><?= $row['signa_nama'] ?></td>
                            <td>
                                <button type='button' class='btn btn-sm btn-info' data-toggle='modal' data-signa="<?= $row['signa_nama'] ?>" data-resep="<?= $jenis_resep ?>" data-id='<?= $row['id_resep'] ?>' data-target='#modal-detail'>
                                    <i class='fas fa-info'></i>
                                </button>
                            </td>
                        </tr>
                    <?php
                    } else {
                        $jenis_resep = 'Non-Racikan';

                        $q_keranjang = $koneksi->query("SELECT * FROM keranjang_obat INNER JOIN obatalkes_m ON keranjang_obat.id_obat=obatalkes_m.obatalkes_id WHERE keranjang_obat.id_resep='$id_resep' AND keranjang_obat.jenis_resep='0'");
                        $row_keranjang = $q_keranjang->fetch_assoc();
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $jenis_resep ?></td>
                            <td><?= $row_keranjang['obatalkes_nama'] ?></td>
                            <td><?= $row['signa_nama'] ?></td>
                            <td>
                                <button type='button' class='btn btn-sm btn-info' data-toggle='modal' data-signa="<?= $row['signa_nama'] ?>" data-resep="<?= $jenis_resep ?>" data-id='<?= $row['id_resep'] ?>' data-target='#modal-detail'>
                                    <i class='fas fa-info'></i>
                                </button>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detail Resep</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class=" row">
                    <label for="jenis-resep" class="col-md-4 col-form-label">Jenis Resep</label>
                    <div class="col-md-8">
                        <p id="jenis-resep"></p>
                    </div>
                </div>
                <div class=" row">
                    <label for="signa" class="col-md-4 col-form-label">Signa</label>
                    <div class="col-md-8">
                        <p id="signa"></p>
                    </div>
                </div>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <a href="cetak.php?id=0" class="btn btn-primary" id="btn-print" target="blank"><i class="fas fa-print"></i> Print</a>
            </div>
        </div>
    </div>
</div>