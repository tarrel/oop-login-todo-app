<html>
	<head>
		<title>WipeOut - Agjenda ne doren tuaj ne cdo kohe.</title>
		<meta charset="utf-8">

		<!-- JQuery -->
		<script type="text/javascript" src="lib/jquery/jquery.min.js"></script>

		<!-- Stilizimi me bootstrap -->
		<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">

		<!-- Bootstrap min.js -->
		<script type="text/javascript" src="lib/bootstrap/js/bootstrap.min.js"></script>

		<!-- Stilizimi personal -->
		<link rel="stylesheet" href="css/todo.css" type="text/css">

	</head>
	<body>


		<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  		<h1 class="navbar-brand mb-0">WipeOut</h1>
  		<a href="index.php" class="mr-auto nav-item" style="text-decoration: none; color: inherit;">Axhenda</a>

			<span class="navbar-text">
				Pershendetje <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo ucfirst(escape($user->data()->username)); ?></a>
			</span>
		</nav>

		<div class="container">
