<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhereToNext | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/reports.css" /> 
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css" />
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
                            <button class="btn btn-outline-success text-success text-center">Daily</button>
                        </a>
                        <a href="?page=weeklyReport" style="text-decoration: none;">
                            <button class="btn btn-outline-success text-success text-center">Weekly</button>
                        </a>
                        <a href="?page=biweeklyReport" style="text-decoration: none;">
                            <button class="btn btn-outline-success text-success text-center">Bi-weekly</button>
                        </a> 
                    </div>  
                </div>
                <div>
                    <table class="table align-middle mb-0 bg-white text-center">
                        <thead class="table-light">
                            <tr>   
                                <th>Date</th>
                                <th>Clock In</th> 
                                <th>Break In</th>
                                <th>Break Out</th> 
                                <th>Break Duration</th>
                                <th>Clock Out</th>
                                <th>Daily Total</th>
                                <!-- <th>Status</th>
                                <th>Acknowledged By</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($results) && is_array($results)) : ?>
                                <?php foreach ($results as $report) : ?>
                                    <tr> 
                                        <td><?php echo $report->getDATE(); ?></td>
                                        <td><?php echo $report->getCLOCKIN(); ?></td>
                                        <td><?php echo $report->getBREAKIN(); ?></td>
                                        <td><?php echo $report->getBREAKOUT(); ?></td>
                                        <td><?php echo $report->getDURATION(); ?></td>
                                        <td><?php echo $report->getCLOCKOUT(); ?></td>
                                        <td><div style="display: inline-block; font-size: 14px; color: #198754; background-color: #A6E7D8; border-radius: 10px; width: 6rem;"><?php echo $report->getHRSWORKED(); ?></div></td>
                                         <!-- <td><?php echo $report->getAPPRSTAT(); ?></td>
                                        <td><?php echo $report->getACKNOWLEDGEDBY(); ?></td> -->
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

    <script src="<?= ROOT ?>scripts/Admin/sidebar.js"></script>
    <script src="<?= ROOT ?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script>
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
    </script>
</body>

</html>