function checklength(i) {
 
	if (i < 10) {
	    i = "0" + i;
	}
	return i;
 	
}

function AddClock(element) {

	$(document).ready(function () {
		var refreshIntervalId = setInterval(function () {
		var now = new Date();
		var date = now.getFullYear() + '-' + checklength((now.getMonth() + 1)) + '-' + checklength(now.getDate());
		var time = checklength(now.getHours()) + ':' + checklength(now.getMinutes()) + ':' + checklength(now.getSeconds());
		var dateTime = date + ' ' + time;
	$(element).text(dateTime);
	}, 1000);
	});
}

AddClock("#clock");  