<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./profile.css" />
    <title>Tugas Bintang/profile</title>
    <style>
        .card {
            position: relative;
            width: 350px;
            height: 190px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 35px 80px rgba(0, 0, 0, 0.15);
            transition: 0.5s;
        }

        .card:hover {
            height: 450px;
        }

        .imgBx {
            position: absolute;
            left: 50%;
            top: -50px;
            transform: translateX(-50%);
            width: 150px;
            height: 150px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.35);
            overflow: hidden;
            transition: 0.5s;
        }

        .card:hover .imgBx {
            width: 250px;
            height: 250px;
        }

        .imgBx img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card .content {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            overflow: hidden;
        }

        .card .content .details {
            padding: 40px;
            text-align: center;
            width: 100%;
            transition: 0.5s;
            transform: translateY(150px);
        }

        .card:hover .content .details {
            transform: translateY(0px);
        }

        .card .content .details h2 {
            font-size: 1.25em;
            font-weight: 600;
            color: #555;
            line-height: 1.2em;
        }

        .card .content .details h2 span {
            font-size: 0.75em;
            font-weight: 500;
            opacity: 0.5;
        }

        .card .content .details .data {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        .card .content .details .data h3 {
            font-size: 1em;
            color: #555;
            line-height: 1.2em;
            font-weight: 600;
        }

        .card .content .details .data h3 span {
            font-size: 0.85em;
            font-weight: 400;
            opacity: 0.5;
        }

        .card .content .details .actionBtn {
            display: flex;
            justify-content: space-between;
            /* gap: 20px; */
        }

        .card .content .details .actionBtn button {
            padding: 10px 30px;
            border-radius: 5px;
            border: none;
            outline: none;
            font-size: 1em;
            font-weight: 500;
            background: black;
            color: #fff;
            cursor: pointer;
        }

        .card .content .details .actionBtn button:nth-child(2) {
            border: 1px solid #999;
            color: #999;
            background: #fff;


        }

        /* tombol kembali */
        .menuback {
            color: white;
            display: flex;
            padding-left: 20px;
            padding-top: 20px;
            background: linear-gradient(45deg, #4B8673, #4fa88c);
        }

        .menuback a {
            text-decoration: none;
            color: white;
        }

        a:hover {
            color: rgb(224, 224, 224);
        }

    </style>
  </head>
  <body>
  <?php $this->load->view('components/sidebar_karyawan'); ?>
    <div class="container">
        <div class="row justify-content-center align-self-center">
            <div class="card col-md-6">
                <div class="imgBx">
                <img src="./img/profile.png" />
                </div>
                <div class="content">
                <div class="details">
                    <h2>James Tukang Bond <br /><span>SMPN 1 Semarang</span></h2>
                    <div class="data">
                    <h3>342 <br /><span>Posts</span></h3>
                    <h3>120K <br /><span>Followers</span></h3>
                    <h3>285 <br /><span>Following</span></h3>
                    </div>
                    <div class="actionBtn">
                    <button>Follow</button>
                    <button>Message</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>
