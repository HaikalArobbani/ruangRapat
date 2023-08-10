Catetan :

halaman register:
<!-- Halaman erorr ketika nama sama -->
<!-- tab divisi, dibuat option dropdown -->
<!-- masih ada erorr tertentu -->
<!-- ubah menjadi tampilan seperti di template -->
<!-- bentuk form masih kyk di halaman awal. -->

<!-- pilih role masih bisa masuk di hapus select role/di tambahkan labelnya/ ada cara lain -->
<!-- search di home di hapus
logo gambar pdam ke halaman home -->

<!-- pegawai ganti jadi admin -->

<!-- pesan error jadi bahasa indonesia -->

halaman Permohonan :


<!-- tambahkan kolom fasilitas tambahan di permohonan rapat2 -->
<!-- admin tidak perlu absen -->
<!-- waktu keluar di ganti sama fasilitas dan jumlah peserta -->
<!-- Fasilitas dgianti menjadi fasilitas tambahan -->

<!-- csv & exel & pdf & print :

hapus opsi,absen dan notulen
tambahkan yang ada di dalam detil
*buat sendiri atau ubah di css nya -->

<!-- format tanggal indonesia -->
nama judul di pdf


<!-- CRUD : Buat pegawai -->

halaman home :
<!-- halaman di home di bikin link ke halaman terkait, dijadikan modal   -->
<!-- jumlah admin hanya bisa dilihat admin -->
<!-- jumlah ruang rapat tersedia pada hari h (yang sudah di proses dan di terima) -->
<!-- tambah fasilitas + kapasitas masing-masing ruangan. -->
<!-- tambah tab panel : ruangan terbooking/terajukan -->
<!-- grafik jumlah ruangan terpakai -->
<!-- ruang rapat tersedia, ruang rapat kosong -->
<!-- Di modal ruang tersedia, muncul list ruangan yang tersedia
modal ruangan terpakai, muncul list ruangan yang terpakai -->
halaman rapat :
<!-- tambahkan fasilitas -->



halaman absen :
<!-- nama yang muncul sesuai dengan divisinya -->
<!-- opsi di divisi di disable -->
<!-- gunakan select hidden untuk divisinya -->
how??


form tambah permohonan :


halaman jadwal :
<!-- Tambah table ruang rapat yang tersedia // bisa -->
<!-- tambahan kolom fasilitas,kapasitas -->
panel di tolak :
<!-- notif pesan yang belom dibaca -->
<!-- *tinggal dibikin agar ketika di reload tidak muncul lagi -->


masalah :
<!-- register tidak bisa
divisi tidak masuk ketika absen -->



<!-- Durasi rapat
dibawah 3
di atas dapaet makan siang
Catatan 2 : -->

<!-- ketika diterima tidak dapat pindah ruangan, tidak perlu catatan -->
<!-- absen di selesai di hapus -->



<!-- email untuk admin rumga -->


untuk pop up kapasitas:
ambil nilai kapasitas masing masing ruangan
masukan ke dalam form, tpi di hidden
buat if nya
pdf di modal








// $(document).ready(function() {
// $('body').on('click', '.edit_permohonan', function() {
// var id = $(this).attr('data-id');
// $.ajax({
// url: "{{ route ('editPermohonan')}}?id=" + id,
// type: "POST",
// dataType: "JSON",
// success: function(data) {

// }
// })
// })
// })

// fungsi js agar ketika panel ditolak di klik maka, span notif akan menghilang
//mengambil id permohononan rapat dengan bebera kondisi tertentu (where), dengan menggunakan queryBuilder
// Fungsi pluck digunakan untuk mengambil nilai tunggal dari kolom yang ditentukan.

//ambil jumlah sttatus yang belum di baca dan hitung ada berapa dengan count


// dd($spanTolak);

//menggunakana perulangan untuk mendapatkan setiap id dari yang di tolak
// kondisi x akan terus bertambah/loop sampai memiliki jumlah yg sama atau lebih besar dengan variabel count
//fungsi javascript untuk mengubah nilai status baca dari 1 menjadi 0
// mendapatkan id dari permohonan rapat yang sudah di looping

//mengubah nilai di route
//pasing id pada routing