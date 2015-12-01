$(document).ready(function(){
	var main = {};

	start();


	function start() {
		initialize();
		watch();
	}


	function initialize() {
		main = {};
	}


	function watch() {
		var errorText = '';

		$('#submit').click(function() {
			errorText = '';
			errorText += m_trialInfo.validate();
			errorText += m_trialHeatData.validate();

			if (errorText.length === 0) {
				$('#error-box').html('');
					
				createTrial();

			} else {
				errorText =
					'<div class="alert alert-danger" style="text-align:left">\n' +
					'    <ul>\n' + errorText + '</ul>\n' +
					'</div>';
				$('#error-box').html(errorText);

			}
		});
	}



	function createTrial() {
		var trialInfo = m_trialInfo.parse();
		var trialHeatData = m_trialHeatData.parse();


		$.ajax({
				type: 'POST',
        url: 'php/dist/sql-create.php',
        data: {
        	'trialInfo' : JSON.stringify(trialInfo),
        	'heatData' : JSON.stringify(trialHeatData)
        },
        dataType: 'json',
        success: function(results) {
        	console.log(results);
        	alert("Trial successfully added to the database.");
        	document.location.href = "view.php?trialseq=" + results.trialSeq;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
          alert(
          	'Status: ' + textStatus + '\n' +
        		'Error: ' + errorThrown
        	);
        }   
    });
	}	


});





