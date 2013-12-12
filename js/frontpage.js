var defaulBudget = false;

$(document).ready(function(){
	getHeader(); // Get the name of selected budget to header.
	getInfo(); // List the payments on the page.
	$("#selectBudget").click(selectBudget); // Goto budget selection page.
	$("#newPayment").click(newPayment); // Goto payment creation page.
});

function getInfo()
{
	// Use ajax to connect to server.php.
	$.ajax({
			type: "POST",
			url: "server/server.php",
			data: { getInfo: "adsf" }, // Dummy variable to read isset in server.php.
			dataType: "json" // We expect json string as return message.
		}).done(function( msg ) { // When server returns message...
					var teksti = ""; // This will hold table data of payments.
					var budgetValue; // This will hold the total value of budget.
					var purchasesValue = 0; // This will hold the sum of all purchases.
					var first = false; // Helper boolean. 
					if(msg != "")
					{
						$.each(msg, function(key, value){
								if(!first) // If first key.
								{
									// First json item is different from the rest so we read it here.
									budgetValue = parseFloat(value); // Extract total value of the selected budget.
									first = true; // No longer first key.
								}
								else
								{
									// Create the table data for purchases.
									// We get the values from the json string.
									// We also add onclick functions for deleting payments. The argument for payment id is taken from the json string.
									teksti += "<tr><td class=\"deletepayment\" onclick=\"deletePayment(" + value["pid"] + ")\">X</td><td>" + value["pname"] + "</td><td>" + value["pvalue"] + " €</td></tr>";
									purchasesValue += parseFloat(value["pvalue"]); // Add purchase value of current "row" to total value of purchases. Parse float to change from string to float.
								}
						});
					}
					$("#currentBudget").html(teksti);
					if(!budgetValue == 0) // We don't want to display total value and remaining value of budget if no budget is selected.
					{
						$("#budgetValue").html("Total value of budget: " + budgetValue + " €"); // Total value of budget.
						$("#budgetRemaining").html("Remaining: " + (budgetValue-purchasesValue) + " €"); // Remaining (total value of budget - - 
					}
				});
}

function newPayment() // Go to payment creation page.
{
	if(defaultBudget){ // Check if button is enabled.
		window.location = "http://users.metropolia.fi/~petrior/mobiiliohjelmointi/app/newpayment.php";
		}
}
function selectBudget() // Go to budget selection page.
{
	window.location = "http://users.metropolia.fi/~petrior/mobiiliohjelmointi/app/budget.php";
}

function deletePayment(pid) // Delete specifig payment. (pid = id of the payment)
{
	// Use ajax to connect to server.php.
	$.ajax({
			type: "POST",
			url: "server/server.php",
			data: { deletePayment: pid } // Send pid to server.php.
		}).done(function( msg ) { // When server returns message...
					getInfo(); // Refresh table.
				});
}

function getHeader() // Get the name of the selected budget to header.
{
	// Use ajax to connect to server.php.
	$.ajax({
				type: "POST",
				url: "server/server.php",
				data: { getHeader: "getHeader" } // Dummy variable to read isset in server.php.
			}).done(function(msg) // When server returns message...
					{
						if(msg == "") // If message is empty. (No budget selected)
						{
							defaultBudget = false; // Disable "New Payment" button.
							$("#newPayment").attr("class", "unavailable"); // Disable new payment button.
						} else
						{
							defaultBudget = true; // Enable "New Payment" Button.
							$("#bname").text(msg); // Set the return message to header.
						}
					});
}