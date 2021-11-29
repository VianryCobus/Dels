function periodDatepicker(){
    var dateFormat = "yy/mm/dd",
    from = $( "#start_date" )
        .datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        dateFormat  : "yy/mm/dd",
        numberOfMonths: 3
        })
    .on( "change", function() {
        to.datepicker( "option", "minDate", getDate( this,dateFormat ) );
    }),
    to = $( "#end_date" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        dateFormat  : "yy/mm/dd",
        numberOfMonths: 3
    })
    .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this,dateFormat ) );
    });
    function getDate( element,dateFormat ) {
        var date;
        try {
            date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
            date = null;
        }
        return date;
    }
}