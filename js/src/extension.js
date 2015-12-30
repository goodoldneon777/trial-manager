function isValidDate(str) {
  // Dependencies: momentjs.
  var d = moment(str);


  // If it doesn't contain 2 a hyphens (-), forward slashes (/), or back slashes (\).
  if ( ifNull(str.match(RegExp(/\-/g)), '').length != 2  &&  ifNull(str.match(RegExp(/\//g)), '').length != 2  &&  ifNull(str.match(RegExp(/\\/g)), '').length != 2 ) {
    return false;
  }

  // If it isn't a valid date.
  if (!d.isValid()) {
  	return false;
  }

  return true;
}



function stringToDate(str) {
  // Dependencies: momentjs.
  var d = moment(str);


  // Fix for when IE defaults to 19** dates.
  if (d.year() < 2000) {
    d.add(100, 'year');
  }

  return d;
}



function prepForSQL(val, type) {
  if (val !== null) {
    val = val.replace(/'/g, "''");  //Escape single quotes.
    val = val.replace(/\\/g, "\\\\");  //Escape backslashes.
  }

  if ( (type === 'date')  &&  (val !== '') ) {
    val = stringToDate(val);
    val = moment(val).format("YYYY/M/D HH:mm");
  }

	if ( (val === '')  ||  (val === null) ) {
		return 'NULL';
	} else {
		return "'" + val + "'";
	}

}



function getURLVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0; i<vars.length; i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
      return pair[1];
    }
  }

  return false;
}



function removeChar(str, char) {
  return str.split(char).join('');
}



function countChar(str, char) {
  var search = '/\\' + char + '/g';
  return str.match(RegExp(search)).length;
}



function ifNull(val, replace) {
  if (val === null) {
    return replace;
  } else {
    return val;
  }
}



function getSeqFromAttrClass(attrClass) {
  'use strict';
  var classArr = attrClass.split(' ');
  var classSeq = $.grep(classArr, function(v, i){
    return v.indexOf('seq') === 0;
  }).join();
  var seq = classSeq.substring(classSeq.indexOf('seq-') + ('seq-').length);
  var obj = {
    seq: seq,
    classSeq: classSeq
  };

  return obj;
}



function dialogWarn(msg) {
  'use strict';

  BootstrapDialog.alert({
    title: '<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;&nbsp;Warning',
    type: BootstrapDialog.TYPE_WARNING,
    message: msg
  });
}



function dialogError(msg) {
  'use strict';

  BootstrapDialog.alert({
    title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
    type: BootstrapDialog.TYPE_DANGER,
    message: msg
  });
}



function uniqueArr(arr, colArr) {
  'use strict';
  var arr = arr.slice();
  if (typeof colArr === "undefined") {  //If colArr wasn't specified.
    colArr = null;  //colArr an array of columns. These are the columns that will be inspected for duplicates. Any columns not in this array will not be considered when looking for duplicates.
  }
  var testArr = [];
  var testRow = [];
  


  if (colArr !== null) {  //If the user specified columns.
    //Build the "test" array which will be used to identify duplicates.
    $.each(arr, function(indexRow, arrRow) {  //Loop thru rows in arr.
      testRow = []; //Initialize array that will temporarily hold each row for testArr.

      $.each(arrRow, function(indexCol, valueCell) {  //Loop thru columns in the current row of arr.
        if ($.inArray(indexCol, colArr) >= 0) { //If the current column is specified in colArr.
          testRow.push(valueCell);  //Push the current cell value into testRow.
        }
      });

      if (testRow.length > 0) { //If testRow contains at 1 value.
        testArr.push(testRow);  //Push testRow into testArr.
      }
    });
  } else {  //If the user didn't specify columns.
    testArr = arr.slice();  //Test array is the same as the "real" (passed in) array.
  }


  //Loop thru the test array looking for duplicates. Will remove any duplcates.
  for(var index = 0; index < testArr.length; index++) { //Must be a 'for' loop insead of 'each' since there will be splicing.
    var row = testArr[index]; //Current row.
    var testArrRemaining = testArr.slice(index + 1, testArr.length);  //Everything in the test array AFTER the current element.
    var unique = true;  //Initialize the "unique" variable. This will be changed to false if a duplicate is found.

    $.each(testArrRemaining, function(indexSub, rowSub) { //Loop thru the remaining rows in the test array.
      if (JSON.stringify(row) === JSON.stringify(rowSub)) { //If the current element (in the parent loop) matches an element in the rest of the test array.
        unique = false;
      }
    });


    if (unique === false) { //If a duplicate was found.
      testArr.splice(index, 1); //Remove that index in the test array.
      arr.splice(index, 1); //Remove that index in the "real" (passed in) array.
      index--;  //Increment index down since an element was spliced.
    }

  };


  return arr;
}