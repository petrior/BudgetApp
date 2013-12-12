$(document).ready(function(){
	$("#register").click(register); // Goto register page.
	$("#login").click(login); // Login.
});

function register() // Just a redirect.
{
	window.location = "http://users.metropolia.fi/~petrior/mobiiliohjelmointi/app/register.html";
}

function login() // Connect to server and check if username and password is correct.
{
	// Use ajax to connect to server.php.
	$.ajax({
				type: "POST",
				url: "server/server.php",
				data: { username: $("#username").val(), // Send username
						password: $("#password").val()} // and password to server.php.
			}).done(function(msg) // When server returns message...
					{
						if(msg == "Login succesful!") // If message is this...
						{
							window.location = "http://users.metropolia.fi/~petrior/mobiiliohjelmointi/app/frontpage.php"; // Redirect.
						} else
							$("#messages").text(msg); // Else insert (fail)message to #messages element.
					});
}