<?php
	session_start();
	session_destroy();
	header('location: /intranet.egetra/trombinoscope/index.php');
	exit;
?>