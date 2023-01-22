<?php

session_start();
if (isset($_SESSION['ticket']) and isset($_SESSION['name'])) {
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$_SESSION['name']);
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	// header('Content-Length: ' . );
	echo $_SESSION['ticket'];
	exit();
} else {
	header("Location: /?p=tickets");
	exit();
}


?>
