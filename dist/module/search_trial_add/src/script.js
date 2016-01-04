var m_search_trial_add = {};



m_search_trial_add.watch = function() {
	'use strict';


	$('.m_search_trial_add .name input').keyup(function() {		//Watch for typing in the name input. This allows for live searching while the user types.
    m_search_trial_add.search();
	});
};



m_search_trial_add.search = function() {
	'use strict';
	var msg = '';
	var name = $('.m_search_trial_add .name input').val();


	$.ajax({
		type: 'POST',
    url: gVar.root + '/module/search_trial_add/dist/sql_search.php',
    data: {
    	'name' : JSON.stringify(name)
    },
    dataType: 'json',
    success: function(results) {
    	$('.m_search_trial_add .searchResults').html(results.html);
    	console.log(results.sql);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
    	msg = 'Status: ' + textStatus + '\n' + 'Error: ' + errorThrown;
  		dialogError(msg);
    }   
  });
};



m_search_trial_add.parse = function() {
	'use strict';
	var obj = {
		arr: [],
		csv: ''
	};


	$('.m_search_trial_add input[type=checkbox]').each(function() {
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




$( document ).ready(function() {
	m_search_trial_add.watch();

});



