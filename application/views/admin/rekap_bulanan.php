<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Bulanan</title>
    <!-- Tambahkan tag-head Anda di sini, seperti CSS dan JavaScript yang dibutuhkan -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Tambahkan link CSS khusus jika diperlukan -->
</head>
<body>
    
    <?php $this->load->view('components/sidebar_admin'); ?>
    <div class="min-vh-100 d-flex py-2 justify-content-center">
        <div class="col-md-9">
            <h2>Rekap Bulanan</h2>

            <!-- Filter Bulan -->
            <form action="<?= base_url('admin/rekap_bulanan'); ?>" method="get">
                <div class="form-group">
                    <select class="form-control" id="bulan" name="bulan">
                        <option>Pilih Bulan</option>
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
                <button type="submit" class="btn btn-primary mt-2">Filter</button>
            </form>
            <table class="table">
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
                <td colspan="2">
                <div class="scrollspy">
                    <table class="table">
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
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        </div>
    </div>
<!-- penghubung dashboard -->
        </div>
        </div>
      </div>
    </div>
    
    <!-- Tambahkan tag-script Anda di sini, seperti JavaScript yang dibutuhkan -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tambahkan link JavaScript khusus jika diperlukan -->
</body>
</html>
