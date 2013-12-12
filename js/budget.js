$(document).ready(function(){
	getHeader(); // Get budget name to header.
	getBudgets(); // List the users budgets on the page.
	$("#back").click(goBack); // Return to frontpage.
	$("#newBudget").click(newBudget); // Goto budget creation page.
});

function getHeader()
{
	// Use ajax to connect to server.php.
	$.ajax({
				type: "POST",
				url: "server/server.php",
				data: { getHeader: "getHeader" } // Dummy variable to read isset in server.php.
			}).done(function(msg) // When server returns message...
					{
						$("#bname").text(msg); // Insert message to #bname element.
					});
}

function goBack()
{
	window.location = "http://users.metropolia.fi/~petrior/mobiiliohjelmointi/app/frontpage.php";
}

function newBudget()
{
	window.location = "http://users.metropolia.fi/~petrior/mobiiliohjelmointi/app/newbudget.php";
}

function getBudgets()
{
	// Use ajax to connect to server.php.
	$.ajax({
			type: "POST",
			url: "server/server.php",
			data: { getBudgets: "adsf" }, // Dummy variable to read isset in server.php.
			dataType: "json" // We expect return message as json string.
		}).done(function( msg ) { // When server returns message.
					var teksti = ""; // This will hold budgets in table data.
					if(msg != null) // If return message is not empty empty...
					{
						$.each(msg, function(key, value){ // Loop through json string.
								// Append row to variable.
								// We also add onlick functions for budget deletion and selection.
								teksti += "<tr><td class=\"delete\" onclick=\"deleteBudget(" + value["bid"] + ")\">X</td><td onclick=\"selectBudget(" + value["bid"] + ")\">" + value["bname"] + "</td></tr>";
						});
					}
					$("#budgetList").html(teksti); // Insert table data to #budgetList element.
				});
}

function selectBudget(bid) // Select the budget (bid = id of the budget).
{
	// Use ajax to connect to server.php.
	$.ajax({
			type: "POST",
			url: "server/server.php",
			data: { budgetId: bid } // Send id of the budget to server.php which will change the default budget of the user.
		}).done(function( msg ) { // When done...
					window.location = "http://users.metropolia.fi/~petrior/mobiiliohjelmointi/app/frontpage.php"; // Redirect to frontpage.
				});
}
function deleteBudget(bid) // Delete the budget.
{
	$.ajax({
			type: "POST",
			url: "server/server.php",
			data: { budgetDeleteId: bid }
		}).done(function( msg ) {
					getBudgets();
				});
}


