<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WTN Time Tracker</title>
    <link rel="icon" type="image/x-icon" href="<?php ROOT ?>assets/img/login/logo_wtn.png">
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= ROOT ?>node_modules/bootstrap/dist/css/bootstrap.css" />
    <!-- External CSS -->
    <link rel="stylesheet" href="<?= ROOT ?>css/sidebar.css">
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/admin.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/bell.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css" />
</head>

<body>
    <div>
        <div class="body-overlay"></div>
        <div class="sidebar" style="z-index: 1000;">
            <div class="logo">
                <h3 class="ms-3 mt-4 mb-4">
                    <img src="<?php ROOT ?>assets/img/Sidebar/logo.png" class="img-fluid ms-2" />
                    <a>
                        <span class="ms-2"
                            style="letter-spacing:0.05em; font-size: 20px; color: #5B5C70; font-weight: 600;">WhereTo<strong
                                style="letter-spacing:0.05em;font-size: 20px; color: #299FF5; font-weight: 600;">Med</strong></span>
                    </a>
                </h3>
            </div>
            <ul class="list-unstyled component m-0">
                <span class="nav-item-title mt-5 px-4" style="color: #64748B;">Menu</span>
                <div class="">
                    <li class="nav-item mb-2 " style="width: 270px; margin-left: 14px;">
                        <a href="?page=dashboard" class="nav-link text-dark rounded" style="height: 50px;">
                            <i class="lni lni-grid-alt mt-2" style="margin-left: 4px;"></i>
                            <span class="nav-item-title ms-2">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2 " style="width: 270px; margin-left: 14px;">
                        <a href="?page=dailyReport" class="nav-link text-dark rounded" style="height: 50px;">
                            <i class="lni lni-book mt-2" style="margin-left: 4px;"></i>
                            <span class="nav-item-title ms-2">Reports</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2 " style="width: 270px; margin-left: 14px;">
                        <a href="?page=meeting/logs"
                            class="nav-link text-dark rounded d-flex align-items-center justify-content-start"
                            style="height: 50px;">
                            <i class="bi bi-person-video3 fw-bold" style="margin-left: 4px;"></i>
                            <!-- <img src="<?= ROOT ?>node_modules/bootstrap-icons/icons/person-video3.svg"
                                style="height: 20px;"></img> -->
                            <span class="nav-item-title ms-2 ">Huddle Logs</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2 " style="width: 270px; margin-left: 14px;">
                        <a href="?page=break/logs"
                            class="nav-link text-dark rounded d-flex align-items-center justify-content-start"
                            style="height: 50px;">
                            <i class="bi bi-person-video3 fw-bold" style="margin-left: 4px;"></i>
                            <!-- <img src="<?= ROOT ?>node_modules/bootstrap-icons/icons/person-video3.svg"
                                style="height: 20px;" ></img> -->
                            <span class="nav-item-title ms-2 ">Break Logs</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item mb-2" style="width: 270px; margin-left: 14px;">
                        <a href="" class="nav-link text-dark rounded justify-content-start"
                            style="height: 50px; display: flex; align-items: center; justify-content: flex-start;"
                            data-bs-toggle="modal" data-bs-target="#startMeeting" id="meeting_start">
                            <i class="bi bi-briefcase-fill"></i>
                            <span class="nav-item-title ms-2" style="margin-top: 0;">Start a meeting</span>
                        </a>
                    </li> -->
                    <li class="nav-item mb-4 " style="width: 270px; margin-left: 14px;">
                        <a href="?page=settings" class="nav-link text-dark rounded" style="height: 50px;">
                            <i class="lni lni-cog style mt-2" style="margin-left: 4px;"></i>
                            <span class="nav-item-title ms-2" style="margin-top: -32px;">Settings</span>
                        </a>
                    </li>
                </div>
                <div class="bottom-items">
                    <div class="nav-item-title mt-2 fs-6 mb-3 flex-column justify-content-center align-items-start"
                        style="width: 270px; margin-left: 14px;">
                        <ul class=" text-decoration-none list-unstyled d-none">
                            <li>
                                <a href="?page=employee/notification/view" class="nav-link text-dark rounded pt-3"
                                    style="height: 50px;">
                                    <i class="bi bi-bell-fill notification-bell"></i>
                                    <span class="nav-item-title ms-2" style="margin-top: -32px;">Notifications</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <hr>
                    
                    <?php 
                        $img = $_SESSION['image'] ?? null;
                        $isImgFile = file_exists(__DIR__ . "/../../../../public/" . $img);
                        $isSessionImg = $_SESSION['image'] != null;
                        $photo = $isImgFile && $isSessionImg ? ROOT . $_SESSION['image'] : ROOT . "assets/img/employee/default-settings-profile.png";
                    ?>

                    <span class="nav-item-title fs-6 px-4" style="color: #64748B;">Profile</span>
                    <div class="d-flex mt-3">
                        <img id="profile-photo" class="" src="<?php echo $photo; ?>"
                            style="width: 50px; height: 50px; border: none; margin-left:10px; border-radius: 30px; object-fit: cover;"
                            alt="Profile Picture">
                        <span class="nav-item-title">
                            <h6 class="mt-1 mb-0 ms-2"><?php echo $_SESSION['name'] ?? '' ?></h6>
                            <small class="ms-2 text-secondary"><?php echo $_SESSION['email'] ?? '' ?></small>
                        </span>
                    </div>
                    <li class="nav-item mt-3 rounded" style="background: #F6F7F8; width: 270px; margin-left: 14px;">
                    <form id="log-out" action="Login/logout" method="post">
                            <button type="submit" value="1" name="logoutBtn" id="logoutBtn" class="btn btn-primary shadow-sm rounded w-100 m-0 justify-content-center">
                                Log Out
                            </button>
                        </form>
                    </li>
                </div>
            </ul>
        </div>
        <div id="content-area" class="hide" style="background-color: hsl(166, 79%, 42%);">
            <div class="menu-navbar hide">
                <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
                    <div class="menu-btn">
                        <i class="lni lni-menu text-dark fs-1 fw-bolder text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="startMeeting" tabindex="-1" aria-labelledby="startMeetingLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-lg-down modal-lg">
            <div class="modal-content" style="background: hsl(45, 50%, 97%);">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="startMeetingLabel">Meeting Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col">
                        <form id="meeting_form" method="post">
                            <!-- search mechanism -->
                            <div class="form-outline mb-4 form-floating">
                                <input type="search" id="search" class="form-control" placeholder="" />
                                <label for="search" class="form-label">Search Employee</label>
                            </div>

                            <!-- Name input -->
                            <div data-mdb-input-init class="form-outline mb-4 form-floating">
                                <input type="text" id="meet_title" name="meet_title" class="form-control"
                                    placeholder="" />
                                <label class="form-label" for="meet_start">Meeting Title</label>
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <div>
                                    <input type="date" id="meet_date" name="meet_date" class="form-control" />
                                    <label class="form-label" for="meet_date">Meeting Date</label>
                                </div>
                                <div>
                                    <input type="datetime-local" id="meet_start" name="meet_start"
                                        class="form-control" />
                                    <label class="form-label" for="meet_start">Meeting Start</label>
                                </div>
                                <div>
                                    <input type="datetime-local" id="meet_end" name="meet_end" class="form-control" />
                                    <div class=""><label class="form-label" for="meet_end">MeetingEnd</label></div>
                                </div>
                            </div>

                            <!-- Message input -->
                            <div data-mdb-input-init class="form-outline mb-4 form-floating">
                                <input type="text" class="form-control" id="meet_link" name="meet_link"
                                    placeholder=""></input>
                                <label class="form-label" for="meet_link">Link</label>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="members">Select Members</label>
                                <div
                                    style="height: 150px; overflow-y: scroll; border: 1px solid #ced4da; border-radius: .25rem; padding: .375rem .75rem;">
                                    <select name="members" id="members" class="form-control form-select selectpicker"
                                        multiple data-live-search="true" style="display: none;">
                                        <!-- The select is hidden because we are manually creating the checkboxes below -->
                                    </select>
                                    <!-- Manually created checkboxes inside the scrollable container -->
                                    <?php foreach ($tableView as $view): ?>
                                        <div class="form-check user-checkbox employee-checkbox">

                                            <input class="form-check-input" type="checkbox" name="checkbox"
                                                value="<?php echo htmlspecialchars($view->emp_id ?? "", ENT_QUOTES, 'UTF-8') ?>"
                                                id="<?php echo htmlspecialchars($view->emp_id ?? "", ENT_QUOTES, 'UTF-8') ?>">
                                            <label class="form-check-label"
                                                for="<?php echo htmlspecialchars($view->emp_id ?? "", ENT_QUOTES, 'UTF-8') ?>">
                                                <?php echo htmlspecialchars($view->full_name ?? "", ENT_QUOTES, 'UTF-8'); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!-- Message input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <select name="platform" id="platform" name="platform" class="form-control form-select">
                                    <option disable select value="">Select Platform</option>
                                    <?php foreach ($platforms as $platform): ?>
                                        <option
                                            value="<?php echo htmlspecialchars($platform->platform_id ?? "", ENT_QUOTES, 'UTF-8') ?>">
                                            <?php echo htmlspecialchars($platform->platform_name ?? "", ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label class="form-label" for="platform">Platform</label>
                            </div>

                            <!-- Message input -->
                            <div data-mdb-input-init class="form-floating mb-4">
                                <textarea class="form-control form-text" id="mess_desc" name="mess_desc"
                                    rows="4"></textarea>
                                <label class="form-label" for="mess_desc">Message</label>
                            </div>
                            <div class="modal-footer w-auto">
                                <button type="button" class="btn btn-secondary w-100"
                                    data-bs-dismiss="modal">Close</button>
                                <button data-mdb-ripple-init type="submit" class="btn btn-primary w-100">Send</button>
                            </div>
                        </form>
                    </div>
                    <style>

                    </style>
                    <div class="col-md-5" id="meeting-participants">
                        <div>
                            <table>
                                <thead>
                                    <tr class=" border-0">
                                        <th style="background-color: transparent !important; color: black !important;">
                                            <h3>Meeting participants</h3>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="participantTableBody">
                                    <tr class="border-0">
                                        <td id="userTable"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $page = 'dashboard';
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }

    $controller = new Employee();
    $adminController = new Admin();
    switch ($page) {
        case 'dashboard':
            $adminController->main();
            break;

        case 'dailyReport':
            $controller->dailyreport();
            break;

        case 'weeklyReport':
            $controller->weeklyreport();
            break;

        case 'biweeklyReport':
            $controller->biweeklyreport();
            break;

        case 'settings':
            $controller->settings();
            break;

        case 'employee/notification/view':
            $controller->employeeNotificationView();
            break;

        case 'break/logs':
            $controller->breakLog();
            break;

        case 'meeting/logs':
            $controller->meetingLog(); // This is changed to huddle logs.
            break;

        default:
            $adminController->main();
            break;
    }
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo ROOT ?>node_modules/sweetalert2/dist/sweetalert2.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="<?= ROOT ?>scripts/Admin/sidebar.js"></script>
    <script src="<?= ROOT ?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="<?= ROOT ?>scripts/logout.js"></script>
</body>

</html>
