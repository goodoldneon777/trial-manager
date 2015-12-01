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
			errorText += m_trialComment_list.validate();

			if (errorText.length === 0) {
				$('#error-box').html('');
					
				submit();

			} else {
				errorText =
					'<div class="alert alert-danger" style="text-align:left">\n' +
					'    <ul>\n' + errorText + '</ul>\n' +
					'</div>';
				$('#error-box').html(errorText);

			}
		});


		$('#delete').click(function() {
			if ( confirm('Are you sure you want to permanently delete this trial?') ) {
			  deleteTrial();
			}
		});
	}



	function submit() {
		var trialSeq = getURLVariable('trialseq');
		var trialInfo = m_trialInfo.parse();
		var trialComment_list = m_trialComment_list.parse();
		var trialHeatData = m_trialHeatData.parse();


		$.ajax({
			type: 'POST',
      url: 'php/dist/sql-update.php',
      data: {
      	'trialSeq'	: JSON.stringify( prepForSQL(trialSeq) ),
      	'trialInfo' : JSON.stringify(trialInfo),
      	'trialComment_list' : JSON.stringify(trialComment_list),
      	'trialHeatData' : JSON.stringify(trialHeatData)
      },
      dataType: 'json',
      success: function(results) {
      	if (results.status === 'success') {
      		alert("Trial successfully updated.");
      		document.location.href = "view.php?trialseq=" + trialSeq;
      	} else {
      		alert("Something went wrong. Trial not updated.");
	      	console.log(results.errors);
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


	function deleteTrial() {
		$.ajax({
				type: 'POST',
        url: 'php/dist/sql-delete.php',
        data: {
        	'trialSeq' : prepForSQL(getURLVariable('trialseq'))
        },
        dataType: 'json',
        success: function(results) {
	      	if (results.status === 'success') {
	        	alert("Trial has been deleted.");
	        	document.location.href = "index.php";
	        } else {
	      		alert("Something went wrong. Trial not deleted.");
	      		console.log(results.errors);
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





