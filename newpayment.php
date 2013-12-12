<!DOCTYPE html>
<?php
	session_start(); // Start the session.
?>
<html>
	<head>
		<title>Budget - Create new Payment</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<script src="js/jquery-2.0.3.min.js"></script>
		<script src="js/newpayment.js"></script>
		<link href="style/budget.css" type="text/css" rel="stylesheet">
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h1>New Payment</h1>
				<hr>
			</div>
			<div id="inputfields">
				<p>Payment Name</p>
				<input class="typeinput" name="paymentName" id="paymentName"></input>
				<p>Payment Value</p>
				<input type="text" class="typeinput" name="paymentValue" id="paymentValue"></input><br>
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