  $( function() {
      // This attaches the JQuery UI Datepicker logic to all the date input fields
    $( ".datepicker" ).datepicker();

    // This sets the initial date of each JQuery UI Datepicker instance to the
    // initial value of the input field that it's attached to 
    // (which allows it to grab the value from PHP)

    $( ".datepicker").each(function( elem, object ) {
        thisdate = $(object).val();
        $(this).datepicker('setDate', new Date(thisdate));
    } );
   
    // This tells all the JQuery UI Datepicker instances to use the date format
    // that we want
    $( ".datepicker").datepicker("option", "dateFormat", "MM d, yy");




  } );