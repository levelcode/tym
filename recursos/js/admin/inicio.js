$("header .notificaciones").css({display:"none"});
	"use_strict";
	//AJAX SETUP
	$.ajaxSetup({
		url       : "server/api/Ajax.php",
		dataType  : 'json',
		type      : "POST"
	});

	var loadingChartData = false;	

	google.load('visualization', '1', {'packages':['corechart']});
	google.setOnLoadCallback( loadData );



	function loadData() {

		loadingChartData = true;

		$('#chart-alert').removeClass('hidden');
		$('#loading-chart').removeClass('hidden');

		var userType = $('input#user_type_id_for_jq').val();
		var id = $('input#id_cliente_for_jq').val();
		var page;

			switch( userType ) {
				case '1':
					page = 'client_char';
					break;
				case '2':
					page = 'logistic_notifications';
					break;
				case '3':
					page = 'collector_notifications';
					break;
				case '4':
					page = 'weighing_machine_notifications';
					break;
			}

		$.ajax({
	        data : 'a=list_varios&from=start_char&page='+page+'&client_id='+id+'&join=1&where=1',
	        complete: function(response, status){
	          //console.log(response, ' - ', status);
				console.log(response.responseJSON);
				switch( response.responseJSON.status ) {
					case 'FILTERED':
						$('#chart-alert').addClass('hidden');
						$('#loading-chart').addClass('hidden');
						drawChart( response.responseJSON.data_chart );
						break;
					case 'EMPTY':
							$('#loading-chart').addClass('hidden');
							$('#chart-empty').removeClass('hidden');	
						break;

				}
			}
		});
	}

	function drawChart( dataChart ) {

		var data = google.visualization.arrayToDataTable( dataChart );

		var options = {
			title: 'Top residuos'
		};

		var chart = new google.visualization.PieChart(document.getElementById('grafico-1'));

		chart.draw(data, options);
	}
	
