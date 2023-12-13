/* ADMIN PAGE JS */
$(document).ready(function(){
    $('#viewSummary').on("click", function(){
        let payType = $('#payType').val();
        let txtCus = $('#txtCus').val();
        let txtPayamount = $('#txtPayamount').val();
        let txtmobnumber = $('#txtmobnumber').val();
        let txtNote = $('#txtNote').val();
        let txtrefnum = $('#txtrefnum').val();

        if(payType == "" || txtCus == "" || txtPayamount == "" || txtmobnumber == "" || txtrefnum == ""){
            $('.error').html("Incomplete details");
            $('#summaryModal').modal("hide");
        }else{
            $('#payType1').val(payType);
            $('#txtCus1').val(txtCus);
            $('#txtrefnum1').val(txtrefnum);
            $('#txtPayamount1').val(txtPayamount);
            $('#txtmobnumber1').val(txtmobnumber);
            if(txtNote == ""){
                $('#txtNote1').val("EMPTY...");
            }else{
                $('#txtNote1').val("Customer Message: " + txtNote);
            }
            $('#summaryModal').modal("show");
            $('#myModal').modal("hide");
        }
    });
});

$(document).ready(function(){
    let refNumInputAdded = false;
    $('#payType').change(function(){
        let payType = $(this).val();
        if ((payType == "GCash" || payType == "Bank Transfer") && !refNumInputAdded) {
            $('#payType').after("<input type='text' name='refNum' id='txtrefnum' class='placeText' placeholder='Reference Number'>");
            refNumInputAdded = true;
        } else if (payType != "GCash" && payType != "Bank Transfer" && refNumInputAdded) {
            $('input[name="refNum"]').remove();
            refNumInputAdded = false;
        }
    })
});

$(document).ready(function () {
    $("#search").on("input", function () {
        var searchTerm = $(this).val().toLowerCase();
        var $cards = $("#item-list .card");

        $cards.each(function () {
            var productDetails = $(this).text().toLowerCase();
            var matchesSearchTerm = productDetails.includes(searchTerm) || searchTerm === "";
            $(this).toggle(matchesSearchTerm);
        });
    });
    $("#item-list").on("click", "button[name='addList']", function () {
        $(this).closest('form').submit();
    });
});

$(document).ready(function(){
    var grndTotal = parseFloat($('.totals').val());

    $('#txtPayamount').on("input", function(){
        var payamount = parseFloat($('#txtPayamount').val());

        if(isNaN(grndTotal) || isNaN(payamount)) {
            $('.error').html("Invalid input");
        } else if(payamount >= grndTotal) {
            $('.error').html("");
        } else {
            $('.error').html("Invalid Payment Amount");
        }
    });
});
/* END ADMIN PAGE JS */

/* REPORT Page JS */
function printData()
        {
            var divToPrint=document.getElementById("reports");
            newWin= window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }

        $('#btn-print').on('click',function(){
            printData();
})

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
/* END REPORT JS */

/* Verify Page JS */

$(document).ready(function() {
    $("#btn-verify").on("click", function() {
        var enteredOtp = $("#txtotp1").val() + $("#txtotp2").val() + $("#txtotp3").val() + $("#txtotp4").val();
        var otp = $("#otp").val();

        if (enteredOtp === otp) {
            var accRole = $("#accRole").val();
            var accUsername = $("#accUsername").val();
            var accPassword = $("#accPassword").val();
            var otpNumber = $("#otpNumber").val();
            var accNickname = $("#accNickname").val();
            var accbirthdate = $("#accbirthdate").val();
            var accAge = $("#accAge").val();
            var accGender = $("#accGender").val();

            $.ajax({
                type: "POST",
                url: "verifysql.php",
                data: {
                    btn_verify: true,
                    accRole: accRole,
                    accUsername: accUsername,
                    accPassword: accPassword,
                    otpNumber: otpNumber,
                    accNickname: accNickname,
                    accbirthdate: accbirthdate,
                    accAge: accAge,
                    accGender: accGender,
                },
                success: function(response) {
                    if (response = "success") {
                        alert('Áccount successfully Registered');
                        window.location.href = "otpmessage.php";
                    } else {
                        console.log(response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            if(enteredOtp == ""){
                $("#error").html("<div class='text-center mt-5'><span class='fw-bold'>Enter a Code</span></div>");
            }else{
                $("#error").html("<h3 class='text-white bg-danger text-center'>The code you entered is invalid!</h3>");
            }
        }
    });
});

//RESPONSIVENESS
$(document).ready(function(){
    $('#menu-toggle').click(function(){
        $('.dropdown_menu').slideToggle(this.checked);
    })
    $(window).resize(function(){
        if ($(window).width() > 1600) {
            $('.dropdown_menu').hide();
        }
    });
})