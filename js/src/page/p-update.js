$(document).ready(function(){
	'use strict';
	var main = {};
	var trialSeq = getURLVariable('trialseq');
	var groupSeq = getURLVariable('groupseq');
	var pageType = '';

	if (!groupSeq) {
		pageType = 'trial';
	} else {
		pageType= 'group';
	}


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


		if (pageType === 'trial') {
			errorText += m_trialInfo.validate();
			errorText += m_trialHeatData.validate();
		} else if (pageType === 'group') {
			errorText += m_groupInfo.validate();
		}


		if (errorText.length === 0) {
			$('.errorHolder').html('');
				
			if (pageType === 'trial') {
				updateTrial();
			} else if (pageType === 'group') {
				updateGroup();
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
					if (pageType === 'trial') {
						deleteTrial();
					} else if (pageType === 'group') {
						deleteGroup();
					}
        } else {
        	return;
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



	function updateGroup() {
		'use strict';
		var seq = groupSeq;
		var info = m_groupInfo.parse();
		var urlSuccessRedirect = 'view.php?groupseq=' + seq;
		var msgSuccess = 'Group successfully updated.';
		var msgFailure = 'Something went wrong. Group not updated.';


		$.ajax({
			type: 'POST',
      url: 'php/dist/sql-updateGroup.php',
      data: {
      	'seq'	: JSON.stringify( prepForSQL(seq) ),
      	'info' : JSON.stringify(info)
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
								document.location.href = urlSuccessRedirect;
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


	function deleteGroup() {
		'use strict';
		var seq = groupSeq;
		var msgSuccess = 'Group successfully deleted.';
		var msgFailure = 'Something went wrong. Group not updated.';


		$.ajax({
			type: 'POST',
      url: 'php/dist/sql-deleteGroup.php',
      data: {
      	'seq' : prepForSQL(seq)
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
								document.location.href = "index.php";
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





