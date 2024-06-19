<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhereToNext | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/reports.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/reportsModals.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/search.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/tables.css" />
</head>

<body>
    <div id="wrapper">
        <div class="px-2" style="padding-top: 2.5rem;">
            <div class="container"></div>
        </div>
        <div class="mx-2 my-4 rounded p-2 shadow reports-body" style="margin-top: -2rem !important;">
            <div class="container">
                <br>
                <div class="reports-header d-flex flex-wrap align-items-center" style="font-weight: 600;">
                    <h4 style="margin: 0;">Weekly Report</h4>
                    <div class="button-container" style="margin-left: 1rem;">
                        <a href="?page=dailyReport" style="text-decoration: none;">
                            <button class="btn btn-outline-success text-success text-center" style="width: 6.4rem;">Daily</button>
                        </a>
                        <a href="?page=weeklyReport" style="text-decoration: none;">
                            <button class="btn btn-outline-success text-success text-center" style="width: 6.4rem;">Weekly</button>
                        </a>
                        <a href="?page=biweeklyReport" style="text-decoration: none;">
                            <button class="btn btn-outline-success text-success text-center" style="width: 6.4rem;">Bi-weekly</button>
                        </a>
                    </div>

                    <div class="search">
                        <input type="number" id="searchInput" class="searchWeeklyId" placeholder="Search Weekly ID">
                    </div>

                </div>
                <div>
                    <table class="table align-middle mb-0 bg-white text-center" id="reportsTable">
                        <thead style="position: sticky; top: 0;">
                            <tr>
                                <th>Weekly ID</th>
                                <th>Date</th>
                                <th>Weekly Total</th>
                                <th>Daily Stamps</th>
                                <th>Tracker ID</th>
                                <th>Employee Name</th>
                                <th>Status</th>
                                <th>Acknowledged By</th>
                            </tr>
                        </thead>
                        <tbody id="reportTableBody">
                            <?php if (!empty($results) && is_array($results)) : ?>
                                <?php foreach ($results as $report) : ?>
                                    <tr class="table-row">
                                        <td class="getmywklyid"><?php echo $report->getWKLYID(); ?></td>
                                        <td class="getmyreportdate"><?php echo $report->getREPORTDATE(); ?></td>
                                        <td><?php echo $report->getTOTALHRS(); ?></td>
                                        <td><img class="clickMyDots" src="<?= ROOT ?>assets/img/employee/dots.svg"></td>
                                        <td class="getmyempid"><?php echo $report->getEMPID(); ?></td>
                                        <td><?php echo $report->getEMPNAME(); ?></td>
                                        <td class="getmyapprstat"><?php echo $report->getAPPRSTAT(); ?></td>
                                        <td><button class="text-white approve-btn" id="getmyadminname" style="font-size: 12px; background-color: #009DFE; border: none; border-radius: 10px;"><?php echo $report->getACKNOWLEDGEDBY(); ?></button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8">No data found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for daily reports -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <table class="summary-table table align-middle mb-0 bg-white text-center">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Clock In</th>
                        <th>Break In</th>
                        <th>Break Out</th>
                        <th>Break Duration</th>
                        <th>Clock Out</th>
                        <th>Daily Total</th>
                    </tr>
                </thead>
                <tbody id="dailyReportsBody">
                </tbody>
            </table>
        </div>
    </div>

    <!-- Password Confirmation Modal -->
    <div id="passwordModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h5>Enter Password to Confirm</h5>
            <form id="passwordForm" method="post">
                <div class="form-group">
                    <label for="adminPassword">Password:</label>
                    <input type="password" id="adminPassword" name="adminPassword" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>  

    <!-- jQuery and Bootstrap Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= ROOT ?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            var dailyReportsModal = $("#myModal");
            var passwordModal = $("#passwordModal");
             
            $(".clickMyDots").click(function() {
                var reportDate = $(this).closest('tr').find('.getmyreportdate').text();
                var empId = $(this).closest('tr').find('.getmyempid').text();

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
    </script>
    <script src="<?= ROOT ?>scripts/Admin/sidebar.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>

</html>