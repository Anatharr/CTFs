<?php

$tickets_type = array("3days", "2days", "fri10", "sat11", "sun12");

if (empty($_GET['ticket']) or !in_array($_GET['ticket'], $tickets_type)) {
	header("Location: /?p=tickets");
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (empty($_POST['firstname']) or empty($_POST['lastname']) or empty($_POST['email']) or empty($_POST['ccnumber']) or empty($_POST['ccexp']) or empty($_POST['cvv'])) {
		$message = "Please fill out every field of the form";
	} else {
		$timestamp = date('d-m-y_H-i-s');

		switch ($_GET['ticket']) {
			case '3days':
			$ticket = "3 Days Pass";
			$price = "295.00 €";
			break;
			case '2days':
			$ticket = "2 Days Pass";
			$price = "198.00 €";
			break;
			case 'fri10':
			$ticket = "1 Day Pass, Friday 10 July";
			$price = "105.00 €";
			break;
			case 'sat11':
			$ticket = "1 Day Pass, Saturday 11 July";
			$price = "105.00 €";
			break;
			case 'sun12':
			$ticket = "1 Day Pass, Sunday 12 July";
			$price = "105.00 €";
			break;
			default:
			$ticket = "Unknown";
			$price = "000.00 €";
			break;
		}

		$path = '/var/www/receipts/' . $timestamp . '.txt';

		$receipt  = "╓──────── Receipt n°".$timestamp." ─────────\n";
		$receipt .= "║ Date: ".date('l, F jS y')."\n";
		$receipt .= "║ \n";
		$receipt .= "║ Store: RockIT Festival\n";
		$receipt .= "║ Adress: \n";
		$receipt .= "║ Email: contact@rock.it\n";
		$receipt .= "║ \n";
		$receipt .= "║ Client: ".$_POST['firstname']." ".$_POST['lastname']."\n";
		$receipt .= "║ Email: ".$_POST['email']."\n";
		$receipt .= "║ \n";
		$receipt .= "║ Ticket: ".$ticket."\n";
		$receipt .= "║ Price: ".$price."\n";
		$receipt .= "║                                               ║\n";
		$receipt .= "║                                               ║\n";
		$receipt .= "║                                               ║\n";
		$receipt .= "║                                               ║\n";
		$receipt .= "║           █▀▀▀▀▀█ ▀▀      █ █▀▀▀▀▀█           ║\n";
		$receipt .= "║           █ ███ █ █▄ ██▀▄▀  █ ███ █           ║\n";
		$receipt .= "║           █ ▀▀▀ █ ▀█▀▀▄▄ ▀  █ ▀▀▀ █           ║\n";
		$receipt .= "║           ▀▀▀▀▀▀▀ ▀▄▀▄▀ ▀ █ ▀▀▀▀▀▀▀           ║\n";
		$receipt .= "║           ▀▀▀▀▄ ▀▄▀▄  ▀ █ █▀ ▄▀▀▀▄▀           ║\n";
		$receipt .= "║            ████ ▀█   █▀█▄▄▄▄███▄▄             ║\n";
		$receipt .= "║             ▀ ▄█▀ ▄█▄ █▀ █▄▀███ ▀▀█           ║\n";
		$receipt .= "║           ▄▀▄█▄ ▀▀▄▄  ▄▀▀ ██▄▄█ ▀▀▄           ║\n";
		$receipt .= "║              ▀▀▀▀ ▄█  ██▄▀█▀▀▀█▀█▀█           ║\n";
		$receipt .= "║           █▀▀▀▀▀█   ▄ ▄▀▀ █ ▀ █ ▀█▀           ║\n";
		$receipt .= "║           █ ███ █ ▄█▀▄ ▄▄ ▀██▀██▄██           ║\n";
		$receipt .= "║           █ ▀▀▀ █ █  ██▄██ ▄▀ █ █▀            ║\n";
		$receipt .= "║           ▀▀▀▀▀▀▀ ▀▀▀   ▀   ▀▀▀▀▀▀▀           ║\n";
		$receipt .= "║                                               ║\n";
		$receipt .= "║                                               ║\n";
		$receipt .= "║                                               ║\n";
		$receipt .= "╙───────────────────────────────────────────────╜\n";

		file_put_contents($path, $receipt);

		session_start();
		$_SESSION['ticket'] = $receipt;
		$_SESSION['name'] = $timestamp.".txt";

		header("Location: /?p=thanks");
		exit();
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
		#tickets .card {
			flex-direction: row;
			align-items: center;
			text-decoration: none !important;
		}
		#tickets .card img {
			width: 30%;
			/*height: 100%;*/
		}
		#tickets .card-body {
			width: 100%;
		}
		#form, #tickets {
			height: 100% !important;
			background: url("static/assets/hero.png");
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
			background-attachment: fixed;  
		}
		#footer {
			height: 100% !important;
		}
		.overlay-dark {
			background-color: rgba(0, 0, 0, 0.6);
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

	<section id="tickets" class="container-fluid px-0 h-100">
		<div class="container-fluid overlay-dark py-3 h-100">

			<div class="row justify-content-center">
				<h1 class="display-1 col-10">Buy tickets</h1>
				<div class="col-lg-11 row justify-content-center">


					<?php switch($_GET['ticket']):
						case "3days": ?>
						<div class="card col-lg-4 m-2 py-2">
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

						</div>
						<?php break; ?>
						<?php case "2days": ?>
						<div class="card col-lg-4 m-2 py-2">
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

						</div>
						<?php break; ?>
						<?php case "fri10": ?>
						<div class="card col-lg-4 m-2 py-2">
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
						</div>
						<?php break; ?>
						<?php case "sat11": ?>
						<div class="card col-lg-4 m-2 py-2">
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
						</div>
						<?php break; ?>
						<?php case "sun12": ?>
						<div class="card col-lg-4 m-2 py-2">
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
						</div>
						<?php break; ?>
					<?php endswitch; ?>
				</div>
			</div>
		</div>
	</section>

	<section id="form" class="container-fluid p-0">
		<div class="container-fluid overlay-dark px-5 h-100" style="padding-bottom: 5rem;">
			<form class="card" method="post" action="/?p=buy&ticket=<?=$_GET['ticket']?>">
				<div class="card-body">
					<div class="row py-1">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="firstname text-dark">First Name</label>
								<input class="form-control" autocomplete="off" id="firstname" name="firstname" type="text" placeholder="Enter your first name">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="lastname">Last Name</label>
								<input class="form-control" autocomplete="off" id="lastname" name="lastname" type="text" placeholder="Enter your last name">
							</div>
						</div>
					</div>
					<div class="row py-1">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="email">Email</label>
								<input class="form-control" autocomplete="email" id="email" name="email" type="email" placeholder="Enter your email">
							</div>
						</div>
					</div>
					<div class="row py-1">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="ccnumber">Credit Card Number</label>
								<div class="input-group">
									<input class="form-control" id="ccnumber" name="ccnumber" type="text" readonly value="0000 0000 0000 0000">
									<div class="input-group-append bg-transparent">
										<span class="input-group-text">
											<svg style="width:24px;height:24px;" viewBox="0 0 24 24">
												<path fill="#DDD" d="M20 4H4A2 2 0 0 0 2 6V18A2 2 0 0 0 4 20H20A2 2 0 0 0 22 18V6A2 2 0 0 0 20 4M20 11H4V8H20Z"></path>
											</svg>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row py-1">
						<div class="form-group col-sm-8">
							<label for="ccexp">Expiration</label>
							<input class="form-control" id="ccexp" name="ccexp" type="text" readonly value="00/00">
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label for="cvv">CVV/CVC</label>
								<input class="form-control" id="cvv" name="cvv" type="text" readonly value="000">
							</div>
						</div>
					</div>
				</div>

				<div class="card-footer row justify-content-end">
					<?php if (isset($message)): ?>
						<div class="alert col-5 mb-0 py-1">
							<span class="closebtn">&times;</span> 
							<?=$message?>
						</div>
						<div class="col-2"></div>
					<?php endif ?>

					<button class="btn btn-success col-5 py-1" type="submit">Buy</button>
				</div>
			</form>
		</div>
	</section>


	<section id="footer" class="container-fluid d-flex flex-column-reverse p-0">
		<div class="p-4 container-fluid bg-black">
			© Copyright 2021 - RockIt Festival
		</div>
	</section>

	<script src="static/js/jquery.js"></script>
	<script src="static/js/bootstrap.js"></script>
	<script type="text/javascript">
		$(".closebtn").click(function () {
			var div = this.parentElement;
			div.style.opacity = "0";
			setTimeout(function(){ div.style.display = "none"; }, 600);
		})
	</script>

</body>

</html>
