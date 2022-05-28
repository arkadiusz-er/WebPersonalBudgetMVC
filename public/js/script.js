//Wyciąganie daty
var today = new Date();
var day = today.getDate();
var month = today.getMonth() + 1;
var year = today.getFullYear();
if (month < 10) month = "0" + month;
if (day < 10) day = "0" + day;
var maxDate = year + '-' + month + '-' + day;


//skrócona wersja
if(document.getElementById("dateIncExp")) {
	document.getElementById("dateIncExp").value = maxDate;
	document.getElementById("dateIncExp").max = maxDate;
}
if(document.getElementById("dateStartForm")) {
	document.getElementById("dateStartForm").max = maxDate;
	document.getElementById("dateEndForm").min = document.getElementById("dateStartForm").value;
}
if(document.getElementById("dateEndForm")) document.getElementById("dateEndForm").max = maxDate;

/*
//wydłużona wersja
var dateIncomeExpense = document.getElementById("dateIncExp");
dateIncomeExpense.setAttribute("value", maxDate);
dateIncomeExpense.setAttribute("max", maxDate);

var dateStart = document.getElementById("dateStartForm");
dateStart.setAttribute("max", maxDate);

var dateEnd = document.getElementById("dateEndForm");
dateEnd.setAttribute("max", maxDate);
*/


