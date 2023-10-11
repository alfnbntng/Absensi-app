<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan</title>
    <!-- Tambahkan tag-head Anda di sini, seperti CSS dan JavaScript yang dibutuhkan -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/your/custom.css">
</head>
<body>
    <?php $this->load->view('components/sidebar_karyawan'); ?>
    <div class="d-flex py-2 justify-content-center">
        <div class="card px-5">
            <div class="card-header">
                Data Hadir
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p>Jumlah data absensi: <?php echo count($absensi); ?></p>
                </blockquote>
            </div>
        </div>

        <div class="card px-5">
            <div class="card-header">
                Data Izin
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p>Jumlah data izin: 8</p>
                </blockquote>
            </div>
        </div>

        
    </div>
    <div class="px-3">
            <table class="table">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=0; foreach($absensi as $row): $no++ ?>
                        <tr class="text-center">
                            <td><?php echo $no ?></td>
                            <td><?php echo $row->tanggal ?></td>
                            <td><?php echo $row->jam_masuk ?></td>
                            <td><?php echo $row->jam_pulang ?></td>
                            <td><?php echo $row->status ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
     
    </div>

    <!-- Tambahkan tag-script Anda di sini, seperti JavaScript yang dibutuhkan -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="path/to/your/custom.js"></script>
</body>
</html>
