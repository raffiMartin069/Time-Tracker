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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= ROOT ?>node_modules/bootstrap/dist/css/bootstrap.css" />
    <!-- External CSS -->
    <link rel="stylesheet" href="<?= ROOT ?>css/sidebar.css">
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/admin.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/bell.css" />
    <link rel="stylesheet" href="<?php echo ROOT ?>node_modules/sweetalert2/dist/sweetalert2.css" />
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
                <div class="d-flex flex-column justify-content-center align-items-start">
                    <li class="nav-item mb-2 " style="width: 270px; margin-left: 14px;">
                        <a href="?page=dashboard"
                            class="nav-link text-dark rounded d-flex align-items-center justify-content-start"
                            style="height: 50px;">
                            <i class="lni lni-grid-alt fw-bold" style="margin-left: 4px;"></i>
                            <span class="nav-item-title ms-2">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2 " style="width: 270px; margin-left: 14px;">
                        <a href="?page=meeting/logs"
                            class="nav-link text-dark rounded d-flex align-items-center justify-content-start"
                            style="height: 50px;">
                            <i class="bi bi-person-video3 fw-bold" style="margin-left: 4px;"></i>
                            <span class="nav-item-title ms-2 ">Meeting Logs</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2 " style="width: 270px; margin-left: 14px;">
                        <a href="?page=break/logs"
                            class="nav-link text-dark rounded d-flex align-items-center justify-content-start"
                            style="height: 50px;">
                            <i class="bi bi-person-video3 fw-bold" style="margin-left: 4px;"></i>
                            <span class="nav-item-title ms-2 ">Break Logs</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2 " style="width: 270px; margin-left: 14px;">
                        <a href="?page=manage/employee"
                            class="nav-link text-dark rounded d-flex align-items-center justify-content-start"
                            style="height: 50px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-person-circle" style="margin-left: 4px;" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                            </svg>
                            <span class="nav-item-title ms-2">Manage Employee</span>
                        </a>
                    </li>
                    <?php
                    $pages = ['dailyReport', 'weeklyReport', 'biweeklyReport', 'editProfile', 'manageAdmin', 'recycleBin'];
                    $showStartMeeting = true;
                    foreach($pages as $page) {
                        if (isset($_GET['page']) && $_GET['page'] === $page) {
                            $showStartMeeting = false;
                            break;
                        }
                    }
                    
                    ?>

                    <!-- Reports list item -->
                    <li class="nav-item mb-2 <?= $showStartMeeting ? '' : 'mb-4' ?>"
                        style="width: 270px; margin-left: 14px;">
                        <a href="?page=dailyReport" class="nav-link text-dark rounded" style="height: 50px;"
                            id="reports">
                            <i class="lni lni-book mt-2" style="margin-left: 4px;"></i>
                            <span class="nav-item-title ms-2" style="margin-top: -32px;">Reports</span>
                        </a>
                    </li>

                    <?php if ($showStartMeeting): ?>
                        <!-- Start a meeting list item -->
                        <li class="nav-item mb-4 d-none" style="width: 270px; margin-left: 14px;">
                            <a href="" class="nav-link text-dark rounded justify-content-start"
                                style="height: 50px; display: flex; align-items: center; justify-content: flex-start;"
                                data-bs-toggle="modal" data-bs-target="#startMeeting" id="meeting_start">
                                <i class="bi bi-briefcase-fill"></i>
                                <span class="nav-item-title ms-2" style="margin-top: 0;">Start a meeting</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- <hr /> -->
                </div>
                <div class="bottom-items">
                    <div class="nav-item-title mt-2 fs-6 mb-3 flex-column justify-content-center align-items-start"
                        style="width: 270px; margin-left: 14px;">
                        <ul class=" text-decoration-none list-unstyled">
                            <!-- <li>
                                <a href="?page=notification/view" class="nav-link text-dark rounded pt-3"
                                    style="height: 50px;">
                                    <i class="bi bi-bell-fill notification-bell"></i>
                                    <span class="nav-item-title ms-2" style="margin-top: -32px;">Notifications</span>
                                </a>
                            </li> -->
                            <li class="nav-item mb-4 " style="width: 270px;">
                                <a href="?page=editProfile" class="nav-link text-dark rounded" style="height: 50px;">
                                    <div style="display: flex; align-items: center;">
                                        <i class="lni lni-cog mt-2 fs-5 fw-semibold"></i>
                                        <span class="nav-item-title ms-2 mt-2">Settings</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <hr>

                    <?php
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }

                    $empId = isset($_SESSION["userId"]) ? $_SESSION["userId"] : null;
                    $defaultPhoto = ROOT . "assets/img/employee/default-settings-profile.png";
                    $getProfilePhoto = $defaultPhoto;

                    if ($empId) {
                        $returnQuery = "SELECT image FROM employee_credential WHERE emp_id = :emp_id";
                        $returnParams = [':emp_id' => $empId];
                        $returnData = $this->Query($returnQuery, $returnParams);

                        if (!empty($returnData) && !empty($returnData[0]->image)) {
                            $getProfilePhoto = $returnData[0]->image;
                        }
                    }
                    ?>

                    <span class="nav-item-title mt-2 fs-6 px-4" style="color: #64748B;">Profile</span>
                    <div class="d-flex mt-3">
                        <img id="profile-photo" src="<?php echo $getProfilePhoto; ?>"
                            style="width: 50px; height: 50px; border: none; margin-left:10px; border-radius: 30px"
                            alt="Profile Picture">
                        <span class="nav-item-title">
                            <h6 class="mt-1 mb-0 ms-2"><?php echo $_SESSION['name'] ?? '' ?></h6>
                            <small class="ms-2 text-secondary"><?php echo $_SESSION['email'] ?? '' ?></small>
                        </span>
                    </div>
                    <li class="nav-item mt-3 rounded" style="background: #F6F7F8; width: 270px; margin-left: 14px;">
                        <form action="Login/logout" method="post">
                            <button type="submit" class="btn btn-primary shadow-sm rounded w-100 m-0 justify-content-center">
                                Logout
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

    <?php
    $page = 'dashboard';
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }

    $controller = new Admin();
    switch ($page) {
        case 'dashboard':
            $controller->main();
            break;

        case 'meeting/logs':
            $controller->meetingLog();
            break;

        case 'manage/employee':
            $controller->management();
            break;

        case 'set/meeting':
            ;
            $controller->meeting();
            break;

        case 'break/logs':
            $controller->breakLog();
            break;

        case 'notification/view':
            $controller->notificationView();
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

        case 'editProfile':
            $controller->editProfileInformation();
            break;

        case 'manageAdmin':
            $controller->manageAdminAccess();
            break;

        case 'recycleBin':
            $controller->manageRecycleBin();
            break;
    
        default:
            $controller->main();
            break;
    }
    ?>
    <script src="<?= ROOT ?>scripts/Admin/sidebar.js"></script>
    <script src="<?= ROOT ?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo ROOT ?>node_modules/sweetalert2/dist/sweetalert2.js"></script>
    <script defer type="module" src="<?= ROOT ?>scripts/Admin/meeting.js"></script>
</body>

</html>