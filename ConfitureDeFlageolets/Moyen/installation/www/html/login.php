<?php

session_start();
require('config.php');

$s_username = $_POST['username'];
$s_password = $_POST['password'];

if (isset($s_username) and isset($s_password) and is_string($s_username) and is_string($s_password)) {
	if (($user == $s_username) and (hash('sha256', $salt . $s_password) == $hash)) {
		$message = "Connected !";
		$_SESSION['user'] = $user;
		header("Location: /?p=dashboard");
	} else {
		$message = "Authentication error.";
		unset($_SESSION['user']);

	}
	sleep(2); // Slow down bruteforce for some monkeys out there
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
		<div class="container-fluid overlay-dark h-100">
			<div class="row justify-content-center align-items-center h-100">
				<div class="col-7 text-center">

					<form class="card px-3" method="post" action="/?p=login">
						<div class="card-body">
							<div class="row py-1">
								<div class="col-sm-6 form-group">
									<input class="form-control" autocomplete="off" id="username" name="username" type="text" placeholder="Username">
								</div>
								<div class="col-sm-6 form-group">
									<input class="form-control" autocomplete="off" id="password" name="password" type="password" placeholder="Password">
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

							<button class="btn btn-success col-5 py-1" type="submit">Login</button>
						</div>
					</form>
				</div>
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
	</script>
	

</body>

</html>