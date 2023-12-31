<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Register</title> 
    <!-- Tambahkan link ke Bootstrap CSS --> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css"> 
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("inputPassword"); // Ganti "password" menjadi "inputPassword"
            var icon = document.querySelector(".toggle-password");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-regular fa-eye");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-regular fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }
    </script>
 
 
    <style> 
 
        body { 
            background-image: url('https://1.bp.blogspot.com/-ecoj5ptIkf0/X0VWk_iYp8I/AAAAAAAAMXc/m9s0V-lY4LcVy1t-3SKgwRrwFIwK-L2HQCNcBGAsYHQ/w1200-h630-p-k-no-nu/TUMNAIL-BLOG-WSM.jpg'); 
            background-size: cover;  
            background-repeat: no-repeat; 
            background-attachment: fixed;  
        } 
        .card-title { 
            color: #fff; 
        } 
        .card { 
            background-color: rgba(255, 255, 255, 0.3);  
            padding: 5px;
        } 
        .logo { 
            max-width: 80px; 
            height: auto;  
            display: block;  
            margin: 0 auto 40px;  
        } 

        label{
            color:white;
        }

        .field-icon {
            position: absolute;
            top: 53%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            user-select: none;
            background-color:white;
        }

 
    </style> 
</head> 
<body> 
    <div class="min-vh-100 d-flex align-items-center"> 
        <div class="container"> 
            <h1 class="text-center text-light">Daftar Admin</h1>
            <div class="row justify-content-center"> 
                <div class="col-md-4"> 
                    <div class="card"> 
                        <div class="card-body"> 
                            <form class="row g-3" action="<?= base_url('Auth/process_register_admin'); ?>" method="post"> 
                                <div class="col-md-6">
                                    <label for="inputName4" class="form-label">Nama Depan</label>
                                    <input name="first_name" type="first name" class="form-control" id="inputName4">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputPassword4" class="form-label">Nama Belakang</label>
                                    <input name="last_name" type="last_name" class="form-control" id="inputPassword4">
                                </div>
                                <div class="col-12">
                                    <label for="inputEmail" class="form-label">Email</label>
                                    <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email">
                                </div>
                                <div class="col-12">
                                    <label for="inputPassword" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password">
                                        <span class="input-group-text field-icon toggle-password" onclick="togglePassword()">
                                            <i class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress2" class="form-label">Username</label>
                                    <input name="username" type="text" class="form-control" id="inputAddress2" placeholder="Username">
                                </div>
                                <div class="text-center py-2 col-12">
                                    <button type="submit" class="btn btn-dark">Daftar</button>
                                </div>
                            </form> 
                            <div class="text-center">
                                    <span><a class="text-white" href="<?= base_url('auth');?>">Klik di sini bila sudah memiliki akun</a></span>
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
    </div> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body> 
</html>