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
console.log(trialHeatData);

		$.ajax({
				type: 'POST',
        url: 'php/dist/sql-create.php',
        data: {
        	'trialInfo' : JSON.stringify(trialInfo),
        	'trialHeatData' : JSON.stringify(trialHeatData)
        },
        dataType: 'json',
        success: function(results) {
        	if (results.status === 'success') {
        		alert("Trial successfully added to the database.");
        		document.location.href = "view.php?trialseq=" + results.trialSeq;
        	} else {
	      		alert("Something went wrong. Trial not added.");
		      	console.log(results.errors);
	      	console.log(results.status);
	      	}
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





