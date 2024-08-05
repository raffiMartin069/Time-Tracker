<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhereToNext | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/reports.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/reportsModals.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/tables.css">
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/reportsDateHeader.css">
    <link rel="stylesheet" href="<?= ROOT ?>css/reportsDateFilter.css">
    <link rel="stylesheet" href="<?= ROOT ?>css/reportsBtns.css">
    <link rel="stylesheet" href="<?= ROOT ?>css/reportsBreaks.css">
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

                    <div class="date-filter">
                        <div class="input-group">
                            <input type="text" placeholder="Choose date range" id="dateRangePicker" class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text" id="filterDateRange" title="Filter Reports"><i class="fas fa-filter"></i></span>
                                <span class="input-group-text" id="resetDate" title="Undo Filter"><i class="fas fa-redo"></i></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div>
                    <style>
                        #reportsTable th,
                        #reportsTable td {
                            width: 15% !important;
                            white-space: nowrap;
                        }

                        #reportsTableIdTh,
                        #reportsTableIdTd {
                            padding-left: 3rem !important;
                        } 
                    </style>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0 bg-white text-center" id="reportsTable">
                            <thead style="position: sticky; top: 0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                <th hidden>Weekly ID</th>
                                <th id="reportsTableIdTh">Employee ID</th>
                                <th>Name</th>
                                <th>Total Biweekly Hours</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="reportTableBody">
                                <?php if (!empty($results) && is_array($results)) : ?>
                                    <?php
                                    $currentDate = "";
                                    foreach ($results as $report) :
                                        $reportDate = $report->getREPORTDATE();
                                        $dateTime = new DateTime($reportDate);
                                        $formattedDate = $dateTime->format('j M Y');
                                        $dayOfWeek = $dateTime->format('D');

                                        if ($currentDate != $reportDate) {
                                            if ($currentDate != "") {
                                                echo '</tr>';
                                            }
                                            $currentDate = $reportDate;
                                            echo '<tbody>';
                                            echo '<tr class="date-header">';
                                            echo '<td colspan="9" style="background-color: #F6F6F7;">';
                                            echo '<span>';
                                            echo '<img src="' . ROOT . 'assets/img/calendar.png" class="img-fluid" style="max-width:20px;" /> <p>' . $dayOfWeek . ', ' . $formattedDate . '</p>';
                                            echo '</span>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }

                                        $empId = $report->getEMPID();
                                        $defaultPhoto = ROOT . "assets/img/employee/default-settings-profile.png";
                                        $getProfilePhoto = $defaultPhoto;

                                        if ($empId) {
                                            $returnQuery = "SELECT image FROM employee_credential WHERE emp_id = :emp_id";
                                            $returnParams = [
                                                ':emp_id' => $empId
                                            ];
                                            $returnData = $this->Query($returnQuery, $returnParams);

                                            if (!empty($returnData) && !empty($returnData[0]->image)) {
                                                $getProfilePhoto = $returnData[0]->image;
                                            }
                                        }
                                    ?>
                                        <tr class="employee-record" data-date="<?php echo $reportDate; ?>">
                                            <td class="getmybiwklyid" hidden><?php echo $report->getBIWKLYID(); ?></td>
                                            <td class="getmyempid" id="reportsTableIdTd"><?php echo $report->getEMPID(); ?></td>
                                            <td class="employee-name">
                                                <img src="<?php echo $getProfilePhoto; ?>" alt="Profile Picture">
                                                <?php echo $report->getEMPNAME(); ?>
                                            </td>
                                            <td hidden class="getmyreportdate"><?php echo $report->getREPORTDATE(); ?></td>
                                            <td><?php echo $report->getTOTALHRS(); ?></td>
                                            <td>
                                                <button type="submit" class="btn clickMyDots" id="previewBtn" style="width: 2.4rem; height: 2.05rem; border: none; border-radius: 0; border-right: none !important; margin-right: 2.3rem !important; margin-top: 1rem; background-color: #F9F9F9; border: 1.5px solid #DDDDDD; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
                                                    <img src="<?php ROOT ?>assets/img/view30.png" class="img-fluid ms-2" title="View Daily Reports" style="max-width:87%;  margin-left: .1rem !important;" />
                                                </button>

                                                <form action="Admin/employeeBiweeklyReport" method="post" target="_blank" class="biweeklyDownload">
                                                    <input type="hidden" name="name" value="<?php echo $report->getEMPNAME(); ?>">
                                                    <input type="hidden" name="totalbiweeklyhrs" value="<?php echo $report->getTOTALHRS(); ?>">

                                                    <button type="submit" class="btn downloadBtn" id="downloadBtn" style="width: 2.4rem; height: 2.05rem; border: none; border-radius:0; margin-right: -2.5rem !important; margin-top: -2.05rem; background-color: #F9F9F9; border: 1.5px solid #DDDDDD; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                                                        <img src="<?php ROOT ?>assets/img/download-pdf5.png" class="img-fluid" title="Download Report" style="max-width: 110%; margin-left: -.1rem;" />
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7">No data found.</td>
                                    </tr>
                                <?php endif; ?>
                                <tr id="displayNoReportsFound" style="display: none;">
                                    <td colspan="9">No reports found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- This is the daily reports modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <table class="summary-table table align-middle mb-0 bg-white text-center">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Clock In</th>
                        <th>Lunch In</th>
                        <th>Lunch Out</th>
                        <th>Break Taken</th>
                        <th>Clock Out</th>
                        <th>Total Hours</th>
                    </tr>
                </thead>
                <tbody id="dailyReportsBody">
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery and Bootstrap Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= ROOT ?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script defer src="<?= ROOT ?>scripts/datePicker.js"></script>
    <script>
        var ROOT = '<?= ROOT ?>';
    </script>
    <script defer src="<?= ROOT ?>scripts/Admin/adminBiweeklyReport.js"></script>
</body>

</html>
