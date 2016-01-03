var m_child_list = {};



m_child_list.watch = function() {
	'use strict';

	$('.m_child_list .addTrialBtn').click(function() {
		m_child_list.addTrialDialog();
	});

	$('.m_child_list').on("click", ".actions .remove", function(){
		m_child_list.removeClick($(this));
	});

};



m_child_list.validate = function() {
	'use strict';
	var arr = [];
	var attrClass = '';
	var seq = '';
	var errorText = '';


	$.each($('.m_child_list .childTable tbody tr'), function( index, value ) {
		attrClass = $(this).attr("class");
		seq = getSeqFromAttrClass(attrClass).seq;

		if (seq.length > 0) {
			arr[index] = seq;
		}
	});

	if (arr.length !== uniqueArr(arr).length) {
		errorText += "<li>You have at least 1 duplicate trial in your 'Trials In This Group' section. Trials can only appear once in this list.</li>";
	}


	return errorText;
};



m_child_list.parse = function() {
	'use strict';
	var arr = [];
	var attrClass = '';
	var seq = '';
	var classPrefix = 'seq-';


	$.each($('.m_child_list .childTable tbody tr'), function( index, value ) {
		attrClass = $(this).attr("class");
		seq = getSeqFromAttrClass(attrClass).seq;

		if (seq.length > 0) {
			arr[index] = seq;
		}
	});


	return arr;
};



m_child_list.addTrialDialog = function() {
	'use strict';
	var newTrial = {};

	BootstrapDialog.show({
    title: '<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>&nbsp;&nbsp;Add Trial',
		type: BootstrapDialog.TYPE_INFO,
		message: $('<div></div>').load(gVar.root + '/module/search_trial_add/module.php'),
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
        	addTrialsClick();
        }
    	}
    ]
  });


	function addTrialsClick() {
		var msg = '';

  	newTrial = m_search_trial_add.parse();

  	if (newTrial.arr.length === 0) {
  		msg = '<h3 style="text-align:center;">No trials have been selected.<h3>';
  		dialogWarn(msg);
  	} else {
  		m_child_list.appendTable(newTrial);
	  }
	}
}



m_child_list.appendTable = function(newTrial) {
	'use strict';
	var msg = '';

	$.ajax({
		type: 'POST',
    url: gVar.root + '/module/child_list/dist/sql_appendTable.php',
    data: {
    	'seqCSV' : JSON.stringify(newTrial.csv)
    },
    dataType: 'json',
    success: function(results) {
    	if (results.status === 'success') {
    		addTrial(results.html);
    		$('.m_search_trial_add input[type=checkbox]').removeAttr('checked');	//Uncheck trials in search_trial_add module.
    	} else {
    		msg = '<h3 style="text-align:center;">There was an error. Trial(s) not added to the group.</h3>';
  			dialogError(msg);
    	}
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
			msg = 'Status: ' + textStatus + '\n' + 'Error: ' + errorThrown;
  		dialogError(msg);
    }   
  });



	function addTrial(html) {
		if ($('.m_child_list .childTable .noResults').length === 0) {
  		$('.m_child_list .childTable tbody').append(html);
		} else {
			$('.m_child_list .childTable tbody').html(html);
		}


	}

}



m_child_list.removeClick = function(elem) {
	'use strict';
	elem = elem.closest('tr');


	BootstrapDialog.confirm({
		title: '<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;&nbsp;Warning',
		type: BootstrapDialog.TYPE_WARNING,
		message: '<h2 style="text-align:center;">Are you sure?</h2>\n\nThis will remove the trial from this group. It will not delete the trial from the database.',
    closable: false,
    callback: function(result) {
      if(result) {
      	removeTrial(elem);
      } else {

      }
    }
	});

	

	// function removeTrial(classSeq) {
	function removeTrial(elem) {
		var html = '';
		elem.remove();

		if ($('.m_child_list tbody tr').length === 0) {
			html = '<tr class="noResults"><td colspan="5" style="text-align:center; padding:10px;">No trials found</td></tr>';
			$('.m_child_list .childTable tbody').html(html);
		}
	}
};



$( document ).ready(function() {
	m_child_list.watch();

});




