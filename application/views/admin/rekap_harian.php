        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Rekap Harian</title>
            <!-- Tambahkan tag-head Anda di sini, seperti CSS dan JavaScript yang dibutuhkan -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="path/to/your/custom.css">
            <style>
              
            </style>
        </script>
        </head>
        <body>
            <?php $this->load->view('components/sidebar_admin'); ?>
            <div class="min-vh-100 d-flex py-2 justify-content-center">
                <div class="col-md-12">
                    
                    <div class="card">
                        <div class="card-body">
                            <h2>Rekap Harian</h2>
                            <div class="d-flex justify-content-end py-1">
                                <form action="<?= base_url('admin/rekap_harian'); ?>" method="get">
                                    <div class="form-group d-flex">
                                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                                        <button type="submit" class="btn btn-dark " style="margin-right: 10px;">Filter</button>
                                    </div>
                                </form>
                                <a class="btn btn-dark " href="<?= base_url('admin/export_rekap_harian?tanggal=' . $tanggal); ?>" style="margin-left: 10px;">Ambil Rekap Harian</a>
                            </div>

                            <table class="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Tanggal</th>
                                        <th>Kegiatan</th>
                                        <th>Masuk</th>
                                        <th>Pulang</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; foreach ($rekap_harian as $rekap): $no++?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= panggil_username($rekap['id_karyawan']) ?></td>
                                            <td><?= $rekap['tanggal']; ?></td>
                                            <td><?= $rekap['kegiatan']; ?></td>
                                            <td><?= $rekap['jam_masuk']; ?></td>
                                            <td><?= $rekap['jam_pulang']; ?></td>
                                            <td><?= $rekap['status']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- penghubung dashboard -->
            </div>
            </div>
        </div>
        </div>
            <!-- Tambahkan tag-script Anda di sini, seperti JavaScript yang dibutuhkan -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="path/to/your/custom.js"></script>
        </body>
        </html>
