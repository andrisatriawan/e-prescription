<div class="card">
    <div class="card-body">
        <div id="message">

        </div>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label for="jenis-resep">Jenis Resep</label>
                <select class="custom-select" id="jenis-resep" required>
                    <option selected disabled value="">Choose...</option>
                    <option value="0">Non Racikan</option>
                    <option value="1">Racikan</option>
                </select>
                <div class="invalid-feedback">
                    Pilih salah satu.
                </div>
            </div>
        </div>
        <div id="isi-form">

        </div>
        <div class="mt-3">
            <h3 class="text-center">Obat yang dipilih</h3>
        </div>

        <table class="table table-hover mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Obat</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="data-keranjang">
                <tr>
                    <td valign='top' colspan='4' class='text-center'>No data available in table</td>
                </tr>
            </tbody>
        </table>

        <div class="form-row">
            <div class="col-md-12 mb-3">

                <label for="signa">Signa</label>
                <select class="custom-select select2" id="signa" required disabled>

                </select>
                <div class="invalid-feedback">
                    Pilih salah satu.
                </div>
            </div>
        </div>
        <button class="btn btn-primary" id="simpan" disabled>Simpan</button>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-hapus" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Hapus dari List yang dipilih</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" value="" id="id-hapus">
                <input type="hidden" value="" id="jumlah-keranjang">
                Apakah anda ingin menghapus obat ini dari list obat?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-primary" id="btn-hapus">Ya</button>
            </div>
        </div>
    </div>
</div>