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
    <div class="min-vh-100 d-flex py-2 justify-content-center">
        <div class="col-md-9">
            <h2>Riwayat Absen</h2>
            <table class="table">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=0; foreach($absensi as $row): $no++ ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $row->tanggal ?></td>
                                <td><?php echo $row->jam_masuk ?></td>
                                <td><?php echo $row->jam_pulang ?></td>
                                <td><?php echo $row->status ?></td>
                                <td>
                                <td>
                                    <a href="<?php echo site_url('karyawan/pulang/' . $row->id); ?>" class="btn btn-success">Pulang</a>
                                    <a href="" class="btn btn-warning">Ubah</a>
                                    <button class="btn btn-danger">Hapus</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="path/to/your/custom.js"></script>
</body>
</html>
