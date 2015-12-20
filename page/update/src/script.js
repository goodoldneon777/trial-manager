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

		p_update.updateFunc(pageType, seq);
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



p_update.updateFunc = function(pageType, seq) {
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
		msgSuccess = 'Trial successfully updated.';
		msgFailure = 'Something went wrong. Trial not updated.';
	} else if (pageType === 'group') {

		childTrialList = m_child_list.parse();
		urlRedirect = 'view?groupseq=';
		msgSuccess = 'Group successfully updated.';
		msgFailure = 'Something went wrong. Group not updated.';
	}
// console.log(childTrialList);
// return;
	$.ajax({
		type: 'POST',
    url: urlSQL,
    data: {
    	'pageType': pageType,
    	'seq': seq,
    	'info': JSON.stringify(info),
    	'oldCommentList': JSON.stringify(commentList.oldArr),
    	'newCommentList': JSON.stringify(commentList.newArr),
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



p_update.deleteClick = function() {
	'use strict';
	var trialSeq = getURLVariable('trialseq');
	var groupSeq = getURLVariable('groupseq');
	var seq = '';
	var pageType = '';

	if (trialSeq) {
		pageType = 'trial';
		seq = trialSeq;
	} else if (groupSeq) {
		pageType = 'group';
		seq = groupSeq;
	}


	p_update.deleteFunc(pageType, seq);

};



p_update.deleteFunc = function(pageType, seq) {
	'use strict';
	var urlSQL = gVar.root + '/page/update/dist/sql_delete.php';
	var urlRedirect = gVar.root;
	var msgSuccess = '';
	var msgFailure = '';

	if (pageType === 'trial') {
		msgSuccess = 'Trial successfully deleted.';
		msgFailure = 'Something went wrong. Trial not deleted.';
	} else if (pageType === 'group') {
		msgSuccess = 'Group successfully deleted.';
		msgFailure = 'Something went wrong. Group not deleted.';
	}


	$.ajax({
		type: 'POST',
    url: urlSQL,
    data: {
    	'pageType' : pageType,
    	'seq' : seq
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
							document.location.href = urlRedirect;
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

};





$(document).ready(function(){
	p_update.watch();
});













