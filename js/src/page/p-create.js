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
				title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
				type: BootstrapDialog.TYPE_DANGER,
				message: errorList,
				closable: false
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
							title: '<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>&nbsp;&nbsp;Success',
							type: BootstrapDialog.TYPE_SUCCESS,
							message: '<h3 style="text-align:center;">Trial successfully created.</h3>',
							closable: false,
							buttons: [{
								label: 'OK',
								action: function(){
									dialog.close();
									document.location.href = "view.php?trialseq=" + results.trialSeq;
								}
							}]
						});
						
						dialog.open();

						console.log(trialHeatData);
   
        	} else {
	      		var dialog = new BootstrapDialog({
							title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
							type: BootstrapDialog.TYPE_DANGER,
							message: '<h3 style="text-align:center;">Something went wrong. Trial not created.</h3>',
							closable: false,
							buttons: [{
								label: 'OK',
								action: function(dialogRef){
                  dialog.close();
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
						title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
						type: BootstrapDialog.TYPE_DANGER,
						message: 'Status: ' + textStatus + '\n' + 'Error: ' + errorThrown,
						closable: false,
						buttons: [{
							label: 'OK',
							action: function(dialogRef){
                dialog.close();
              }
						}]
					});
					
					dialog.open();
        }   
    });
	}	


});



