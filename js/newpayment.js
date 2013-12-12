$(document).ready(function(){
	$("#back").click(goBack); // Return to frontpage.
	$("#ok").click(addPayment); // Add new payment.
});

function goBack()
{
	window.location = "http://users.metropolia.fi/~petrior/mobiiliohjelmointi/app/frontpage.php";
}

function addPayment() // Add new payment to database.
{
	// Use ajax to connect to server.php.
	$.ajax({
				type: "POST",
				url: "server/server.php",
				data: { paymentName: $("#paymentName").val(), // Send the value from payment name input field.
						paymentValue: $("#paymentValue").val()} // Send the value from payment value input field.
			}).done(function(msg) // When server returns message...
					{
							$("#messages").text(msg); // Insert message to #messages element.
							// Empty input fields.
							$('#paymentValue').val('');
							$('#paymentName').val('');
					});
}