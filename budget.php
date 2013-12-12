<!DOCTYPE html>
<?php
	session_start(); // Start the session.
?>
<html>
	<head>
		<title>Budget - Budgets</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<script src="js/jquery-2.0.3.min.js"></script>
		<script src="js/budget.js"></script>
		<link href="style/budget.css" type="text/css" rel="stylesheet">
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h1>Budgets</h1>
				<hr>
				<h3 id="bname"></h3>
			</div>
			<div id="inputfields">
				<button id="newBudget" class="button">New Budget</button><br>
				<button id="back" class="button">Back</button><br>
				<table id="budgetList">
				</table>
			</div>
		</div>

		<?php
			include_once("server/server.php");
			checkLoginStatus(); // Redirect to login page if not logged in.
		?>
	</body>
</html>