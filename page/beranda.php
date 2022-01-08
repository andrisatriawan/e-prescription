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
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $koneksi->query('SELECT * FROM resep INNER JOIN signa_m ON resep.id_signa=signa_m.signa_id ORDER BY created_date DESC');
                $no = 1;
                while ($row = $query->fetch_array()) {
                    if ($row['jenis_racikan'] != '0') {
                        $jenis_resep = 'Racikan';
                ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $jenis_resep ?></td>
                            <td><?= $row['nama_racikan'] ?></td>
                            <td><?= $row['signa_nama'] ?></td>
                        </tr>
                    <?php
                    } else {
                        $jenis_resep = 'Non-Racikan';
                        $id_resep = $row['id_resep'];
                        $q_keranjang = $koneksi->query("SELECT * FROM keranjang_obat INNER JOIN obatalkes_m ON keranjang_obat.id_obat=obatalkes_m.obatalkes_id WHERE keranjang_obat.id_resep='$id_resep' AND keranjang_obat.jenis_resep='0'");
                        $row_keranjang = $q_keranjang->fetch_assoc();
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $jenis_resep ?></td>
                            <td><?= $row_keranjang['obatalkes_nama'] ?></td>
                            <td><?= $row['signa_nama'] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>