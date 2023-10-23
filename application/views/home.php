<!-- application/views/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Tambahkan link ke Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">

    <style>
        @font-face {font-family: 'Poppins'; src: url('path/to/Poppins-Regular.ttf');}

        body {
            background-image: url('https://winair.ca/wp-content/uploads/2019/01/Our-Team-Employee-Background-Image-.jpg');
            background-size: cover; 
            font-family: 'Poppins', sans-serif;
            background-repeat: no-repeat;
            background-attachment: fixed; 
        }
        .card-title {
            color: #fff;
        }
        .card {
            background-color: rgba(0, 0, 0, 0.2); 
            padding: 20px;
        }
        .logo {
            max-width:200px;
            height: auto; 
            display: block; 
            margin: 0 auto 20px; 
        }
        .custom-button {
            font-size: 10px; 
            width: 150px
        }
        .footer {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 10px;
            color: #fff; 
        }

    </style>
</head>
<body>
    <div class="min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="">
                        <div class="container">
                            <img src="https://binusasmg.sch.id/ppdb/logobinusa.png" alt="Logo" class="mb-1 logo">
                            <h2 class="text-center text-dark fs-1 mb-4">Absensi-App</h2>
                            <div class="d-flex justify-content-center ">
                                <a href="<?php echo base_url('/auth'); ?>" type="submit" class="w-100 btn btn-warning custom-button">Masuk</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <footer class="footer text-center mt-5">
        <p>&copy; <?php echo date('Y'); ?> SMK Bina Nusantara Demak</p>
    </footer>
</body>
</html>