<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
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
                        <h2 class="card-title">Edit Profil</h2>
                        <form action="<?= base_url('karyawan/edit_profile'); ?>" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="Username Anda">
                            </div>
                            <div class="mb-3">
                                <label for="first_name" class="form-label">Nama Depan</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="Nama Depan Anda">
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Nama Belakang</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="Nama Belakang Anda">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="email@anda.com">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="path/to/your/custom.js"></script>
</body>
</html>
