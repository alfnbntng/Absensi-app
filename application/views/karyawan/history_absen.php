<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Absen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/your/custom.css">
</head>
<body>
<?php $this->load->view('components/sidebar_karyawan'); ?>
    <div class="min-vh-100 py-2 justify-content-center">
        <h2>Riwayat Absen</h2>
        <table class="table table-hover table-responsive">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Kegiatan</th>
                    <th>Keterangan Izin</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 0; foreach($absensi as $row) { $no++; ?>
                <tr class="text-center">
                    <td><?php echo $no; ?></td>
                    <td><?php echo $row->tanggal; ?></td>
                    <td><?php echo panggil_username($row->id_karyawan); ?></td>
                    <td><?php echo $row->kegiatan; ?></td>
                    <td><?php echo $row->keterangan_izin; ?></td>
                    <td><?php echo $row->jam_masuk; ?></td>
                    <td id="jamPulang_<?php echo $row->id; ?>"><?php echo $row->jam_pulang; ?></td>
                    <td><?php echo $row->status; ?></td>
                    <td>
                        <?php if ($row->status == 'Izin'): ?>
                           -
                        <?php else: ?>
                            <div id="aksi_<?php echo $row->id; ?>">
                                <?php if ($row->status == 'pulang'): ?>
                                    <a href="<?php echo site_url('karyawan/batal_pulang/' . $row->id); ?>" class="btn btn-danger">Batal Pulang</a>
                                <?php else: ?>
                                    <a href="<?php echo site_url('karyawan/pulang/' . $row->id); ?>" class="btn btn-success" id="pulangButton_<?php echo $row->id; ?>">
                                        Pulang
                                    </a>
                                <?php endif; ?>
                                <?php if ($row->status != 'pulang' && $row->status != 'Izin'): ?>
                                    <a href="<?php echo site_url('karyawan/ubah_absensi/' . $row->id); ?>" class="btn btn-warning">Ubah</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Mengatur tampilan tombol berdasarkan status saat memuat halaman
    <?php foreach ($absensi as $row): ?>
        var absenId = <?php echo $row->id; ?>;
        var status = '<?php echo $row->status; ?>';
        disablePulangButton(absenId, status);
    <?php endforeach; ?>
    
    function showSweetAlert(message) {
        Swal.fire({
            icon: 'info',
            text: message,
            showConfirmButton: false,
            timer: 2000
        });
    }

    // function disablePulangButton(absenId, status) {
    //     var pulangButton = document.getElementById("pulangButton_" + absenId);
    //     if (status === 'pulang') {
    //         // Tombol "Batal Pulang" diklik, Anda dapat menambahkan kode di sini
    //         pulangButton.classList.add("btn-danger");
    //         pulangButton.classList.remove("btn-success");
    //         pulangButton.innerHTML = "Batal Pulang";
    //     } else {
    //         // Tombol "Pulang" diklik, Anda dapat menambahkan kode di sini
    //         pulangButton.classList.remove("btn-danger");
    //         pulangButton.classList.add("btn-success");
    //         pulangButton.innerHTML = "Pulang";
    //     }
    // }
    
    // Memeriksa status saat tombol "Pulang" di klik
  document.addEventListener("click", function(event) {
    if (event.target.id && event.target.id.startsWith("pulangButton_")) {
        var absenId = event.target.id.replace("pulangButton_", "");
        var status = 'pulang'; // Mengatur status sesuai dengan "pulang"

        // Memanggil fungsi untuk mengubah tampilan tombol
        disablePulangButton(absenId, status);

        // Menghapus elemen yang menampilkan jam pulang dari tampilan
        var jamPulangElement = document.getElementById("jamPulang_" + absenId);
        if (jamPulangElement) {
            jamPulangElement.parentNode.removeChild(jamPulangElement);
        }

        // Di sini, Anda juga dapat menambahkan kode untuk memproses penghapusan jam pulang dari basis data jika diperlukan.
        // Contoh:
        // Mengirim permintaan ke server untuk menghapus jam pulang dari basis data.
        // Implementasinya tergantung pada teknologi yang Anda gunakan (AJAX, REST API, dll.).
    }
});


    function disablePulangButton(absenId, status) {
        var pulangButton = document.getElementById("pulangButton_" + absenId);
        if (status === 'pulang') {
            // Tombol "Batal Pulang" diklik
            pulangButton.classList.add("btn-danger");
            pulangButton.classList.remove("btn-success");
            pulangButton.innerHTML = "Batal Pulang";
        }
    }

</script>
</body>
</html>
