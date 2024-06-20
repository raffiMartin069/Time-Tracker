(() => {
    $(document).ready(function() {
        var dailyReportsModal = $("#myModal");
        var passwordModal = $("#passwordModal");

        $(".clickMyDots").click(function() {
            var reportDate = $(this).closest('tr').find('.getmyreportdate').text();
            var empId = $(this).closest('tr').find('.getmyempid').text();

            $.ajax({
                url: "Admin/fetchBiweeklyDailyReports",
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
                    var errorMessage = xhr.responseJSON ? xhr.responseJSON.error : 'An error occurred while fetching data.';
                    var dailyReportsBody = $("#dailyReportsBody");
                    dailyReportsBody.html('<tr><td colspan="9">' + errorMessage + '</td></tr>');
                    dailyReportsModal.show();
                }
            });
        });

        $(".approve-btn").click(function() {
            var biWklyId = $(this).closest('tr').find('.getmybiwklyid').text();
            var apprStat = $(this).closest('tr').find('.getmyapprstat').text();

            if (apprStat === 'Awaiting approval') {
                passwordModal.data('bi-wkly-id', biWklyId).data('button', $(this)).show();
            } else {
                alert("This report has already been approved and cannot be changed.");
            }
        });

        $("#passwordForm").submit(function(event) {
            event.preventDefault();
            var biWklyId = passwordModal.data('bi-wkly-id');
            var password = $("#adminPassword").val();

            $.ajax({
                url: "Admin/fetchBiweeklyAcknowledgementData",
                method: 'GET',
                data: {
                    bi_wkly_id: biWklyId,
                    password: password
                },
                success: function(data) {
                    var button = passwordModal.data('button');
                    button.closest('tr').find('.getmyapprstat').text("Approved");
                    button.text(data.acknowledgedBy);
                    passwordModal.hide();
                },
                error: function(xhr, status, error) {
                    alert("Failed to acknowledge this report. Please try again.");
                }
            });
        });

        // Search function 
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            const filter = searchInput.value.trim();
            const tableRows = document.querySelectorAll('.table tbody tr');

            tableRows.forEach(row => {
                const weeklyIdCell = row.querySelector('td:first-child');
                if (weeklyIdCell) {
                    const txtValue = weeklyIdCell.textContent || weeklyIdCell.innerText;
                    const rowDisplay = txtValue.indexOf(filter) > -1 ? '' : 'none';
                    row.style.display = rowDisplay;
                }
            });
        });

        dailyReportsModal.hide();
        passwordModal.hide(); 

        $(window).click(function(event) {
            if (event.target === dailyReportsModal[0]) {
                dailyReportsModal.hide();
            }
            if (event.target === passwordModal[0]) {
                passwordModal.hide();
            }
        });
    });
})