# e-Prescription
Aplikasi sederhana untuk dapat melakukan pencatatan pemberian resep secara digital.

## Tools yang dibutuhkan untuk menjalankan aplikasi
- [XAMPP](https://www.apachefriends.org/download.html)

## Instalasi Aplikasi
- Download source code atau clone aplikasi [disini](https://github.com/andrisatriawan/e-prescription.git)
- Pindahkan dan extract file yang telah di download ke dalam folder htdocs.
- Buat database dengan nama e_prescription
- Import database e_prescription.sql di dalam folder project.
- Jalankan aplikasi melalui link berikut http://localhost/e-prescription/

## User guide penggunaan aplikasi
- Pada halaman awal terdapa tabel yang berisi resep yang telah di simpan
- Jika ingin menambahkan resep pilih tombol Buat Resep
- Akan muncul form isian untuk menambahkan resep
- Tombol simpan akan aktif jika jenis resep dipilih, terdapat data obat yang dipilih di dalam tabel, signa tidak kosong, dan jika jenis resep racikan maka nama racikan tidak boleh kosong
- Jika jenis resep non racikan maka user hanya dapat mengisi satu jenis obat
- Jika jenis resep non racikan maka user dapat memilih lebih dari satu jenis obat
- User dapat menghapus obat yang telah dipilih
- User dapat melihat stok obat ketika user memilih obat
- User dapat mengetahui jika jumlah obat yang di input melebihi stok obat dan tombol tambah akan mati
- Jumlah akan aktif jika user memilih obat terlebih dahulu
- Tombol tambah akan aktif jika obat dipilih dan jumlah obat yang dipilih tidak melebihi stok atau tidak kosong