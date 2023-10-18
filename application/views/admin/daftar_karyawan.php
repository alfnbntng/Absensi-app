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
<?php $this->load->view('components/sidebar_admin'); ?>
<div class="min-vh-100 py-2 justify-content-center">
        <h2>Riwayat Absen</h2>
        <div class="py-3">
            <button type="button" class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#myModal">
                Filter
            </button>

                <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Form Contoh</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h3 class="text-center text-dark">Filter Tanggal</h3>
                                <!-- Form di dalam modal -->
                                <form method="get" action="<?= base_url('admin/daftar_karyawan') ?>">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="tanggalMulai">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="tanggalAkhir">Tanggal Akhir</label>
                                            <input type="date" class="form-control" id="tanggalAkhir" name="tanggalAkhir">
                                        </div>
                                        <div class="form-group col-12">
                                            <button type="submit" class="btn btn-primary mt-4">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

        
            <a class="btn btn-primary mb-2" href="<?= base_url('admin/export_karyawan')?>">Export</a>
        </div>
        <table class="table table-hover table-responsive">
            <thead style="background-color: #373193;" class="table">
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Kegiatan</th>
                    <th>Izin</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Status</bth>
                    
                </tr>
            </thead>
            <tbody>
            <?php $no = 0; foreach($absensi as $row) : $no++; ?>
                <tr class="text-center">
                    <td><?php echo $no; ?></td>
                    <td><?php echo panggil_username($row['id_karyawan']); ?></td>
                    <td><?php echo $row['tanggal']; ?></td>
                    <td><?php echo $row['kegiatan']; ?></td>
                    <td><?php echo $row['keterangan_izin']; ?></td>
                    <td><?php echo $row['jam_masuk']; ?></td>
                    <td><?php echo $row['jam_pulang']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</div>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</body>
</html>