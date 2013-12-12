<!DOCTYPE html>
<?php
	session_start(); // Start the session.
?>
<html>
	<head>
		<title>Budget - Create new Budget</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<script src="js/jquery-2.0.3.min.js"></script>
		<script src="js/newbudget.js"></script>
		<link href="style/budget.css" type="text/css" rel="stylesheet">
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h1>New Budget</h1>
				<hr>
			</div>
			<div id="inputfields">
				<p>Budget Name</p>
				<input class="typeinput" name="budgetName" id="budgetName"></input>
				<p>Budget Value</p>
				<input type="text" class="typeinput" name="budgetValue" id="budgetValue"></input><br>
				<p id="messages"></p>
				<button id="ok" class="button">OK</button><br>
				<button id="back" class="button">Back</button><br>
				<?php
				include_once("server/server.php");
				checkLoginStatus(); // Redirect to login page if not logged in.
				?>
			</div>
		</div>
	</body>
</html>