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
			deleteClick();
		});
	}



	function submit() {
		'use strict';
		var errorText = '';
		var errorList = '';


		if (pageType === 'trial') {
			errorText += m_info_trial.validate();
			errorText += m_heatData_trial.validate();
		} else if (pageType === 'group') {
			errorText += m_info_group.validate();
		}


		if (errorText.length === 0) {
			$('.errorHolder').html('');
				

			if (pageType === 'trial') {
				// updateTrial();
				update('trial');
			} else if (pageType === 'group') {
				// updateGroup();
				update('group');
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



	function deleteClick() {
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
						deleteFunc('trial');
					} else if (pageType === 'group') {
						deleteFunc('group');
					}
        } else {
        	return;
        }
      }
		});
	}



	function update(type) {
		'use strict';
		var seq = null;
		var info = {};
		var commentList = [];
		var heatData = {};
		var urlSQL = null;
		var urlRedirect = null;
		var msgSuccess = null;
		var msgFailure = null;

		if (type === 'trial') {
			seq = trialSeq;
			info = m_info_trial.parse();
			commentList = m_commentList.parse();
			heatData = m_heatData_trial.parse();
			urlSQL = 'php/dist/sql-update-trial.php';
			urlRedirect = 'view.php?trialseq=';
			msgSuccess = 'Trial successfully updated.';
			msgFailure = 'Something went wrong. Trial not updated.';
		} else if (type === 'group') {
			seq = groupSeq;
			info = m_info_group.parse();
			commentList = m_commentList.parse();
			urlSQL = 'php/dist/sql-update-group.php';
			urlRedirect = 'view.php?groupseq=';
			msgSuccess = 'Group successfully update.';
			msgFailure = 'Something went wrong. Group not updated.';
		}


		$.ajax({
			type: 'POST',
      url: urlSQL,
      data: {
      	'seq' : JSON.stringify(seq),
      	'info' : JSON.stringify(info),
      	'commentList': JSON.stringify(commentList),
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



	function deleteFunc(type) {
		'use strict';
		var seq = null;
		var info = {};
		var commentList = [];
		var heatData = {};
		var urlSQL = null;
		var urlRedirect = null;
		var msgSuccess = null;
		var msgFailure = null;

		if (type === 'trial') {
			seq = trialSeq;
			urlSQL = 'php/dist/sql-delete-trial.php';
			urlRedirect = 'index.php';
			msgSuccess = 'Trial successfully deleted.';
			msgFailure = 'Something went wrong. Trial not deleted.';
		} else if (type === 'group') {
			seq = groupSeq;
			urlSQL = 'php/dist/sql-delete-group.php';
			urlRedirect = 'index.php';
			msgSuccess = 'Group successfully deleted.';
			msgFailure = 'Something went wrong. Group not deleted.';
		}


		$.ajax({
			type: 'POST',
      url: urlSQL,
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





