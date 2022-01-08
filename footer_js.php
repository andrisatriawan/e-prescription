<?php
if (@$_GET['page'] == 'beranda' or @$_GET['page'] == '') {
?>
    <script>
        $('#tb-resep').DataTable();
    </script>
<?php } elseif ($_GET['page'] == 'tambah') { ?>
    <script>
        let html_racikan = `
        <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="nama-racikan">Nama Racikan</label>
                        <input type="text" class="form-control" id="nama-racikan" required>
                        <div class="invalid-feedback" id='validasi-nama'>
                            Tidak boleh kosong.
                        </div>
                    </div>
                </div>
                <form class="needs-validation tambah" novalidate>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="obat">Obat</label>
                        <select class="form-control select2" style="width: 100%;" id="obat" required>
                            
                        </select>
                        <div class="invalid-feedback">
                            Pilih salah satu obat.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="jumlah">Jumlah</label>
                        <span class="badge badge-pill badge-primary" id="stok">Stok 0</span>
                        <input type="number" class="form-control" id="jumlah" required disabled>
                        <div class="invalid-feedback" id='validasi-jumlah'>
                            Masukan jumlah.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label style="color: white;">_</label>
                        <a id="tambah" class="form-control btn btn-sm btn-primary disabled">Tambah</a>
                    </div>
                </div>
                </form>`;
        let html_non_racikan = `<form class="needs-validation tambah" novalidate>
                <div class="form-row">
                <input type="hidden" value="" id="nama-racikan">
                    <div class="col-md-6 mb-3">
                        <label for="obat">Obat</label>
                        <select class="form-control select2" style="width: 100%;" id="obat" required>
                            
                        </select>
                        <div class="invalid-feedback">
                            Pilih salah satu obat.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="jumlah">Jumlah</label>
                        <span class="badge badge-pill badge-primary" id="stok">Stok 0</span>
                        <input type="number" class="form-control" id="jumlah" disabled required>
                        <div class="invalid-feedback" id='validasi-jumlah'>
                            Masukan jumlah.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label style="color: white;">_</label>
                        <a id="tambah" class="form-control btn btn-sm btn-primary disabled">Tambah</a>
                    </div>
                </div>
                </form>`;
        $('#jenis-resep').change(function() {
            getForm()
        });

        function handleTambahClick() {
            $('#tambah').click(function() {
                var jenis_resep = $('#jenis-resep').val();
                if (jenis_resep == '0') {
                    $(this).addClass('disabled');
                }

                var id_obat = $('#obat').val()
                var jumlah = $('#jumlah').val()

                $.ajax({
                    type: "POST",
                    url: 'config/data.php?action=tambah_keranjang',
                    dataType: "JSON",
                    data: {
                        id_obat: id_obat,
                        jumlah: jumlah,
                        jenis_resep: jenis_resep
                    },
                    success: function(data) {
                        if (data.status == '200') {
                            getForm();
                        }
                    }
                })

            })

            var forms = document.getElementsByClassName('needs-validation tambah');
            var btn_tambah = document.getElementById('tambah');

            Array.prototype.filter.call(forms, function(form) {
                btn_tambah.addEventListener('click', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }

        function getForm() {
            if ($('#jenis-resep').val() == '0') {
                console.log('non-racikan')
                $('#isi-form').html(html_non_racikan);
            } else {
                console.log('racikan')
                $('#isi-form').html(html_racikan);
            }
            // $('#signa').attr('disabled', false)
            $('#simpan').attr('disabled', true)
            getObat();
            getSigna();
            //Initialize Select2 Elements
            $('.select2').select2()
            tampilKeranjang();
            getStok();
            handleTambahClick();
        }

        function tampilKeranjang() {
            var jenis_resep = $('#jenis-resep').val();
            $.ajax({
                type: "POST",
                url: 'config/data.php?action=get_keranjang',
                dataType: "JSON",
                data: {
                    jenis_resep: jenis_resep
                },
                success: function(data) {
                    $('#data-keranjang').html(data.output);
                    if (data.count != 0) {
                        if ($('#jenis-resep').val() == '0') {
                            $('#obat').attr('disabled', true)
                        } else {
                            $('#obat').attr('disabled', false)
                        }
                        $('#signa').attr('disabled', false)
                    } else {
                        $('#signa').attr('disabled', true)
                    }
                }
            })
        }

        function getStok() {
            var stok = 0;
            $('#obat').change(function() {
                var id_obat = $(this).val();
                $.ajax({
                    type: "POST",
                    url: 'config/data.php?action=get_stok',
                    dataType: 'JSON',
                    data: {
                        id_obat: id_obat
                    },
                    success: function(data) {
                        $('#stok').html('Stok ' + data.stok);
                        let stok = data.stok;
                        handleStok(stok);
                    }
                })
                $('#jumlah').attr('disabled', false);
                $('#jumlah').val('');
            })
        }

        function handleStok(newStok) {
            $('#jumlah').keyup(function() {
                if ($(this).val() > parseFloat(newStok)) {
                    $('#validasi-jumlah').html('Jumlah melebihi stok');
                    $('#validasi-jumlah').css('display', 'block');
                    $('#tambah').addClass('disabled');
                } else if ($(this).val() == '' || $(this).val()==0) {
                    $('#validasi-jumlah').html('Jumlah tidak boleh kosong');
                    $('#validasi-jumlah').css('display', 'block');
                    $('#tambah').addClass('disabled');
                } else {
                    $('#validasi-jumlah').html('Jumlah tidak boleh kosong');
                    $('#validasi-jumlah').css('display', 'none');
                    $('#tambah').removeClass('disabled');
                }
            })
        }

        function getObat() {
            $.ajax({
                type: 'POST',
                url: 'config/data.php?action=cari_obat',
                success: function(data) {
                    $('#obat').html(data);
                }
            })
        }

        function getSigna() {
            $.ajax({
                type: "POST",
                url: 'config/data.php?action=get_signa',
                success: function(data) {
                    $('#signa').html(data);
                }
            })
        }

        function simpanResep() {
            var nama_racikan = $('#nama-racikan').val();
            var jenis_resep = $('#jenis-resep').val();
            var signa = $('#signa').val();

            $.ajax({
                type: "POST",
                url: 'config/data.php?action=simpan_resep',
                dataType: "JSON",
                data: {
                    nama_racikan: nama_racikan,
                    jenis_resep: jenis_resep,
                    signa: signa
                },
                success: function(data) {
                    if (data.message == 'success') {
                        getForm();
                    }
                }
            })
        }

        $('#simpan').click(function() {
            var nama_racikan = $('#nama-racikan').val();
            var jenis_resep = $('#jenis-resep').val();
            if (jenis_resep == '1' && nama_racikan == '') {
                $('#validasi-nama').css('display', 'block')
                $('#nama-racikan').focus();
            } else {
                // console.log('disimpan');
                simpanResep();
            }
        });

        $('#signa').change(function() {
            $('#simpan').attr('disabled', false)
        });


        $('#btn-hapus').click(function() {
            var id_keranjang = $('#id-hapus').val();
            var jumlah_keranjang = $('#jumlah-keranjang').val();
            $.ajax({
                type: "POST",
                url: 'config/data.php?action=hapus_keranjang',
                dataType: 'JSON',
                data: {
                    id_keranjang: id_keranjang,
                    jumlah_keranjang: jumlah_keranjang
                },
                success: function(data) {
                    if (data.message == 'success') {
                        getForm();
                        $('#modal-hapus').modal('hide');
                    }
                }
            })
        });

        $('#modal-hapus').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_keranjang = button.data('id')
            var jumlah = button.data('jumlah')

            var modal = $(this)
            modal.find('#id-hapus').val(id_keranjang)
            modal.find('#jumlah-keranjang').val(jumlah)
        });

        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {

            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                var btn_simpan = document.getElementById('simpan');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    btn_simpan.addEventListener('click', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

<?php } ?>