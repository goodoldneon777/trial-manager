var p_update = {};



p_update.watch = function() {
	'use strict';

	$('.p_update .c_submitBtn .updateBtn').click(function() {
		p_update.updateClick();
	});

	$('.p_update .c_submitBtn .deleteBtn').click(function() {
		p_update.deleteClick();
	});
};



p_update.updateClick = function() {
	'use strict';
	var trialSeq = getURLVariable('trialseq');
	var groupSeq = getURLVariable('groupseq');
	var seq = '';
	var pageType = '';
	var errorText = '';
	var errorList = '';

	if (trialSeq) {
		pageType = 'trial';
		seq = trialSeq;
	} else if (groupSeq) {
		pageType = 'group';
		seq = groupSeq;
	}


	if (pageType === 'trial') {
		errorText += m_info.validate();
		errorText += m_heat_data.validate();
	} else if (pageType === 'group') {
		errorText += m_info.validate();
	}


	//If there weren't any errors
	if (errorText.length === 0) {
		$('.p_update .c_errorBox').html('');

		p_update.update(pageType, seq);
	} else {	//If there was at least 1 error
		//Build the HTML for the error dialog.
		errorList =
			'<h3>Please fix these items:</h3>' +
			'<div class="errorList">' +
			'  <ul>' + errorText + '</ul>' +
			'</div>';

		//Alert the user with the errors.
		BootstrapDialog.alert({
			title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
			type: BootstrapDialog.TYPE_DANGER,
			message: errorList
		});

		//Build the HTML for the embedded error box.
		errorText =
			'<div class="alert alert-danger">' +
			'    <ul>' + errorText + '</ul>' +
			'</div>';

		//Update the embedded error box with the errors.
		$('.p_update .c_errorBox').html(errorText);

	}
};



p_update.update = function(pageType, seq) {
	'use strict';
	var info = m_info.parse();
	var heatData = {};
	var commentList = m_comment_list.parse();
	var childTrialList = [];
	var urlSQL = gVar.root + '/page/update/dist/sql_update.php';
	var urlRedirect = '';
	var msgSuccess = '';
	var msgFailure = '';


	if (pageType === 'trial') {
		heatData = m_heat_data.parse();
		urlRedirect = 'view?trialseq=';
		msgSuccess = 'Trial successfully created.';
		msgFailure = 'Something went wrong. Trial not created.';
	} else if (pageType === 'group') {

		childTrialList = m_child_list.parse();
		urlRedirect = 'view?groupseq=';
		msgSuccess = 'Group successfully created.';
		msgFailure = 'Something went wrong. Group not created.';
	}


	$.ajax({
		type: 'POST',
    url: urlSQL,
    data: {
    	'pageType': pageType,
    	'seq': seq,
    	'info': JSON.stringify(info),
    	'commentList': JSON.stringify(commentList),
    	'heatData': JSON.stringify(heatData),
    	'childTrialList': JSON.stringify(childTrialList)
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

};





$(document).ready(function(){
	p_update.watch();
});















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


	// start();
// $('.m-childList-group .addBtn').click();


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
		var target = null;
		

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
		var childTrialList = [];
		var commentList = [];
		var heatData = {};
		var urlSQL = null;
		var urlRedirect = null;
		var msgSuccess = null;
		var msgFailure = null;

		if (type === 'trial') {
			seq = trialSeq;
			info = m_info_trial.parse();
			commentList = m_comment_list.parse();
			heatData = m_heat_data.parse();
			urlSQL = 'php/dist/sql-update-trial.php';
			urlRedirect = 'view.php?trialseq=';
			msgSuccess = 'Trial successfully updated.';
			msgFailure = 'Something went wrong. Trial not updated.';
		} else if (type === 'group') {
			seq = groupSeq;
			info = m_info_group.parse();
			childTrialList = m_child_list.parse();
			commentList = m_comment_list.parse();
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
      	'childTrialList': JSON.stringify(childTrialList),
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




	// function addTrial_appendTable(newTrial) {
	// 	'use strict';

	// 	$.ajax({
	// 		type: 'POST',
	//     url: 'php/dist/sql-addTrial-appendTable.php',
	//     data: {
	//     	'seqCSV' : JSON.stringify(newTrial.csv)
	//     },
	//     dataType: 'json',
	//     success: function(results) {
 //    		$('.m-childList-group .childTable tbody').append(results.html);
	//     },
	//     error: function(XMLHttpRequest, textStatus, errorThrown) { 
	//     	var dialog = new BootstrapDialog({
	// 				title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
	// 				type: BootstrapDialog.TYPE_DANGER,
	// 				message: 'Status: ' + textStatus + '\n' + 'Error: ' + errorThrown,
	// 				buttons: [{
	// 					label: 'OK',
	// 					action: function(dialogRef){
	//             dialogRef.close();
	//           }
	// 				}]
	// 			});
					
	// 			dialog.open();
	//     }   
	//   });

	// }


});





