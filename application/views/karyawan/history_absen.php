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
                    <th>Status</bth>
                    <th>Pulang</th>
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
                    <td><?php echo $row->jam_pulang; ?></td>
                    <td><?php echo $row->status; ?></td>
                    <td>
                        <?php if ($row->status == 'Izin'): ?>
                           -
                        <?php else: ?>
                            <?php if ($row->status == 'pulang'): ?>
                                <a href="<?php echo site_url('karyawan/batal_pulang/' . $row->id); ?>" class="btn btn-danger">Batal Pulang</a>
                            <?php else: ?>
                                <a href="<?php echo site_url('karyawan/pulang/' . $row->id); ?>" class="btn btn-success" id="pulangButton_<?php echo $row->id; ?>">
                                    Pulang
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($row->status != 'pulang' && $row->status != 'Izin'): ?>
                        <a href="<?php echo site_url('karyawan/ubah_absensi/' . $row->id); ?>" class="btn btn-warning">Ubah</a>
                        <?php endif; ?>
                            <a href="javascript:void(0);" class="btn btn-danger" onclick="confirmDelete(<?php echo $row->id; ?>)">Hapus</a>
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

    function disablePulangButton(absenId, status) {
        var pulangButton = document.getElementById("pulangButton_" + absenId);
        if (status === 'pulang') {
            pulangButton.classList.add("disabled");
            pulangButton.removeAttribute("href");
        }
    }

    // Fungsi untuk mengonfirmasi penghapusan
    function confirmDelete(absenId) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Anda yakin ingin menghapus item ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke halaman penghapusan jika dikonfirmasi
                window.location.href = "<?php echo site_url('karyawan/hapus/'); ?>" + absenId;
            }
        });
    }
</script>
</body>
</html>
