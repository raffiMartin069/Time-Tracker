<!DOCTYPE html>
<html lang="en">
<!-- 

    REQUIREMENTS:
        - Screen sizes needs to be adjust from laptop upto large monitors.
        - Icon replacements are subject to changes.

 -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhereToNext | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo ROOT?>css/default.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/main-page.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/media.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/meeting_log.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/meeting-log-icons.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/meeting-log-form-spacing.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css" />
</head>
<body>
    <div id="wrapper">
        <div class="px-2 pt-5">
            <div class="container">
                <h4>Search History</h4>
            </div>
        </div>
        <div class="m-2 mt-3 rounded p-2 shadow-sm">
            <form class="container d-lg-flex" id="search-form">
                <div class="search-container w-100">
                    <img src="<?= ROOT ?>node_modules/bootstrap-icons/icons/search.svg" class="search-icon d-none d-lg-block"></img>  
                    <input class="form-control bg-light mr-sm-1 w-100 search-input" id="searchInput" type="search" placeholder="Search" aria-label="Search">
                </div>
                <div class="mx-lg-3 filter-width">
                    <select class="h-100 rounded border filter-hover bg-light mr-sm-1 text-center">
                        <option disabled selected class="bg-light">Filter</option>
                        <option value="1" class="bg-light" style="color:black;">Oldest</option>
                        <option value="2" class="bg-light" style="color:black;">Newest</option>
                    </select>
                </div>
            </form>
        </div>
        <div>
            <div class="mx-2 my-4 rounded p-2 shadow" id="content-section">
                <div class="container">
                    <div class="d-flex">
                        <div class="w-100 px-4 overflow-x-auto rounded" style="height:45rem!important;">
                            <table class="table align-middle mb-0 bg-white text-center" >
                                <thead class="bg-light sticky-top">
                                    <tr class="table-row">
                                        <th>Employee ID</th>
                                        <th>Full name</th>
                                        <th>Date</th>
                                        <th>Break In</th>
                                        <th>Break Out</th>
                                        <th>Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($tableView as $view): ?>
                                    <tr class="table-row">
                                       <td><?php echo htmlspecialchars($view->emp_id ?? "", ENT_QUOTES, 'UTF-8'); ?></td>
                                       <td><?php echo htmlspecialchars($view->full_name ?? "", ENT_QUOTES, 'UTF-8'); ?></td>
                                       <td><?php echo htmlspecialchars($view->date ?? "", ENT_QUOTES, 'UTF-8'); ?></td>
                                       <td><?php echo htmlspecialchars($view->break_in ?? "", ENT_QUOTES, 'UTF-8'); ?></td>
                                       <td><?php echo htmlspecialchars($view->break_out ?? "", ENT_QUOTES, 'UTF-8'); ?></td>
                                       <td><?php echo htmlspecialchars($view->duration ?? "", ENT_QUOTES, 'UTF-8'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.lordicon.com/lordicon.js"></script>
<script defer src="<?= ROOT ?>scripts/Admin/managementEvents.js"></script>
</body>

</html>