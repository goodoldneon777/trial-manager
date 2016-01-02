var m_lookup = {};



m_lookup.start = function() {
	'use strict';


	m_lookup.watch();
	m_lookup.createInputTable();
};



m_lookup.watch = function() {
	'use strict';


	$('.m_lookup .c_submitBtn .submit').click(function() {		//Watch for clicking the submit button.
		m_lookup.submit();
	});
};



m_lookup.validate = function() {
  // Validate the data in the table.
  'use strict';
  var errorText = '';
  var id = null;
  var tap_yr = null;
  var emptyRow = null;

  inputArr = m_lookup.parse();


  //Test for missing required fields.
  $.each(inputArr, function( index, row ) {
    id = row[1];
    tap_yr = row[2];

    if (id === "NULL") {
      id = null;
    }

    if (tap_yr === "NULL") {
      tap_yr = null;
    }

    // If either required column is null.
    if ( (id === null)  ||  (tap_yr === null) ) {
      errorText += "<li>'ID' and 'Tap Year' are required on all used rows in the input table.</li>";

      return false; //Exit the 'each' loop. Most be 'return false' for the loop exit to work.
    }
  });


  //Test for improper year format.
  $.each(inputArr, function( index, row ) {
    tap_yr = row[1];

    if (tap_yr !== null) {
      if (tap_yr.length !== 2) {
        errorText += "<li>'Tap Year' must be in 'YY' format (e.g. 15 for 2015) in the input table.</li>";

        return false; //Exit the 'each' loop. Most be 'return false' for the loop exit to work.
      }
    }
  });


  return errorText;
};



m_lookup.submit = function() {
	var errorText = '';
	var errorList = '';
	var msg = '';
	
	inputArr = m_lookup.parse();

// console.log(inputArr);

	errorText = m_lookup.validate();


	//If there weren't any errors
	if (errorText.length === 0) {
		$('.m_lookup .c_errorBox .content').html('');


		//Run the function that searches the DB.
		m_lookup.search();

	} else {	//If there was at least 1 error
		//Build the HTML for the error dialog.
		errorList =
			'<h3>Please fix these items:</h3>' +
			'<div class="errorList">' +
			'  <ul>' + errorText + '</ul>' +
			'</div>';

		//Alert the user with the errors.
		msg = errorList;
  	dialogError(msg);

		//Build the HTML for the embedded error box.
		errorText =
			'<div class="alert alert-danger">' +
			'    <ul>' + errorText + '</ul>' +
			'</div>';

		//Update the embedded error box with the errors.
		$('.m_lookup .c_errorBox .content').html(errorText);

	}



return;
	//Run the function that searches the DB.
	m_lookup.search();

};



m_lookup.search = function() {
	'use strict';
	var msg = '';
	var input = m_lookup.parse();
	var pageType = getURLVariable('type');	//Get the page type from the URL.
	if (pageType !== 'group') {
		pageType = 'trial';
	}


	$.ajax({
		type: 'POST',
    url: gVar.root + '/module/lookup/dist/sql_search.php',
    data: {
    	'input' : JSON.stringify(input),
    	'pageType' : JSON.stringify(pageType)
    },
    dataType: 'json',
    success: function(results) {
    	$('.m_lookup .c_results').html(results.html);
    	console.log(results.sql);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
    	msg = 'Status: ' + textStatus + '\n' + 'Error: ' + errorThrown;
  		dialogError(msg);
    }   
  });

};



m_lookup.createInputTable = function() {
  // Handle page-dependent changes.
  'use strict';
  var colHeaders = null;
  var colWidths = null;
  var readOnlyToggle = null;


  colHeaders = [  // HTML for table headers.
    '<span class="required">ID</span>',
    '<span class="required">Tap Year (YY)</span>'
  ];
  // colWidths = [18, 25, 18, 18, 18, 18, 18]; // Table header widths.
  // readOnlyToggle = false;


  // Actual Handsontable creation.
  var $container = $(".m_lookup .inputTable");


  $container.handsontable({
    colHeaders: colHeaders,
    colWidths: colWidths,
    manualColumnResize: true,
    columns: [
        {data: 0, type: 'text'},
        {data: 1, type: 'text'}
    ],
    rowHeaders: false,
    manualRowResize: true,
    minRows: 10,
    minSpareRows: 1,
    stretchH: 'all',
    scrollV: 'auto',
    columnSorting: true,
    contextMenu: true
  });

};



m_lookup.parse = function() {
  // Parse the data in the table. Should only occur after validating.
  'use strict';
  var emptyRow = null;
  var rawData = $('.m_lookup .inputTable').handsontable('getInstance').getData();
  var finalData = [];

  // Loop thru each row in the data.
  $.each(rawData, function( index, row ) {
    emptyRow = true;  //Initialize

    // Loop thru each cell in the row.
    $.each(row, function( index, value ) {
      // If the cell is only whitespace.
      if ( ifNull(value, '').replace(/ /g,'').length === 0 ) {
        value = null;
      }

      // If there is a value in the cell, flag row as not empty.
      if ( value !== null ) {
        emptyRow = false;
      }

      // Prep the value for SQL.
      row[index] = value;
    });

    if (!emptyRow) {
      // Add the row to the new array.
      finalData.push(row);
    }
  });


  return finalData;
};




$( document ).ready(function() {
    m_lookup.start();
});