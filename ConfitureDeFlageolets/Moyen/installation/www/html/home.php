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
</head>

<body class="bg-gradient">
    <nav id="nav" class="fixed-top navbar navbar-expand-lg navbar-dark" style="transition: background-color 0.2s ease;">
        <div class="container-fluid px-3">
            <a class="navbar-brand" href="/?p=home"><u class="px-1">RockIt</u> Festival</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#lineup">Line Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sponsors">Sponsors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/?p=tickets">Tickets</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <section id="hero">
        <div class="container-fluid h-100">
            <div class="row h-100 overlay-dark text-center">
                <div id="button-discover-overlay" class="overlay-dark-gradient opacity-0"></div>
                <div class="my-auto mx-auto w-auto container">
                    <h1 class="text-center text-s1">Let's <u class="px-2 align-middle" style="font-size: calc(2rem + 3vw);">RockIt</u></h1>
                    <div class="row">
                        <div class="col"></div>
                        <h2 class="col-auto gx-1 text-s2">2022</h2>
                        <div class="col-auto d-flex flex-column text-start gx-0">
                            <div class="col"></div>
                            <h3 class="text-s3">JULY</h3>
                            <h4 class="text-s4">10/12/13</h4>
                            <div class="col"></div>
                        </div>
                        <div class="col"></div>
                    </div>

                    <a id="buy" class="hero-button home-tickets-button" href="/?p=tickets">
                        <img src="static/assets/ticket.svg" width="55" style="margin-right: 15px;">
                        BUY TICKETS
                    </a>
                </div>
                <button id="button-discover" class="nav-link" href="#lineup" type="button">
                    <svg class="icon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-double-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path fill="currentColor" d="M143 256.3L7 120.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0L313 86.3c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.4 9.5-24.6 9.5-34 .1zm34 192l136-136c9.4-9.4 9.4-24.6 0-33.9l-22.6-22.6c-9.4-9.4-24.6-9.4-33.9 0L160 352.1l-96.4-96.4c-9.4-9.4-24.6-9.4-33.9 0L7 278.3c-9.4 9.4-9.4 24.6 0 33.9l136 136c9.4 9.5 24.6 9.5 34 .1z" class=""></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <section id="lineup"class="container-fluid py-3">
        <div class="row justify-content-center">
            <h1 class="display-1 col-10">Line Up</h1>
            <div class="card col-7 p-2">
                <img class="img-fluid" src="static/assets/lineup.bmp"/>
            </div>
        </div>
    </section>

    <section id="sponsors" class="container-fluid py-3 h-100">
        <div class="row justify-content-center">
            <h1 class="display-1 col-10">Sponsors</h1>
            <div class="row justify-content-center col-8">

                <?php

                $files = scandir('sponsors');

                foreach ($files as &$name) {
                    if ($name !== "." and $name !== ".." and $name !== "index.php") {
                        $path = 'sponsors/'.$name;
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $img = file_get_contents('sponsors/' . $name);
                        $b64 = base64_encode($img);
                        $data = "data:image/".$type.";base64, ".$b64;

                        echo "<div class=\"col-md-2\">\n<div class=\"card m-1 p-1 popup\">\n<img class=\"card-img-top rounded\" src=\"" . $data . "\">\n</div>\n</div>\n";
                    }
                }

                ?>

            </div>
        </div>
    </section>

    <section id="footer" class="container-fluid d-flex flex-column-reverse p-0">
        <div class="p-4 container-fluid bg-black">
            © Copyright 2021 - RockIt Festival
        </div>
    </section>


    <script src="static/js/jquery.js"></script>
    <script src="static/js/bootstrap.js"></script>
    <script src="static/js/custom.js"></script>

</body>

</html>