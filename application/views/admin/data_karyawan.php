<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Bulanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Tambahkan CSS kustom Anda di sini jika diperlukan */
    </style>
</head>

<body>
    <?php $this->load->view('components/sidebar_admin'); ?>
    <div class="min-vh-100 d-flex py-2 justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="my-2 d-flex justify-content-between">
                        <h2>Rekap Data Karyawan</h2>
                        <a class="btn btn-dark"  href="<?php echo base_url('admin/export_rekap_mingguan') ?>"; ?>Eksport Data Karyawan</a>
                    </div>    
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; foreach ($user as $row): $no++ ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $row->username; ?></td>
                                <td><?= $row->email; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div> 
            </div>
        </div>
        </div>
    </div>
    <!-- penghubung dashboard -->
    </div>
        </div>
      </div>
    </div>
    <!-- Tambahkan JavaScript dan CSS kustom Anda di sini jika diperlukan -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
