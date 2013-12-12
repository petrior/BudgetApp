$(document).ready(function(){
	$("#cancel").click(cancel); // Return to login page.
	$("#register").click(register); // Register.
});

function cancel() // Just a redirect.
{
	window.location = "http://users.metropolia.fi/~petrior/mobiiliohjelmointi/app/login.html";
}

function register() // Connect to server and check if username and password is valid.
{
	// Use ajax to connect to server.php.
	$.ajax({
				type: "POST",
				url: "server/server.php",
				data: { registerUsername: $("#registerUsername").val(), // Send username
						registerPassword: $("#registerPassword").val()} // and password to server.php.
			}).done(function(msg) // When server returns message...
					{
						if(msg == "Register succesful!") // If message is this...
						{
							$("#inputfields").html("<p>" + msg + " Redirecting to login page...<p>"); // Change #inputfields div html.
							// Redirect to login page after 3 seconds.
							window.setTimeout(function(){
								window.location = "http://users.metropolia.fi/~petrior/mobiiliohjelmointi/app/login.html";
							}, 3000);
						}
						else 
						$("#messages").text(msg); // If register was not succesful insert msg to #messages element.
					});
}

