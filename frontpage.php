<!DOCTYPE html>
<?php
	session_start(); // Start the session.
?>
<html>
	<head>
		<title>Budget - Frontpage</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<script src="js/jquery-2.0.3.min.js"></script>
		<script src="js/frontpage.js"></script>
		<link href="style/budget.css" type="text/css" rel="stylesheet">
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h1>BudgetApp</h1>
				<hr>
				<h3 id="bname"></h3>
			</div>
			<div id="inputfields">
				<h3 id="budgetRemaining"></h3>
				<h4 id="budgetValue"></h4>
				<table id="currentBudget">
				</table>
				<button id="newPayment" class="button">New Payment</button><br>
				<button id="selectBudget" class="button">Select Budget</button><br>
				<form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST">
					<button id="logout" name="logout" class="button">Logout</button>
				</form>
				<p class="lol">Logged in as: <?php echo($_SESSION['user']); // Get username from session. ?></p>
			</div>
		</div>

		<?php
			include_once("server/server.php");
			checkLoginStatus(); // Redirect to login page if not logged in.
			
			if(isset($_POST['logout'])) // If user wants to logout...
			{
				session_destroy(); // Destroy current session.
				header("Location: login.html"); // Redirect to login.html.
			}
		?>
	</body>
</html>