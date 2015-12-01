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
		var trialHeatData = m_trialHeatData.parse();

console.log(trialInfo);
		$.ajax({
				type: 'POST',
        url: 'php/dist/sql-update.php',
        data: {
        	'trialSeq'	: JSON.stringify( prepForSQL(trialSeq) ),
        	'trialInfo' : JSON.stringify(trialInfo),
        	'trialHeatData' : JSON.stringify(trialHeatData)
        },
        dataType: 'json',
        success: function(results) {
        	console.log(results.status);
        	alert("Trial successfully added to the database.");
        	document.location.href = "view.php?trialseq=" + trialSeq;
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
        	'trialSeq' : prepForSQL(getURLVariable('trial-seq'))
        },
        dataType: 'json',
        success: function(results) {
        	console.log(results);
        	alert("Trial has been deleted.");
        	document.location.href = "index.php";
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
          alert(
          	'Status: ' + textStatus + '\n' +
        		'Error: ' + errorThrown
        	);
        }   
    });
	}


	// function parseTrialInfo(elem) {
	// 	var trialInfo = {
	// 		trialSeq				: prepForSQL(getURLVariable('trial-seq')),
	// 		trialName 			: prepForSQL($(elem + ' .trialName input').val()),
	// 		user 						: prepForSQL($(elem + ' .owner input').val()),
	// 		startDate 			: prepForSQL($(elem + ' .startDate input').val(), 'date'),
	// 		endDate 				: prepForSQL($(elem + ' .endDate input').val(), 'date'),
	// 		procChg 				: prepForSQL($(elem + ' .processChange input').val()),
	// 		twi 						: prepForSQL($(elem + ' .twi input').val()),
	// 		unit 						: prepForSQL($(elem + ' .unit select').val()),
	// 		trialType 			: prepForSQL($(elem + ' .trialType select').val()),
	// 		changeType 			: prepForSQL($(elem + ' .changeType select').val()),
	// 		BOPVsl 					: prepForSQL($(elem + ' .bopVsl select').val()),
	// 		degasVsl 				: prepForSQL($(elem + ' .degasVsl select').val()),
	// 		argonNum 				: prepForSQL($(elem + ' .argonNum select').val()),
	// 		casterNum 			: prepForSQL($(elem + ' .casterNum select').val()),
	// 		strandNum 			: prepForSQL($(elem + ' .strandNum select').val()),
	// 		trialGoal 			: prepForSQL($(elem + ' .goalText textarea').val()),
	// 		trialMonitor 		: prepForSQL($(elem + ' .monitorText textarea').val()),
	// 		trialComment 		: prepForSQL($(elem + ' .otherInfoText textarea').val()),
	// 		trialConclusion : prepForSQL($(elem + ' .conclusionText textarea').val())
	// 	};


	// 	return trialInfo;
	// }


	// function parseTrialData(elem) {
	// 	var emptyRow = null;
	// 	var rawTrialData = $(elem).handsontable('getInstance').getData();
	// 	var trialData = [];

	// 	$.each(rawTrialData, function( index, row ) {
	// 		emptyRow = true;	//Initialize

	// 		$.each(row, function( index, value ) {
	// 			if (value !== null  &&  value !== '') {
	// 				emptyRow = false;
	// 			}
	// 			row[index] = prepForSQL(value);
	// 		});

	// 		if (!emptyRow) {
	// 			trialData.push(row);
	// 		}
	// 	});


	// 	return trialData;
	// }



});





