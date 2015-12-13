var m_addTrialSearch = {};



m_addTrialSearch.start = function() {
	'use strict';


	m_addTrialSearch.watch();
};



m_addTrialSearch.watch = function() {
	'use strict';


	$('.m-addTrialSearch .name input').keyup(function() {		//Watch for typing in the name input. This allows for live searching while the user types.
    m_addTrialSearch.search();
	});
};



m_addTrialSearch.search = function() {
	'use strict';
	var name = $('.m-addTrialSearch .name input').val();


	$.ajax({
		type: 'POST',
    url: 'php/dist/sql-addTrial-search.php',
    data: {
    	'name' : JSON.stringify(name)
    },
    dataType: 'json',
    success: function(results) {
    	$('.m-addTrialSearch .searchResults').html(results.html);
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



m_addTrialSearch.parse = function() {
	'use strict';
	var obj = {
		arr: [],
		csv: ''
	};


	$('.m-addTrialSearch input[type=checkbox]').each(function() {
	  if (this.checked) {
		  if (obj.csv) {
		  	obj.csv += ', ';
		  }
		  obj.csv += $(this).val();

		  obj.arr.push($(this).val());
		}
	});


	return obj;
};




m_addTrialSearch.start();




