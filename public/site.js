
showMore = function (rowId, arraySize) {
   $('.'+rowId).toggleClass('hideRow');

   if ($('.showHideBtn-'+rowId).html() == 'Show more...')
       $('.showHideBtn-'+rowId).html('Show less...');
   else
       $('.showHideBtn-'+rowId).html('Show more...');

   if ($('#'+rowId).attr('rowspan') > 3)
       $('#'+rowId).attr('rowspan', '3');
   else
       $('#'+rowId).attr('rowspan', arraySize + 1);
};

