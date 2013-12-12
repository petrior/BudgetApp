$(document).ready(function(){
	$("#back").click(goBack); // Return to budget.php.
	$("#ok").click(addBudget); // Add new budget.
});

function goBack()
{
	window.location = "http://users.metropolia.fi/~petrior/mobiiliohjelmointi/app/budget.php";
}

function addBudget() // Add new budget to the database.
{
	// Use ajax to connect to server.php.
	$.ajax({
				type: "POST",
				url: "server/server.php",
				data: { budgetName: $("#budgetName").val(), // Send budget name input value to server.php.
						budgetValue: $("#budgetValue").val()} // Send budget value input value to server.php.
			}).done(function(msg) // When server returns message...
					{
						if(msg == "Budget added!") // If message is this...
							window.location = "http://users.metropolia.fi/~petrior/mobiiliohjelmointi/app/budget.php"; // Redirect.
						else
							$("#messages").text(msg); // Else insert message to #messages element.
					});
}