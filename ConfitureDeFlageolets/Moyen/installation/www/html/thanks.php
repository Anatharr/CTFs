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
		#thanks {
			height: 92vh !important;
			background: url("static/assets/hero.png");
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
			background-attachment: fixed;  
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

	<section id="thanks" class="container-fluid p-0">
		<div class="container-fluid overlay-dark h-100">
			<div class="row justify-content-center align-items-center h-100">
				<div class="col-7 text-center">
					<h1 class="display-1">Thank you</h1>
					<p class="mb-5 h4 font-weight-normal">
						We will see you soon to <u class="display-4 mx-2 text-primary font-weight-normal align-middle">RockIt</u>
					</p>
					<?php
					session_start();
					if (isset($_SESSION['ticket'])) {
						echo "<a href=\"/?p=download\" class=\"btn btn-success\">Download your ticket</a>";
					}
					?>
				</div>
			</div>
		</div>
	</section>
	<div class="p-4 fixed-bottom container-fluid bg-black">
		© Copyright 2021 - RockIt Festival
	</div>

	<script src="static/js/jquery.js"></script>
	<script src="static/js/bootstrap.js"></script>

</body>

</html>