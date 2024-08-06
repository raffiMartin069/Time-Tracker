<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhereToNext | Employee</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/reports.css" />
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
                    <h4 style="margin: 0;">Daily Report</h4>
                    <div class="button-container" style="margin-left: 1rem;">
                        <a href="?page=dailyReport" style="text-decoration: none;">
                            <button class="btn btn-outline-success text-success text-center" style="width: 6.4rem;">Daily</button>
                        </a>
                        <a href="?page=weeklyReport" style="text-decoration: none;">
                            <button class="btn btn-outline-success text-success text-center" style="width: 6.4rem;">Weekly</button>
                        </a>
                        <a href="?page=biweeklyReport" style="text-decoration: none;">
                            <button class="btn btn-outline-success text-success text-center" style="width: 6.4rem;">Biweekly</button>
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
                        }

                        #reportsTableClockinTh,
                        #reportsTableClockinTd {
                            padding-left: 52px !important;
                            padding-right: 12px !important;
                            white-space: nowrap;
                        }
                    </style>
                    <table class="table align-middle mb-0 bg-white text-center" id="reportsTable">
                        <thead style="position: sticky; top: 0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <tr>
                                <th id="reportsTableClockinTh">Clock In</th>
                                <th>Lunch In</th>
                                <th>Lunch Out</th>
                                <th>Break Duration</th>
                                <th>Clock Out</th>
                                <th>Total Hours</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($results) && is_array($results)) : ?>
                                <?php
                                $currentDate = "";
                                foreach ($results as $report) :
                                    $reportDate = $report->getDATE();
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
                                ?>
                                    <tr class="employee-record" data-date="<?php echo $reportDate; ?>">
                                        <td hidden class="daily-id"><?php echo $report->getDAILYID(); ?></td>
                                        <td id="reportsTableClockinTd"><?php echo $report->getCLOCKIN(); ?></td>
                                        <td><?php echo $report->getLUNCHIN(); ?></td>
                                        <td><?php echo $report->getLUNCHOUT(); ?></td>
                                        <td class="viewBreaks">
                                            <?php
                                            if ($report->getTOTALBREAK() != 'N/A' && $report->getTOTALBREAK() != '') {
                                                echo $report->getTOTALBREAK();
                                                echo '<img src="' . ROOT . 'assets/img/breaks-down-arrow.png" class="img-fluid ms-2 view-breaks-btn" style="width: 20px;">';
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($report->getCLOCKOUT() != 'N/A' && $report->getCLOCKOUT() != '') {
                                                echo $report->getCLOCKOUT();
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $report->getHRSWORKED(); ?></td>
                                        <td>
                                            <form action="Admin/employeeDailyReport" method="post" target="_blank">
                                                <input type="hidden" name="name" value="<?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'N/A'; ?>">
                                                <input type="hidden" name="date" value="<?php echo $report->getDATE(); ?>">
                                                <input type="hidden" name="clockin" value="<?php echo $report->getCLOCKIN(); ?>">
                                                <input type="hidden" name="lunchduration" value="<?php echo $report->getLUNCHDURATION(); ?>">
                                                <input type="hidden" name="breakduration" value="<?php echo $report->getTOTALBREAK(); ?>">
                                                <input type="hidden" name="clockout" value="<?php echo $report->getCLOCKOUT(); ?>">
                                                <input type="hidden" name="hoursworked" value="<?php echo $report->getHRSWORKED(); ?>">
                                                <button type="submit" class="btn editDownloadBtns" id="download" style="width: 2.4rem; height: 2.05rem; border: none; border-radius: 5px; margin-right: -.1rem !important; margin-top: .5rem; margin-bottom: .5rem; background-color: #F9F9F9; border: 1.5px solid #DDDDDD;">
                                                    <img src="<?php ROOT ?>assets/img/download-pdf5.png" class="img-fluid downloadBtn" title="Download Report" style="max-width: 110%; margin-left:  -.5px;margin-right:10px;" />
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr class="break-details-row" style="display: none;">
                                        <td colspan="8">
                                            <div class="accordion" id="accordionBreaks<?php echo $report->getDAILYID(); ?>">
                                                <div class="accordion-item">
                                                    <h6 class="accordion-header" id="heading<?php echo $report->getDAILYID(); ?>">

                                                        <span class="ms-2 mt-1 mb-1" style="text-align: left; display: block;"><i class="lni lni-coffee-cup"></i><span class="ms-2">Break Periods</span></span>
                                                    </h6>
                                                    <div id="collapse<?php echo $report->getDAILYID(); ?>" class="accordion-collapse collapse show" aria-labelledby="heading<?php echo $report->getDAILYID(); ?>" data-bs-parent="#accordionBreaks<?php echo $report->getDAILYID(); ?>">
                                                        <div class="accordion-body">
                                                            Loading...
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= ROOT ?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="<?= ROOT ?>scripts/datePicker.js"></script>
    <script>
        var ROOT = '<?= ROOT ?>';
    </script> 
    <script defer src="<?= ROOT ?>scripts/employeeDailyReport.js"></script>
</body>

</html>
