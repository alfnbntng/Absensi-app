<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Mingguan</title>
    <!-- Tambahkan tag-head Anda di sini, seperti CSS dan JavaScript yang dibutuhkan -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Tambahkan link CSS khusus jika diperlukan -->
</head>
<body>
    <?php $this->load->view('components/sidebar_admin'); ?>
    <div class="container-fluid">
        <div class="col-md-9">
            <h2>Rekap Mingguan</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Total Absensi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rekap_mingguan as $data) { ?>
                        <tr>
                            <td><?= $data['tanggal']; ?></td>
                            <td><?= $data['total_absensi']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Tambahkan tag-script Anda di sini, seperti JavaScript yang dibutuhkan -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tambahkan link JavaScript khusus jika diperlukan -->
</body>
</html>
