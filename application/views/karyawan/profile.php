<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> 
    <style>
        .img-account-profile {
            height: 10rem;
        }
        .rounded-circle {
            border-radius: 50% !important;
        }
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
        }
        .card .card-header {
            font-weight: 500;
        }
        .card-header:first-child {
            border-radius: 0.35rem 0.35rem 0 0;
        }
        .card-header {
            padding: 1rem 1.35rem;
            margin-bottom: 0;
            background-color: rgba(33, 40, 50, 0.03);
            border-bottom: 1px solid rgba(33, 40, 50, 0.125);
        }
        .form-control, .dataTable-input {
            display: block;
            width: 100%;
            padding: 0.875rem 1.125rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1;
            color: #69707a;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #c5ccd6;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.35rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .nav-borders .nav-link.active {
            color: #0061f2;
            border-bottom-color: #0061f2;
        }
        .nav-borders .nav-link {
            color: #69707a;
            border-bottom-width: 0.125rem;
            border-bottom-style: solid;
            border-bottom-color: transparent;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            padding-left: 0;
            padding-right: 0;
            margin-left: 1rem;
            margin-right: 1rem;
        }
    </style>
</head>
<body>
    <?php $this->load->view('components/sidebar_karyawan');?>
    <div class="d-flex align-items-center">
    <div class="container">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                <?php if (isset($user)) : ?>
                    <img class="img-account-profile rounded-circle mb-2" src="<?php echo base_url('images/karyawan/' . $user->image); ?>" alt="Profile Picture">
                <?php endif; ?>
                    <form action="<?php echo base_url('karyawan/aksi_ubah_foto')?>" method="post" class="row" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input class="form-control" type="file" name="image" id="image" accept="image/*">
                        </div>
                        <button class="btn btn-dark" type="submit">Upload new image</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form action="<?php echo base_url('karyawan/aksi_ubah_akun')?>" method="post" class="row" enctype="multipart/form-data">
                        <div class="mb-1">
                            <span>Username</span>
                            <input type="text" class="form-control" value="<?php echo $user->username?>" id="username" name="username">
                        </div>
                        <div class="mb-1">
                            <span>Email</span>
                            <input type="text" value="<?php echo $user->email ?>" class="form-control" id="email" name="email">
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-1">
                            <!-- Form Group (first name)-->
                            <div class="col-md-6">
                                <span>Nama Depan</span>
                                <input type="text" class="form-control" value="<?php echo $user->first_name?>" id="first_name" name="first_name">
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                                <span>Nama Belakang</span>
                                <input type="text" class="form-control" value="<?php echo $user->last_name?>" id="last_name" name="last_name">
                            </div>
                        </div>
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-1">
                            <div class="col-md-12">
                                <span>Password Lama</span>
                                <input type="text" placeholder="Password Lama" class="form-control" id="password_lama" name="password_lama">
                            </div>
                        </div>
                        <div class="row gx-3 mb-1">
                            <div class="col-md-6">
                                <span>Password Baru</span>
                                <input type="text" placeholder="Password Baru" class="form-control" id="password_baru" name="password_baru">
                            </div>
                            <!-- Form Group (location)-->
                            <div class="col-md-6">
                                <span>Password Konfirmasi</span>
                                <input type="text" placeholder="Konfirmasi Password" class="form-control" id="konfirmasi_password" name="konfirmasi_password">
                            </div>
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-dark" type="submit">Save changes</button>
                    </form>
                </div>
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
</body> 
</html>
