$(document).ready(function(){
    $('#datePicker').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#datePicker').change(function(){
        var picker = $('#datePicker').val();
        var newURL = 'reports.php?date='+picker;
        window.location.replace(newURL);
        $(this).form.submit();

    })
});