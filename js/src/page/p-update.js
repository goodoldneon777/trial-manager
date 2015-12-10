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


		$('#delete').click(function() {
			deleteFunc();
		});
	}


	function submit() {
		'use strict';
		var errorText = '';
		var errorList = '';


		errorText += m_trialInfo.validate();
		errorText += m_trialHeatData.validate();
		errorText += m_trialComment_list.validate();

		if (errorText.length === 0) {
			$('.errorHolder').html('');
				
			updateTrial();

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


	function deleteFunc() {
		'use strict';
		var errorText = '';
		var errorList = '';

		BootstrapDialog.confirm({
			title: '<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;&nbsp;Warning',
			type: BootstrapDialog.TYPE_WARNING,
			message: '<h3 style="text-align:center;">This will permanently delete the trial. \n \nAre you sure?</h3>',
      closable: false,
      callback: function(result) {
        if(result) {
            deleteTrial();
        } else {

        }
      }
		});
	}


	function updateTrial() {
		'use strict';
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
      		var dialog = new BootstrapDialog({
						title: '<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>&nbsp;&nbsp;Success',
						type: BootstrapDialog.TYPE_SUCCESS,
						message: '<h3 style="text-align:center;">Trial successfully updated.</h3>',
						buttons: [{
							label: 'OK',
							action: function(){
								document.location.href = "view.php?trialseq=" + trialSeq;
							}
						}]
					});
					
					dialog.open();
      	} else {
      		var dialog = new BootstrapDialog({
						title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
						type: BootstrapDialog.TYPE_DANGER,
						message: '<h3 style="text-align:center;">Something went wrong. Trial not updated.</h3>',
						buttons: [{
							label: 'OK',
							action: function(dialogRef){
                dialogRef.close();
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
              dialogRef.close();
            }
					}]
				});
				
				dialog.open();

	     	console.log(results.debugSQL);
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
	        	var dialog = new BootstrapDialog({
							title: '<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>&nbsp;&nbsp;Success',
							type: BootstrapDialog.TYPE_SUCCESS,
							message: '<h3 style="text-align:center;">Trial successfully deleted.</h3>',
							buttons: [{
								label: 'OK',
								action: function(){
									document.location.href = "index.php";
								}
							}]
						});
						
						dialog.open();
	        } else {
	      		var dialog = new BootstrapDialog({
							title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
							type: BootstrapDialog.TYPE_DANGER,
							message: '<h3 style="text-align:center;">Something went wrong. Trial not deleted.</h3>',
							buttons: [{
								label: 'OK',
								action: function(dialogRef){
	                dialogRef.close();
	              }
							}]
						});
						
						dialog.open();

	      		console.log(results.errors);
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
                  dialogRef.close();
                }
							}]
						});
						
						dialog.open();
        }
    });
	}




});





