var p_comment = {};



p_comment.watch = function() {
	'use strict';

	$('.p_comment .c_submitBtn button').click(function() {
		p_comment.submitClick();
	});
};



p_comment.submitClick = function() {
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


	// errorText += m_comment_add.validate();


	//If there weren't any errors
	if (errorText.length === 0) {
		$('.p_comment .c_errorBox').html('');

		p_comment.create(pageType, seq);
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
		$('.p_comment .c_errorBox').html(errorText);

	}
};



p_comment.create = function(pageType, seq) {
	'use strict';
	var comment = m_comment_add.parse();
	var urlSQL = gVar.root + '/page/comment/dist/sql_create.php';
	var urlRedirect = '';
	var msgSuccess = 'Comment successfully added.';
	var msgFailure = 'Something went wrong. Comment not added.';


	if (pageType === 'trial') {
		urlRedirect = 'view?trialseq=';
	} else if (pageType === 'group') {
		urlRedirect = 'view?groupseq=';
	}


	$.ajax({
		type: 'POST',
    url: urlSQL,
    data: {
    	'pageType': pageType,
    	'seq': seq,
    	'comment': JSON.stringify(comment)
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
	p_comment.watch();
});




