<?php

session_start();
require('config.php');

if (!(isset($_SESSION['user']) and $_SESSION['user'] == $user)) {
// User not connected //

    header("Location: /?p=login");
    exit();
}


if (isset($_POST['submit'])) {
    if ($_POST['submit'] == 'Upload' and file_exists($_FILES['sponsor']['tmp_name']) and is_uploaded_file($_FILES['sponsor']['tmp_name'])) {
        // New sponsor uploaded //

        $legit_types = array("image/jpeg", "image/png", "image/bmp");

        if (in_array($_FILES['sponsor']['type'], $legit_types)) {
            $img_name = $_FILES['sponsor']['name'];
            $upload_path = 'sponsors/' . substr(basename($_FILES['sponsor']['tmp_name']), 3, 5) . '.' . pathinfo($img_name, PATHINFO_EXTENSION);

            if (!file_exists($upload_path) and move_uploaded_file($_FILES['sponsor']['tmp_name'], $upload_path)) {
                $message = "File uploaded successfully.";
            } else {
                $message = "Error while uploading file.";
            }
        } else {
            $message = "Invalid file.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>RockIt Festival</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="static/assets/favicon.ico" />
    <link rel="stylesheet" href="static/css/bootstrap.css">
    <link rel="stylesheet" href="static/css/custom.css">

    <style type="text/css">
        #login {
            height: 92vh !important;
            background: url("/static/assets/banner.png");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-attachment: fixed;  
        }
        .alert {
            padding: 20px;
            background-color: #f44336;
            background-image: linear-gradient( 125deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.01) 50% );;
            color: white;
            opacity: 1;
            transition: opacity 0.5s;
        }
        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }
        .closebtn:hover {
            color: black;
        }
        input[type="file"] {
            display: none;
        }
        .custom-file-upload {
            cursor: pointer;
        }
    </style>

</head>

<body class="bg-gradient">
    <nav id="nav" class="navbar navbar-expand-lg navbar-dark bg-secondary" style="transition: background-color 0.2s ease;">
        <div class="container-fluid px-3">
            <a class="navbar-brand" href="/?p=home"><u class="px-1">RockIt</u> Festival</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/?p=home#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/?p=home#lineup">Line Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/?p=home#sponsors">Sponsors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/?p=tickets">Tickets</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <section id="login" class="container-fluid p-0">
        <div class="container-fluid justify-content-center overlay-dark h-100">
            <h1 class="display-1 pt-2 px-5">Admin Dashboard</h1>
            <div class="col-10 row justify-content-center w-100">
                <form class="card col-5 my-5" enctype="multipart/form-data" action="/?p=dashboard" method="post" name="upload">
                    <div class="card-body">
                        <h3 class="card-title">
                            Upload new sponsor
                        </h3>
                        <div class="border rounded row">
                            <label id="file-label" for="file-upload" class="custom-file-upload py-1 bg-transparent text-light rounded col-8">
                                <svg style="height: 1.5rem; width: 1.5rem;" role="img" viewBox="0 0 512 512" class="mx-2">
                                    <path fill="currentColor" d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z" class="">
                                    </path>
                                </svg>
                                Choose File
                            </label>
                            <input id="file-upload" name="sponsor" accept="image/png, image/jpeg, image/bmp" type="file"/>
                            <input type="submit" value="Upload" name="submit" class="btn btn-success py-1 col-4">
                        </div>
                    </div>
                    <?php if (!empty($message)): ?>
                        <div class="card-footer">
                            <?=$message?>
                        </div>
                    <?php endif ?>
                </form>

            </div>
        </div>
    </section>

    <div class="fixed-bottom container-fluid bg-black">
        © Copyright 2021 - RockIt Festival
    </div>


    <script src="static/js/jquery.js"></script>
    <script src="static/js/bootstrap.js"></script>
    <script type="text/javascript">
        $(".closebtn").click(function () {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function(){ div.style.display = "none"; }, 600);
        })

        $('input[type="file"]').change(function () {
            path = $(this).val()
            $('#file-label').html('<svg style="height: 1.5rem; width: 1.5rem;" role="img" viewBox="0 0 512 512" class="mx-2"><path fill="currentColor" d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z" class=""></path></svg>\n' + path.slice(path.lastIndexOf('\\')+1))
        })
    </script>


</body>

</html>
