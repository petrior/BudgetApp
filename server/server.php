<?php
	function startSession($username)
	{
		session_start(); // Start the session.
		$_SESSION['loggedIn'] = true; // Set loggedIn to true.
		$_SESSION['user'] = $username; // Save username to session.
	}
	
	function checkLoginStatus() // Check if user is logged in.
	{
		// If not logged in, redirect to login page.
		if(!$_SESSION['loggedIn'])
		{
			header("Location: login.html");
			exit();
		}
	}
	
	// If username and password are valid, add new user to the database.
	function registerUser()
	{
		// Get variables from POST.
		$username = $_POST['registerUsername']; 
		$password = $_POST['registerPassword'];
		
		// If empty, exit with message.
		if($username == NULL) exit("You must enter a username!");
		if($password == NULL) exit("You must enter a password!");
		
		// Start connection to MySQL database.
		$con=mysqli_connect("mysql.metropolia.fi","petrior","********","petrior");
		// Check connection
		if (mysqli_connect_errno())
		{
			mysqli_close($con); // Close connection to MySQL server.
			exit("Failed to connect to MySQL: " . mysqli_connect_error());
		}
		
		// MySQL command.
		// Select users from USERS table.
		$sql = "SELECT USERNAME FROM USERS";
		
		$con->set_charset("utf8"); //Set encoding to utf-8.
		
		// Save mysql object to $table.
		$table = mysqli_query($con, $sql);
		// Loop through mysql objects arrays.
		while($r = mysqli_fetch_array($table))
		{
			// If username already exists, exit with error message.
			if($username == $r['USERNAME'])
			{
				mysqli_close($con); // Close connection to MySQL server.
				exit($username . " is already in use.");
			}
		}
		
		// Insert new user to database.
		$sql = "INSERT INTO USERS(USERNAME, PASSWORD) VALUES ('" . $username . "', '" . $password . "');";
		
		// Run query and check if it fails.
		if(!mysqli_query($con, $sql))
		{
			mysqli_close($con);
			exit("Error inserting data to table.");	
		} else
		{
			mysqli_close($con);
			exit("Register succesful!");
		}
	}
	
	function logIn()
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		// Check if user has typed something.
		if($username == NULL) exit("You must enter a username!");
		if($password == NULL) exit("You must enter a password!");
		
		$con=mysqli_connect("mysql.metropolia.fi","petrior","********","petrior");
		// Check connection
		if (mysqli_connect_errno())
		{
			exit("Failed to connect to MySQL" . mysqli_connect_error());
		}
		
		// Select users and passwords from mysql.
		$sql = "SELECT USERNAME, PASSWORD FROM USERS";
		
		$con->set_charset("utf8"); //Set encoding to utf-8.
		
		$table = mysqli_query($con, $sql);
		
		$loginSuccess = false;
		
		// Check if username and password are valid.
		while($r = mysqli_fetch_array($table))
			{
				if($r['USERNAME'] == $username && $r['PASSWORD'] == $password)
					$loginSuccess = true;
			}
		
		// If valid, start session, else send error message.
		if($loginSuccess)
		{
			startSession($username);
			exit("Login succesful!");
		}
		else
		{
			exit("Wrong username or password!");
		}
	}
	
	function addBudget()
	{
		session_start();
		$name = $_POST['budgetName'];
		$value = $_POST['budgetValue'];
		
		// Check validity.
		if($name == NULL) exit("You must enter Budget Name!");
		if($value == NULL) exit("You must enter a value!");
		if($value == 0) exit("Budget value cannot be zero!");
		if($value < 0) exit("Budget value cannot be less than zero!");
		if($value > 99999999.99) exit("Value cannot exceed 99999999.99!");
		if(!is_numeric($value)) exit("Value must be integer or float.");

		$con=mysqli_connect("mysql.metropolia.fi","petrior","********","petrior");
		// Check connection
		if (mysqli_connect_errno())
		{
			exit("Failed to connect to MySQL" . mysqli_connect_error());
		}
		
		// Insert new budget to database.
		$sql = "INSERT INTO BUDGETS(BNAME, BVALUE, USERNAME) VALUES('" . $name . "', '" . $value . "', '" . $_SESSION['user'] . "')";
		
		$con->set_charset("utf8"); //Set encoding to utf-8.
		
		// Make the query and check if it was succesful.
		if(!mysqli_query($con, $sql))
		{
			mysqli_close($con);
			exit("Error inserting data to MySQL");
		} else
		{
			mysqli_close($con);
			exit("Budget added!");
		}
	}
	
	function getBudgets()
	{
		session_start();
		$con=mysqli_connect("mysql.metropolia.fi","petrior","********","petrior");
		// Check connection
		if (mysqli_connect_errno())
		{
			exit("Failed to connect to MySQL: " . mysqli_connect_error());
		}
		
		// Select users budgets.
		$sql = "SELECT BID, BNAME FROM BUDGETS WHERE BUDGETS.USERNAME = '" . $_SESSION['user'] . "';";
		
		$con->set_charset("utf8"); //Set encoding to utf-8.
		
		$rows = array();
		$table = mysqli_query($con, $sql);
		// Save mysql rows to array variable.
		while($r = mysqli_fetch_array($table))
		{
			$rows[] = array("bid" => $r['BID'], "bname" => $r['BNAME']);
		}
		
		mysqli_close($con);
		exit(json_encode($rows)); // Send rows array as json string.
	}
	
	function selectBudget()
	{
		session_start();
		$id = $_POST['budgetId'];
		
		$con=mysqli_connect("mysql.metropolia.fi","petrior","********","petrior");
		// Check connection
		if (mysqli_connect_errno())
		{
			exit("Failed to connect to MySQL: " . mysqli_connect_error());
		}
		
		// Change default budget of the user.
		$sql = "UPDATE USERS SET DBUDGET=" . $id . " WHERE USERNAME = '" . $_SESSION['user'] . "';";
		
		$con->set_charset("utf8"); //Set encoding to utf-8.
		
		mysqli_query($con, $sql);
		mysqli_close($con);
	}
	
	function getHeader()
	{
		session_start();
		
		$con=mysqli_connect("mysql.metropolia.fi","petrior","********","petrior");
		// Check connection
		if (mysqli_connect_errno())
		{
			exit("Failed to connect to MySQL: " . mysqli_connect_error());
		}
		
		// Get the name of selected budget.
		$sql = "SELECT BNAME FROM BUDGETS, USERS WHERE BUDGETS.BID=USERS.DBUDGET AND USERS.USERNAME = '" . $_SESSION['user'] . "';";
		
		$con->set_charset("utf8"); //Set encoding to utf-8.
		
		// Save budget name as string.
		$msg = "";
		$table = mysqli_query($con, $sql);
		while($r = mysqli_fetch_array($table))
			{
				$msg = $r['BNAME'];
			}
		
		mysqli_close($con);
		exit($msg); // Send budget name as message.
	}
	
	function deleteBudget()
	{
		session_start();
		$id = $_POST['budgetDeleteId'];
		
		$con=mysqli_connect("mysql.metropolia.fi","petrior","********","petrior");
		// Check connection
		if (mysqli_connect_errno())
		{
			exit("Failed to connect to MySQL: " . mysqli_connect_error());
		}
		// Delete payments of the budget first.
		$sql = "DELETE FROM PURCHASES WHERE PURCHASES.BID=" . $id . ";";
		
		$con->set_charset("utf8"); //Set encoding to utf-8.
		
		mysqli_query($con, $sql);	
		
		// Delete the budget.
		$sql = "DELETE FROM BUDGETS WHERE BUDGETS.BID=" . $id . ";";
		
		mysqli_query($con, $sql);	
		mysqli_close($con);
		exit($msg);
	}
	
	function addPayment()
	{
		session_start();
		$name = $_POST['paymentName'];
		$value = $_POST['paymentValue'];
		
		// Check validity.
		if($name == NULL) exit("You must enter Payment Name!");
		if($value == NULL) exit("You must enter a value!");
		if(!is_numeric($value)) exit("Value must be integer or float.");
		if($value == 0 || $value < 0) exit("Value must be greater than zero!");
		if($value > 99999999.99) exit("Value cannot exceed 99999999.99!");

		$con=mysqli_connect("mysql.metropolia.fi","petrior","********","petrior");
		// Check connection
		if (mysqli_connect_errno())
		{
			exit("Failed to connect to MySQL" . mysqli_connect_error());
		}
		
		// Add payment to database.
		$sql = "INSERT INTO PURCHASES(PNAME, PVALUE, BID) VALUES('" . $name . "', '" . $value . "', (SELECT DBUDGET FROM USERS WHERE USERS.USERNAME='" . $_SESSION['user'] . "'))";
		
		$con->set_charset("utf8"); //Set encoding to utf-8.
		
		// Make the query and check if it fails.
		if(!mysqli_query($con, $sql))
		{
			mysqli_close($con);
			exit("Error inserting data to MySQL");
		} else
		{
			mysqli_close($con);
			exit("Payment added!");
		}
	}
	
	function getInfo()
	{
		session_start();
		$con=mysqli_connect("mysql.metropolia.fi","petrior","********","petrior");
		// Check connection
		if (mysqli_connect_errno())
		{
			exit("Failed to connect to MySQL: " . mysqli_connect_error());
		}
		
		// Select value of the current budget.
		$sql = "SELECT BVALUE FROM BUDGETS, USERS WHERE USERS.DBUDGET=BUDGETS.BID AND USERS.USERNAME='" . $_SESSION['user'] . "';";
		
		$con->set_charset("utf8"); //Set encoding to utf-8.
		
		// Save the budget value to variable.
		$budgetValue = 0;
		$table = mysqli_query($con, $sql);
		
		while($r = mysqli_fetch_array($table))
		{
			$budgetValue = $r['BVALUE'];
		}
		
		// Select payments.
		$sql = "SELECT PID, PNAME, PVALUE FROM PURCHASES WHERE PURCHASES.BID=(SELECT DBUDGET FROM USERS WHERE USERS.USERNAME='" . $_SESSION['user'] . "');";
		
		// Save the mysql rows to array.
		$rows = array();
		$table = mysqli_query($con, $sql);
		
		while($r = mysqli_fetch_array($table))
		{
			$rows[] = array("pid" => $r['PID'], "pname" => $r['PNAME'], "pvalue" => $r['PVALUE']);
		}
		
		array_unshift($rows, $budgetValue); // Add the budget value in front of the array.
		
		mysqli_close($con);
		exit(json_encode($rows)); // Send the array as json string.
	}
	
	function deletePayment()
	{
		session_start();
		$id = $_POST['deletePayment'];
		
		$con=mysqli_connect("mysql.metropolia.fi","petrior","********","petrior");
		// Check connection
		if (mysqli_connect_errno())
		{
			exit("Failed to connect to MySQL: " . mysqli_connect_error());
		}
		
		// Delete the purchase using id number.
		$sql = "DELETE FROM PURCHASES WHERE PURCHASES.PID=" . $id . ";";
		
		$con->set_charset("utf8"); //Set encoding to utf-8.
		
		mysqli_query($con, $sql);	
		mysqli_close($con);
		exit($msg);
	}
	
	/*
	 * Issets are used to call appropriate function.
	 */
	if(isset($_POST['loggedIn']))
		checkLoginStatus();
	
	if(isset($_POST['registerUsername']) && isset($_POST['registerPassword']))
		registerUser();
		
	if(isset($_POST['username']) && isset($_POST['password']))
		logIn();
		
	if(isset($_POST['budgetName']) && isset($_POST['budgetValue']))
		addBudget();
		
	if(isset($_POST['paymentName']) && isset($_POST['paymentValue']))
		addPayment();
		
	if(isset($_POST['getBudgets']))
		getBudgets();
		
	if(isset($_POST['budgetId']))
		selectBudget();
		
	if(isset($_POST['getHeader']))
		getHeader();
		
	if(isset($_POST['budgetDeleteId']))
		deleteBudget();
		
	if(isset($_POST['getInfo']))
		getInfo();
		
	if(isset($_POST['deletePayment']))
		deletePayment();
?>