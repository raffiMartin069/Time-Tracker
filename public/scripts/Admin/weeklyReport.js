 
    var dailyReportsModal = $("#myModal");
    var passwordModal = $("#passwordModal");
    // var errorModal = $("#errorModal");
    // var acknowledgementModal = $("#acknowledgementModal");
    var closeModal = $(".close");

    $(".clickMyDots").click(function() {
        var reportDate = $(this).closest('tr').find('.getmyreportdate').text();
        var empId = $(this).closest('tr').find('.getmyempid').text();

        console.log("Fetching reports for EMP_ID: " + empId + ", REPORT_DATE: " + reportDate);

        $.ajax({
            url: "Admin/fetchWeeklyDailyReports",
            method: 'GET',
            data: {
                report_date: reportDate,
                emp_id: empId
            },
            dataType: 'json',
            success: function(data) {
                var dailyReportsBody = $("#dailyReportsBody");
                dailyReportsBody.empty();

                if (data.length > 0) {
                    data.forEach(function(report) {
                        var row = `
                            <tr>   
                                <td>${report.DATE}</td>
                                <td>${report.CLOCK_IN}</td>
                                <td>${report.BREAK_IN}</td>
                                <td>${report.BREAK_OUT}</td>
                                <td>${report.BREAK_DURATION}</td> 
                                <td>${report.CLOCK_OUT}</td>
                                <td>${report.HRS_WORKED}</td>
                            </tr>
                        `;
                        dailyReportsBody.append(row);
                    });
                } else {
                    dailyReportsBody.html('<tr><td colspan="9">No daily reports found for this week.</td></tr>');
                }
                dailyReportsModal.show();
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                var errorMessage = xhr.responseJSON ? xhr.responseJSON.error : 'An error occurred while fetching data.';
                var dailyReportsBody = $("#dailyReportsBody");
                dailyReportsBody.html('<tr><td colspan="9">' + errorMessage + '</td></tr>');
                dailyReportsModal.show();
            }
        });
    });

    $(".approve-btn").click(function() {
        var wklyId = $(this).closest('tr').find('.getmywklyid').text();
        var apprStat = $(this).closest('tr').find('.getmyapprstat').text();

        if (apprStat === 'Awaiting approval') {
            passwordModal.data('wkly-id', wklyId).data('button', $(this)).show();
        } else {
            alert("This report has already been approved and cannot be changed.");
            // $('.modal-body').replaceWith("This report has already been approved and cannot be changed.");
            // $('#errorModal').modal('show');
            // $('#closeError').click(function() {
            //     $('#errorModal').modal('hide');
            // })
        }
    });

    $("#passwordForm").submit(function(event) {
        event.preventDefault();
        var wklyId = passwordModal.data('wkly-id');
        var password = $("#adminPassword").val();

        $.ajax({
            url: "Admin/fetchAcknowledgementData",
            method: 'GET',
            data: {
                wkly_id: wklyId,
                password: password
            },
            success: function(data) {
                var button = passwordModal.data('button');
                button.closest('tr').find('.getmyapprstat').text("Approved");
                button.text(data.acknowledgedBy);
                alert("You have successfully acknowledged this report!");
                // $('#acknowledgementModal').modal('show');
                // $('#closeAcknowledgementModal').click(function() {
                //     $('#acknowledgementModal').modal('hide');
                // })
                passwordModal.hide();
            },
            error: function(xhr, status, error) {
                // $('#modal-warning').modal('show');
                // $('#closeError').click(function() {
                //     $('#modal-warning').modal('hide');
                // })
                alert("Failed to acknowledge this report. Please try again.");
            }
        });
    });

     

    closeModal.click(function() {
        dailyReportsModal.hide();
        passwordModal.hide();
        // errorModal.hide();
        // acknowledgementModal.hide();
    });

    $(window).click(function(event) {
        if (event.target === dailyReportsModal[0]) {
            dailyReportsModal.hide();
        }
        if (event.target === passwordModal[0]) {
            passwordModal.hide();
        }
        // if (event.target === errorModal[0]) {
        //     errorModal.hide();
        // }
        // if (event.target === acknowledgementModal[0]) {
        //     acknowledgementModal.hide();
        // }
    });
 