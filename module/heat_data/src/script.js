var m_heat_data = {};



m_heat_data.create = function(type) {
  // Handle page-dependent changes.
  'use strict';
  var colHeaders = null;
  var colWidths = null;
  var readOnlyToggle = null;

  // If creating an editable version...
  if (type === 'write') {
    colHeaders = [  // HTML for table headers.
      '<span class="required">Heat #</span>',
      '<span class="required">Tap Year (YY)</span>',
      'BOP Vsl', 'Degas Vsl', 'Argon #', 'Caster #', 'Strand #', 'Comments'
    ];
    colWidths = [18, 25, 18, 18, 18, 18, 18]; // Table header widths.
    readOnlyToggle = false;
  } else {
    colHeaders = [  // HTML for table headers.
      '<span>Heat #</span>',
      '<span>Tap Year</span>',
      'BOP Vsl', 'Degas Vsl', 'Argon #', 'Caster #', 'Strand #', 'Comments'
    ];
    colWidths = [18, 18, 18, 18, 18, 18, 18]; // Table header widths.
    readOnlyToggle = true;
  }


  // Actual Handsontable creation.
  var $container = $(".m_heat_data .dataTable");


  $container.handsontable({
    colHeaders: colHeaders,
    colWidths: colWidths,
    manualColumnResize: true,
    columns: [
        {data: 0, type: 'text', readOnly: readOnlyToggle},
        {data: 1, type: 'text', readOnly: readOnlyToggle},
        {data: 2, type: 'text', readOnly: readOnlyToggle},
        {data: 3, type: 'text', readOnly: readOnlyToggle},
        {data: 4, type: 'text', readOnly: readOnlyToggle},
        {data: 5, type: 'text', readOnly: readOnlyToggle},
        {data: 6, type: 'text', readOnly: readOnlyToggle},
        {data: 7, type: 'text', readOnly: readOnlyToggle},
    ],
    rowHeaders: true,
    manualRowResize: true,
    minRows: 10,
    stretchH: 'all',
    scrollV: 'auto',
    columnSorting: true,
    contextMenu: true
  });

};



m_heat_data.populate = function (seq) {
  // Populate the table with data.
  'use strict';

  // If there isn't a trial sequence to search, return the function now.
  if (seq === '') {
    return;
  }

  var emptyRow = null;  // Initialize.
  var trialDataTable = $(".m_heat_data .dataTable").handsontable('getInstance');  // Store the pointer to the data table.


  // AJAX call to get the data for the table.
  $.ajax({
    type: 'POST',
    url: gVar.root + '/module/heat_data/dist/sql_read_heat_data.php',
    data: {
     'seq' : JSON.stringify(seq)
    },
    dataType: 'json',
    success: function(results) {
     trialDataTable.loadData(results);  // Load the data into the table.
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
      var dialog = new BootstrapDialog({
        title: 'Error',
        type: BootstrapDialog.TYPE_DANGER,
        message: 'Status: ' + textStatus + '\n' + 'Error: ' + errorThrown,
        closable: false,
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



m_heat_data.validate = function() {
  // Validate the data in the table.
  'use strict';
  var errorText = '';
  var heatData = $(".m_heat_data .dataTable").handsontable('getInstance').getData();
  var ht_num = null;
  var tap_yr = null;
  var emptyRow = null;


  // Loop thru each row in the table.
  $.each(heatData, function( index, row ) {
    ht_num = row[0];
    tap_yr = row[1];
    emptyRow = true;  //Initialize

    // If ht_num is only whitespace, make it null.
    if ( ifNull(ht_num, '').replace(/ /g,'').length === 0 ) {
      ht_num = null;
    }
    // If tap_yr is only whitespace, make it null.
    if ( ifNull(tap_yr, '').replace(/ /g,'').length === 0 ) {
      tap_yr = null;
    }
    

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
    });

    // If the row isn't empty.
    if (!emptyRow) {
      // If either required column is null.
      if ( (ht_num === null)  ||  (tap_yr === null) ) {
        errorText = "<li>'Heat #' and 'Tap Year' are required on all used rows in the heat data table.</li>";
      }
    }
  });

  return errorText;
};



m_heat_data.parse = function() {
  // Parse the data in the table. Should only occur after validating.
  'use strict';
  var emptyRow = null;
  var rawHeatData = $('.m_heat_data .dataTable').handsontable('getInstance').getData();
  var heatData = [];
  var ht_seq = 1;

  // Loop thru each row in the data.
  $.each(rawHeatData, function( index, row ) {
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
      row[index] = prepForSQL(value);
    });

    if (!emptyRow) {
      // Put the heat sequence number in the front of the row.
      row.unshift(ht_seq);

      // Add the row to the new array.
      heatData.push(row);
      
      ht_seq = ht_seq + 1;
    }
  });


  return heatData;
};









