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
		var createType = getURLVariable('type');
		var errorText = '';
		var errorList = '';

		if (createType !== 'group') {
			createType = 'trial';
		}


		if (createType === 'trial') {
			errorText += m_info_trial.validate();
			errorText += m_heatData_trial.validate();
		} else if (createType === 'group') {
			errorText += m_info_group.validate();
		}


		if (errorText.length === 0) {
			$('.errorHolder').html('');
				
			if (createType === 'group') {
				create('group');
			} else if (createType === 'trial') {
				create('trial');
			}

		} else {
			errorList =
				'<h3>Please fix these items:</h3>' +
				'<div class="errorList">' +
				'  <ul>' + errorText + '</ul>' +
				'</div>';

			BootstrapDialog.alert({
				title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
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



	function create(type) {
		'use strict';
		var info = {};
		var heatData = {};
		var urlSQL = '';
		var urlRedirect = '';
		var msgSuccess = '';
		var msgFailure = '';

		if (type === 'trial') {
			info = m_info_trial.parse();
			heatData = m_heatData_trial.parse();
			urlSQL = 'php/dist/sql-createTrial.php';
			urlRedirect = 'view.php?trialseq=';
			msgSuccess = 'Trial successfully created.';
			msgFailure = 'Something went wrong. Trial not created.';
		} else if (type === 'group') {
			info = m_info_group.parse();
			urlSQL = 'php/dist/sql-createGroup.php';
			urlRedirect = 'view.php?groupseq=';
			msgSuccess = 'Group successfully created.';
			msgFailure = 'Something went wrong. Group not created.';
		}



		$.ajax({
			type: 'POST',
      url: urlSQL,
      data: {
      	'info' : JSON.stringify(info),
      	'heatData' : JSON.stringify(heatData)
      },
      dataType: 'json',
      success: function(results) {
      	if (results.status === 'success') {
      		var dialog = new BootstrapDialog({
						title: '<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>&nbsp;&nbsp;Success',
						type: BootstrapDialog.TYPE_SUCCESS,
						message: '<h3 style="text-align:center;">' + msgSuccess + '</h3>',
						buttons: [{
							label: 'OK',
							action: function(){
								dialog.close();
								document.location.href = urlRedirect + results.seq;
							}
						}]
					});
					
					dialog.open();
 
      	} else {
      		var dialog = new BootstrapDialog({
						title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
						type: BootstrapDialog.TYPE_DANGER,
						message: '<h3 style="text-align:center;">' + msgFailure + '</h3>',
						buttons: [{
							label: 'OK',
							action: function(dialogRef){
                dialog.close();
              }
						}]
					});
					
					dialog.open();

	      	console.log(results.errors);
      		console.log(results.debugSQL);
      	}
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) { 
      	var dialog = new BootstrapDialog({
					title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
					type: BootstrapDialog.TYPE_DANGER,
					message: 'Status: ' + textStatus + '\n' + 'Error: ' + errorThrown,
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



