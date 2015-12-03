$(document).ready(function(){
	'use strict';
	var main = {};

	start();


	function start() {
		'use strict';

		initialize();

		watch();
	}


	function initialize() {
		'use strict';

		main = {};
	}


	function watch() {
		'use strict';

		$('#submit').click(function() {
			submit();
		});
	}


	function submit() {
		'use strict';
		var errorText = '';
		var errorList = '';

		errorText = '';
		errorText += m_trialInfo.validate();
		errorText += m_trialHeatData.validate();

		if (errorText.length === 0) {
			$('.errorHolder').html('');
				
			createTrial();

		} else {
			errorList =
				'<h3>Please fix these items:</h3>' +
				'<div class="errorList">' +
				'  <ul>' + errorText + '</ul>' +
				'</div>';

			BootstrapDialog.alert({
				title: 'Error',
				type: BootstrapDialog.TYPE_DANGER,
				message: errorList
			});

			errorText =
				'<div class="alert alert-danger">\n' +
				'    <ul>\n' + errorText + '</ul>\n' +
				'</div>';

			$('.errorHolder').html(errorText);

		}
	}



	function createTrial() {
		var trialInfo = m_trialInfo.parse();
		var trialHeatData = m_trialHeatData.parse();


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
        		var dialog = new BootstrapDialog({
							title: 'Success',
							type: BootstrapDialog.TYPE_SUCCESS,
							message: '<h3 style="text-align:center;">Trial successfully created.</h3>',
							buttons: [{
								label: 'OK',
								action: function(){
									document.location.href = "view.php?trialseq=" + results.trialSeq;
								}
							}]
						});
						
						dialog.open();
   
        	} else {
	      		var dialog = new BootstrapDialog({
							title: 'Error',
							type: BootstrapDialog.TYPE_DANGER,
							message: '<h3 style="text-align:center;">Something went wrong. Trial not created.</h3>',
							buttons: [{
								label: 'OK',
								action: function(dialogRef){
                  dialogRef.close();
                }
							}]
						});
						
						dialog.open();

		      	console.log(results.errors);
	      		console.log(results.status);
	      	}
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
        	var dialog = new BootstrapDialog({
							title: 'Error',
							type: BootstrapDialog.TYPE_DANGER,
							message: 'Status: ' + textStatus + '\n' + 'Error: ' + errorThrown,
							buttons: [{
								label: 'OK',
								action: function(dialogRef){
                  dialogRef.close();
                }
							}]
						});
						
						dialog.open();
        }   
    });
	}	


});


