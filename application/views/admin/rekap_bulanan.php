    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rekap Bulanan</title>
        <!-- Tambahkan tag-head Anda di sini, seperti CSS dan JavaScript yang dibutuhkan -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <!-- Tambahkan link CSS khusus jika diperlukan -->
        <style>
            .table-responsive {
                overflow-x: auto;
            }
        </style>
    </head>
    <body>
            
            <?php $this->load->view('components/sidebar_admin'); ?>
            <div class="min-vh-100 d-flex py-2 justify-content-center">
                <div class="col-md-12">
                    <h2>Rekap Bulanan</h2>
                            <!-- Filter Bulan -->
                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url('admin/rekap_bulanan'); ?>" method="get">
                            <div class="form-group">
                                <select class="form-control" id="bulan" name="bulan">
                                    <option value="">Pilih Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-dark mt-2">Filter</button>
                        </form>
                    </div>
                </div>

                <!-- Tombol Eksport Rekap Bulanan -->
                <div class="my-3">
                    <form id="exportForm" action="<?php echo base_url('admin/export_rekap_bulanan'); ?>" method="post">
                        <div class="form-group">
                            <label for="bulan">Bulan:</label>
                            <input type="month" id="bulan" name="bulan" class="form-control">
                        </div>
                        <button type="button" class="btn btn-dark" id="exportButton">Eksport Rekap Bulanan</button>
                    </form>
                </div>

                    <div class="card my-4">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Total Absensi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                            <?php foreach ($rekap_bulanan as $data): ?>
                                                <tr>
                                                    <td><?= date("F", mktime(0, 0, 0, $data['bulan'], 1)); ?></td>
                                                    <td><?= $data['total_absensi']; ?></td>
                                                </tr>
                                                <tr class="detail-row" data-month="<?= $data['bulan'] ?>">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-dark" style="min-width: 100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>Nama</th>
                                                                        <th>Tanggal</th>
                                                                        <th>Kegiatan</th>
                                                                        <th>Masuk</th>
                                                                        <th>Pulang</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($rekap_harian as $rekap_harian): ?>
                                                                        <?php if (date('n', strtotime($rekap_harian['tanggal'])) == $data['bulan']): ?>
                                                                            <tr>
                                                                                <td><?= $rekap_harian['id']; ?></td>
                                                                                <td><?= panggil_username($rekap_harian['id_karyawan']) ?></td>
                                                                                <td><?= $rekap_harian['tanggal']; ?></td>
                                                                                <td><?= $rekap_harian['kegiatan']; ?></td>
                                                                                <td><?= $rekap_harian['jam_masuk']; ?></td>
                                                                                <td><?= $rekap_harian['jam_pulang']; ?></td>
                                                                                <td><?= $rekap_harian['status']; ?></td>
                                                                            </tr>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
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


            <script>
                $(document).ready(function() {
                    $('#exportButton').on('click', function() {
                        var selectedMonth = $('#bulan').val();
                        if (selectedMonth) {
                            // Setelah pengguna memilih bulan, ubah nama elemen input "bulan"
                            // sesuai dengan bulan yang dipilih dan kirimkan formulir.
                            $('#bulan').attr('name', 'bulan_' + selectedMonth);
                            $('#exportForm').submit();
                        }
                    });
                });
            </script>
            
            <!-- Tambahkan tag-script Anda di sini, seperti JavaScript yang dibutuhkan -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <!-- Tambahkan link JavaScript khusus jika diperlukan -->
    </body>
    </html>
