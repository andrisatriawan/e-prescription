<?php
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');
if ($_GET['action'] == 'cari_obat') {
    $query = $koneksi->query("SELECT * FROM obatalkes_m");
    $result = '<option value=""  selected disabled >Choose...</option>';
    while ($row = $query->fetch_array()) {
        $result .= "<option value='$row[obatalkes_id]'>$row[obatalkes_nama]</option>";
    }

    echo $result;
} elseif ($_GET['action'] == 'get_stok') {
    $id_obat = $_POST['id_obat'];
    $query = $koneksi->query("SELECT * FROM obatalkes_m WHERE obatalkes_id='$id_obat'");
    $row = $query->fetch_assoc();
    $result['stok'] = $row['stok'];

    echo json_encode($result);
} elseif ($_GET['action'] == 'tambah_keranjang') {
    $id_obat = $_POST['id_obat'];
    $jumlah = $_POST['jumlah'];
    $jenis_resep = $_POST['jenis_resep'];
    $last_update = date("Y-m-d H:i:s");

    $sql = "INSERT INTO `keranjang_obat`(`id_obat`, `jumlah`, `id_resep`, `jenis_resep`, `created_date`, `created_by`) VALUES ('$id_obat','$jumlah','0','$jenis_resep', '$last_update', '1')";
    $simpan = $koneksi->query($sql);

    if ($simpan) {
        $q_obatalkes = $koneksi->query("SELECT * FROM obatalkes_m WHERE obatalkes_id = '$id_obat'");
        if ($q_obatalkes->num_rows != 0) {
            $row = $q_obatalkes->fetch_assoc();
            $stok = intval($row['stok']);
            $newStok = $stok - intval($jumlah);

            $sql_update = "UPDATE `obatalkes_m` SET `stok`='$newStok', `last_modified_date`='$last_update',`last_modified_by`='1' WHERE obatalkes_id='$id_obat'";
            $q_update = $koneksi->query($sql_update);
            if ($q_update) {
                $result['message'] = 'success';
                $result['status'] = '200';
            } else {
                $result['status'] = '400';
                $result['message'] = 'failed : ' . $koneksi->errno;
            }
        }
    } else {
        $result['message'] = 'failed : ' . $koneksi->errno;
    }

    echo json_encode($result);
} else if ($_GET['action'] == 'get_keranjang') {
    $jenis_resep = $_POST['jenis_resep'];
    $query = $koneksi->query("SELECT * FROM keranjang_obat INNER JOIN obatalkes_m ON keranjang_obat.id_obat=obatalkes_m.obatalkes_id WHERE id_resep='0' AND jenis_resep='$jenis_resep'");
    $html = '';
    $i = 1;
    if ($query) {
        if ($query->num_rows != 0) {
            while ($row = $query->fetch_array()) {
                $no = $i++;
                $html .= "<tr>
                <td>$no</td>
                <td>$row[obatalkes_nama]</td>
                <td>$row[jumlah]</td>
                <td>
                <button type='button' class='btn btn-sm btn-danger' data-toggle='modal' data-jumlah='$row[jumlah]' data-id='$row[id_keranjang]' data-target='#modal-hapus'>
                <i class='fas fa-trash'></i>
                </button>
                </td>
            </tr>";
            }
            $result['count'] = $query->num_rows;
        } else {
            $html .= "<tr>
            <td valign='top' colspan='4' class='text-center'>No data available in table</td>
            </tr>";
            $result['count'] = 0;
        }

        $result['output'] = $html;
        $result['message'] = 'success';
    } else {
        $result['message'] = 'failed : ' . $koneksi->errno;
    }

    echo json_encode($result);
} elseif ($_GET['action'] == 'hapus_keranjang') {
    $id_keranjang = $_POST['id_keranjang'];
    $jumlah = $_POST['jumlah_keranjang'];
    $last_update = date("Y-m-d H:i:s");

    $q_keranjang = $koneksi->query("SELECT * FROM keranjang_obat WHERE id_keranjang='$id_keranjang'");

    if ($q_keranjang->num_rows != 0) {
        $row_keranjang = $q_keranjang->fetch_assoc();
        $id_obat = $row_keranjang['id_obat'];
        $q_obat = $koneksi->query("SELECT * FROM obatalkes_m WHERE obatalkes_id='$row_keranjang[id_obat]'");
        $row_obat = $q_obat->fetch_assoc();

        $old_stok = intval($row_obat['stok']);
        $new_stok = intval($jumlah) + $old_stok;

        $sql_update = "UPDATE `obatalkes_m` SET `stok`='$new_stok', `last_modified_date`='$last_update',`last_modified_by`='1' WHERE obatalkes_id='$id_obat'";
        $q_update = $koneksi->query($sql_update);
        if ($q_update) {
            $q_hapus = $koneksi->query("DELETE FROM keranjang_obat WHERE id_keranjang='$id_keranjang'");

            if ($q_hapus) {
                $return['message'] = 'success';
            } else {
                $return['message'] = 'failed : ' . $koneksi->errno;
            }
        }
    }

    echo json_encode($return);
} elseif ($_GET['action'] == 'get_signa') {
    $query = $koneksi->query("SELECT * FROM signa_m");
    $html = '<option selected disabled value="">Choose...</option>';
    while ($row = $query->fetch_array()) {
        $html .= "<option value=' $row[signa_id] '> $row[signa_nama] </option>";
    }

    echo $html;
} elseif ($_GET['action'] == 'simpan_resep') {
    $nama_racikan = $_POST['nama_racikan'];
    $jenis_resep = $_POST['jenis_resep'];
    $signa = $_POST['signa'];
    $last_update = date("Y-m-d H:i:s");

    $sql_simpan = "INSERT INTO `resep`(`jenis_resep`, `nama_racikan`, `id_signa`, `created_date`, `created_by`) VALUES ('$jenis_resep','$nama_racikan','$signa','$last_update', '1')";
    $q_simpan = $koneksi->query($sql_simpan);

    if ($q_simpan) {
        $q_resep = $koneksi->query("SELECT * FROM resep ORDER BY id_resep DESC");
        $row = $q_resep->fetch_assoc();

        $id_resep = $row['id_resep'];

        $q_update = $koneksi->query("UPDATE keranjang_obat SET id_resep='$id_resep' WHERE id_resep='0' AND created_by='1'");

        if ($q_update) {
            $result['message'] = 'success';
            $result['id_resep'] = $id_resep;
        } else {
            $result['message'] = 'failed : ' . $koneksi->errno;
        }
    } else {
        $result['message'] = 'failed : ' . $koneksi->errno;
    }

    echo json_encode($result);
} elseif ($_GET['action'] == 'list_obat') {
    $id_resep = $_POST['id_resep'];
    $q_list = $koneksi->query("SELECT * FROM keranjang_obat INNER JOIN obatalkes_m ON keranjang_obat.id_obat=obatalkes_m.obatalkes_id WHERE id_resep='$id_resep'");
    $html = '';
    $i = 1;
    if ($q_list->num_rows != 0) {
        while ($row = $q_list->fetch_array()) {
            $no = $i++;
            $html .= "<tr>
            <td>$no</td>
            <td>$row[obatalkes_nama]</td>
            <td>$row[jumlah]</td>
        </tr>";
        }
        $result['message'] = 'success';
        $result['list_obat'] = $html;
    } else {
        $html .= "<tr>
            <td valign='top' colspan='4' class='text-center'>No data available in table</td>
            </tr>";
        $result['message'] = 'failed : ' . $koneksi->errno;
        $result['list_obat'] = $html;
    }

    echo json_encode($result);
}
