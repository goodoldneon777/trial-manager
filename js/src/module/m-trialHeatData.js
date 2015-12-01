var m_trialHeatData = {};


m_trialHeatData.create = function(type) {
  // Handle page-dependent changes.
  var colHeaders = null;
  var colWidths = null;

  if (type === 'write') {
    colHeaders = [
      '<span class="required">Heat #</span>',
      '<span class="required">Tap Year (YY)</span>',
      'BOP Vsl', 'Degas Vsl', 'Argon #', 'Caster #', 'Strand #', 'Comments'
    ];
    colWidths = [18, 25, 18, 18, 18, 18, 18];
  } else {
    colHeaders = [
      '<span>Heat #</span>',
      '<span>Tap Year</span>',
      'BOP Vsl', 'Degas Vsl', 'Argon #', 'Caster #', 'Strand #', 'Comments'
    ];
    colWidths = [18, 18, 18, 18, 18, 18, 18];
  }


  // Actual Handsontable creation.
  var $container = $("#m-trialHeatData .dataTable");


  $container.handsontable({
    colHeaders: colHeaders,
    // colHeaders: [
    // 	'<span' + columnClass +'>Heat #</span>',
    // 	'<span' + columnClass +'>Tap Year</span>',
    // 	'BOP Vsl', 'Degas Vsl', 'Argon #', 'Caster #', 'Strand #', 'Comments'
    // ],
    colWidths: colWidths,
    manualColumnResize: true,
    columns: [
        {data: 0, type: 'text'},
        {data: 1, type: 'text'},
        {data: 2, type: 'text'},
        {data: 3, type: 'text'},
        {data: 4, type: 'text'},
        {data: 5, type: 'text'},
        {data: 6, type: 'text'},
        {data: 7, type: 'text'},
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



m_trialHeatData.populate = function (trialSeq) {
  'use strict';

  // If there isn't a trial sequence to search, return the function now.
  if (trialSeq === '') {
    return;
  }

  var emptyRow = null;
  var trialDataTable = $("#m-trialHeatData .dataTable").handsontable('getInstance');


  $.ajax({
    type: 'POST',
    url: 'php/dist/sql-read-trialData.php',
    data: {
     'trialSeq' : JSON.stringify(trialSeq)
    },
    dataType: 'json',
    success: function(results) {
     trialDataTable.loadData(results);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
      alert(
       'Status: ' + textStatus + '\n' +
       'Error: ' + errorThrown
      );
    }
  });
};



m_trialHeatData.validate = function() {
  var errorText = '';
  var heatData = $("#m-trialHeatData .dataTable").handsontable('getInstance').getData();
  var ht_num = null;
  var tap_yr = null;
  var emptyRow = null;


  $.each(heatData, function( index, row ) {
    ht_num = row[0];
    tap_yr = row[1];
    emptyRow = true;  //Initialize

    $.each(row, function( index, value ) {
      if (value !== null  ||  ifNull(value, '').replace(/ /g,'').length > 0) {
        emptyRow = false;
      }
    });

    if (!emptyRow) {
      if ( (ht_num === null)  ||  (tap_yr === null) ) {
        errorText = "<li>'Heat #' and 'Tap Year' are required on all used rows in the heat data table.</li>\n";
      }
    }
  });

  return errorText;
};



m_trialHeatData.parse = function() {
  'use strict';

  var emptyRow = null;
  var rawHeatData = $('#m-trialHeatData .dataTable').handsontable('getInstance').getData();
  var heatData = [];

  $.each(rawHeatData, function( index, row ) {
    emptyRow = true;  //Initialize

    $.each(row, function( index, value ) {
      if (value !== null) {
        emptyRow = false;
      }
      row[index] = prepForSQL(value);
    });

    if (!emptyRow) {
      heatData.push(row);
    }
  });


  return heatData;
};


