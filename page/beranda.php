<div class="card">
    <div class="card-body">
        <a href="?page=tambah" class="btn btn-primary mb-3">Buat Resep</a>
        <table id="tb-resep" class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Racikan</th>
                    <th>Nama Racikan</th>
                    <th>Obat</th>
                    <th>Signa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $koneksi->query('SELECT * FROM resep ORDER BY created_date DESC');
                $no = 1;
                while ($row = $query->fetch_array()) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['jenis_resep'] ?></td>
                        <td><?= $row['nama_racikan'] ?></td>
                        <td></td>
                        <td><?= $row['id_signa'] ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>