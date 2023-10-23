<!DOCTYPE html>
<html lang="en">
<head>   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/your/custom.css">
</head>
<body>
    <?php $this->load->view('components/sidebar_karyawan'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Ubah Absensi</h1>
                        <form action="<?= base_url('karyawan/ubah_absensi/' . $absen_id); ?>" method="post" id="ubahAbsensiForm">
                            <div class="mb-3">
                                <label for="kegiatan" class="form-label">Kegiatan:</label>
                                <input type="text" class="form-control" id="kegiatan" name="kegiatan" value="<?= $absensi->kegiatan; ?>" required>
                            </div>
                            <button type="button" class="btn btn-primary" id="simpanButton">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="path/to/your/custom.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // Menggunakan jQuery untuk menambahkan event click pada tombol "Simpan Perubahan"
        $(document).ready(function() {
            $('#simpanButton').click(function() {
                Swal.fire({
                    title: 'Simpan Perubahan',
                    text: 'Apakah Anda yakin ingin menyimpan perubahan ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengonfirmasi, submit form
                        $('#ubahAbsensiForm').submit();
                    }
                });
            });
        });
    </script>
</body>
</html>

