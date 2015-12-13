autosize($('#m-commentList-trial textarea'));


var m_childList_group = {};



m_childList_group.start = function() {
	'use strict';

	m_childList_group.watch();
};



m_childList_group.watch = function() {
	'use strict';

	$('.m-childList-group .addTrialBtn').click(function() {
		m_childList_group.addTrialDialog();
	});

};



m_childList_group.parse = function() {
	'use strict';
	var arr = [];
	var class = '';
	var trialSeq = '';
	var classPrefix = 'seq-';


	$.each($('.m-childList-group .childTable tbody tr'), function( index, value ) {
		class = $(this).attr("class").match(/seq-[\w-]*\b/)[0];
		trialSeq = class.substring(classPrefix.length, class.length);

		arr[index] = trialSeq;
	});


	return arr;
};



m_childList_group.addTrialDialog = function() {
	'use strict';
	var newTrial = {};

	BootstrapDialog.show({
    title: '<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>&nbsp;&nbsp;Add Trial',
		type: BootstrapDialog.TYPE_INFO,
		message: $('<div></div>').load('php/dist/m-addTrialSearch.php'),
    buttons: [
    	{
        label: 'Close',
        action: function(dialogItself){
          dialogItself.close();
      	}
    	}, {
        label: 'Add Trials',
        cssClass: 'btn-success',
        action: function(){
        	newTrial = m_addTrialSearch.parse();
        	m_childList_group.appendTable(newTrial);
        }
    	}
    ]
  });

}



m_childList_group.appendTable = function(newTrial) {
	'use strict';

	$.ajax({
		type: 'POST',
    url: 'php/dist/sql-addTrial-appendTable.php',
    data: {
    	'seqCSV' : JSON.stringify(newTrial.csv)
    },
    dataType: 'json',
    success: function(results) {
    	addTrial(results);
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



	function addTrial(obj) {
		var html = '';

		if ($('m-childList-group .childTable').length) {
			console.log(1);
			html = obj.html;
  		$('.m-childList-group .childTable tbody').append(html);
		} else {
			html = obj.html_tableStart + obj.html + obj.html_tableEnd;
			$('.m-childList-group .content').html(html);
		}
	}

}



m_childList_group.removeClick = function(target) {
	'use strict';

	BootstrapDialog.confirm({
		title: '<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;&nbsp;Warning',
		type: BootstrapDialog.TYPE_WARNING,
		message: '<h3 style="text-align:center;">This will remove the trial from this group. It will not delete the trial from the database. \n \nAre you sure?</h3>',
    closable: false,
    callback: function(result) {
      if(result) {
      	removeTrial();
      } else {

      }
    }
	});

	

	function removeTrial() {
		// $('.' + target + ' input').val('');
		// $('.' + target + ' textarea').val('');
		$('.' + target).remove();
		// target.remove();

		if ($('.m-childList-group tbody tr').length === 0) {
			$('.m-childList-group .content').html('<div style=\"text-align:center; padding:10px;\">No trials found.</div>');
		}
	}
};



$( document ).ready(function() {
	m_childList_group.start();
});




