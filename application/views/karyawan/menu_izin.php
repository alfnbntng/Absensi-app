<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Izin Karyawan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/your/custom.css">
    <style>
        .container {
            padding: 20px;
        }
        .form-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .form-container h1 {
            text-align: center;
        }
        .form-container label {
            font-weight: bold;
        }
        .form-container textarea {
            width: 100%;
        }
        .form-container button {
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <?php $this->load->view('components/sidebar_karyawan'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 form-container">
                <h1>Form Izin Karyawan</h1>
                <form action="<?= base_url('karyawan/menu_izin'); ?>" method="post">
                    <div class="mb-3">
                        <label for="keterangan">Keterangan Izin</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajukan Izin</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="path/to/your/custom.js"></script>
</body>
</html>
