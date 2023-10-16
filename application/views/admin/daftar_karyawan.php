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
<div class="min-vh-100 d-flex py-2 justify-content-center">
    <div class="col-md-9">
        <h2>Riwayat Absen</h2>
        <div class="py-3">
            <a class="btn btn-outline-primary mb-2" href="<?= base_url('admin/export_karyawan')?>">Export</a>
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
</div>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</body>
</html>
