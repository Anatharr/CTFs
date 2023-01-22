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
        .card {
            flex-direction: row;
            align-items: center;
            text-decoration: none !important;
        }
        .card img {
            width: 30%;
            /*height: 100%;*/
        }
        .card-body {
            width: 100%;
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

    <section id="tickets" class="container-fluid h-100 py-3">
        <div class="row justify-content-center">
            <h1 class="display-1 col-10">Buy tickets</h1>
            <div class="col-lg-12 row justify-content-center">
                <a href="/?p=buy&ticket=3days" class="card col-lg-4 m-2 popup">
                    <img class="card-img-top" src="static/assets/ticket-3days.svg">
                    <div class="card-body py-2">
                        <h4 class="card-title">Pass 3 days</h4>
                        <p class="card-text">
                            Friday 10, 10:00 - Sunday 12, 2:00
                        </p>
                    </div>
                    <div class="card-footer px-1">
                        <h5 class="mb-0">295,00€</h5>
                    </div>
                </a>
                <a href="/?p=buy&ticket=2days" class="card col-lg-4 m-2 popup">
                    <img class="card-img-top" src="static/assets/ticket-2days.svg">
                    <div class="card-body py-2">
                        <h4 class="card-title">Pass 2 days</h4>
                        <p class="card-text">
                            <b>Choose between :</b>
                            <br/>
                            Friday 10, 10:00 - Saturday 11, 2:00
                            <br/>
                            Saturday 11, 10:00 - Sunday 12, 2:00
                        </p>
                    </div>
                    <div class="card-footer px-1">
                        <h5 class="mb-0">198,00€</h5>
                    </div>
                </a>

                <a href="/?p=buy&ticket=fri10" class="card col-lg-4 m-2 popup">
                    <img class="card-img-top" src="static/assets/ticket-1day.svg">
                    <div class="card-body py-2">
                        <h4 class="card-title">Friday 10</h4>
                        <p class="card-text">
                            Kiss • Iron Maiden • System Of A Down • Scorpions • Def Leppard • Airbourne • Rise Against • Avenged Sevenfold

                        </p>
                    </div>
                    <div class="card-footer px-1">
                        <h5 class="mb-0">105,00€</h5>
                    </div>
                </a>

                <a href="/?p=buy&ticket=sat11" class="card col-lg-4 m-2 popup">
                    <img class="card-img-top" src="static/assets/ticket-1day.svg">
                    <div class="card-body py-2">
                        <h4 class="card-title">Saturday 11</h4>
                        <p class="card-text">
                            Europe • Guns N'Roses • Metallica • Sum 41 • Alice Cooper • Korn • Prophets of Rage • Deftones • Foo Fighters
                        </p>
                    </div>
                    <div class="card-footer px-1">
                        <h5 class="mb-0">105,00€</h5>
                    </div>
                </a>

                <a href="/?p=buy&ticket=sun12" class="card col-lg-4 m-2 popup">
                    <img class="card-img-top" src="static/assets/ticket-1day.svg">
                    <div class="card-body py-2">
                        <h4 class="card-title">Sunday 12</h4>
                        <p class="card-text">
                            Royal Blood • Megadeth • AC/DC • Billy Talent • Green Day • Blink 182 • Deep Purple • Incubus
                        </p>
                    </div>
                    <div class="card-footer px-1">
                        <h5 class="mb-0">105,00€</h5>
                    </div>
                </a>
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

</body>

</html>