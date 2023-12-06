$(document).ready(function(){
    $('#datePicker').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#datePicker').change(function(){
        var picker = $('#datePicker').val();
        //picker = $('#txtcal').text;
        var newURL = 'reports.php?date='+picker;
        window.location.replace(newURL);
        $(this).form.submit();
    });
});

$(document).ready(function(){
    $('#startDate').datepicker();
    $('#endDate').datepicker();
    $('#startDate').datepicker("option", "dateFormat", "yy-mm-dd");
    $('#endDate').datepicker("option", "dateFormat", "yy-mm-dd");

    $('#startDate').datepicker({onSelect:function(selectedDate){
        $('#endDate').datepicker("option","minDate",selectedDate);
        }
    });
    $('#endDate').datepicker({onSelect:function(selectedDate){
        $('#startDate').datepicker("option","maxDate",selectedDate);
        }
    });
});
