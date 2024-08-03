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
                    <h4 style="margin: 0;">Biweekly Report</h4>
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
                        <input type="number" id="searchInput" class="searchWeeklyId" placeholder="Search Biweekly ID">
                    </div>

                </div>
                <div>
                    <table class="table align-middle mb-0 bg-white text-center" id="reportsTable">
                        <thead style="position: sticky; top: 0;">
                            <tr>
                                <th>Biweekly ID</th>
                                <th>Report Date</th>
                                <th>Status</th>
                                <th>Acknowledged By</th>  
                                <th>Daily Stamps</th>
                                <th>Biweekly Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($results) && is_array($results)) : ?>
                                <?php foreach ($results as $report) : ?>
                                    <tr>
                                        <td><?php echo $report->getBIWKLYID(); ?></td>
                                        <td class="getmyreportdate"><?php echo $report->getREPORTDATE(); ?></td>
                                        <td><?php echo $report->getAPPRSTAT(); ?></td>
                                        <td><?php echo $report->getACKNOWLEDGED_BY(); ?></td>
                                        <td><img class="clickMyDots" src="<?= ROOT ?>assets/img/employee/dots.svg"></td>
                                        <td><?php echo $report->getTOTALHRS(); ?></td> 
                                     </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7">No data found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
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
 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= ROOT ?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            var modal = $("#myModal"); 

            $(".clickMyDots").click(function() {
                var reportDate = $(this).closest('tr').find('.getmyreportdate').text();
                var empId = <?php echo $_SESSION["userId"]; ?>
 
                $.ajax({
                    url: "Employee/fetchBiweeklyDailyReports",
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
                            dailyReportsBody.html('<tr><td colspan="6">No daily reports found for this week.</td></tr>');
                        }

                        modal.show();
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        var errorMessage = xhr.responseJSON ? xhr.responseJSON.error : 'An error occurred while fetching data.';
                        var dailyReportsBody = $("#dailyReportsBody");
                        dailyReportsBody.html('<tr><td colspan="6">' + errorMessage + '</td></tr>');
                        modal.show();
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

            $(window).click(function(event) {
                if (event.target === modal[0]) {
                    modal.hide();
                }
            });
        });
    </script>
    <script src="<?= ROOT ?>scripts/Admin/sidebar.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>

</html>