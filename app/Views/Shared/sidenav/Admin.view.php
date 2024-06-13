<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WTN Time Tracker</title>
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=ROOT?>node_modules/bootstrap/dist/css/bootstrap.css" />
    <!-- External CSS -->
    <link rel="stylesheet" href="<?=ROOT?>css/sidebar.css">
    <link rel="stylesheet" href="<?=ROOT?>css/Admin/admin.css" />
    <link rel="stylesheet" href="<?=ROOT ?>css/default.css" />
    
</head>
<body>

    <div>
        <div class="body-overlay"></div>
        <div class="sidebar">
            <div class="logo">
                <h3 class="ms-3 mt-4 mb-4">
                    <img src="<?php ROOT ?>assets/img/Sidebar/logo.png" class="img-fluid ms-2" />
                    <a>
                        <span class="ms-2" style="letter-spacing:0.05em; font-size: 20px; color: #5B5C70; font-weight: 600;">WhereTo<strong style="letter-spacing:0.05em;font-size: 20px; color: #299FF5; font-weight: 600;">Med</strong></span>
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
                        <a href="?page=trackHistory" class="nav-link text-dark rounded" style="height: 50px;">
                            <i class="lni lni-search-alt mt-2" style="margin-left: 4px;"></i>
                            <span class="nav-item-title ms-2">Track History</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2 " style="width: 270px; margin-left: 14px;">
                        <a href="?page=manage/employee" class="nav-link text-dark rounded d-flex align-items-center justify-content-start" style="height: 50px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" style="margin-left: 4px;" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                            </svg>
                            <span class="nav-item-title ms-2">Manage Employee</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2 " style="width: 270px; margin-left: 14px;">
                        <a href="#" class="nav-link text-dark rounded" style="height: 50px;">
                            <i class="lni lni-book mt-2" style="margin-left: 4px;"></i>
                            <span class="nav-item-title ms-2" style="margin-top: -32px;">Reports</span>
                        </a>
                    </li>
                    <li class="nav-item mb-4 " style="width: 270px; margin-left: 14px;">
                        <a href="#" class="nav-link text-dark rounded" style="height: 50px;">
                            <i class="lni lni-cog style mt-2" style="margin-left: 4px;"></i>
                            <span class="nav-item-title ms-2" style="margin-top: -32px;">Settings</span>
                        </a>
                    </li>
                </div>
                <div class="bottom-items">
                    <hr>
                    <span class="nav-item-title mt-2 fs-6 px-4" style="color: #64748B;">Profile</span>
                    <div class="d-flex mt-3">
                        <img src="<?=ROOT ?>assets/img/Sidebar/profile.svg" class="img-fluid rounded ms-3" width="50px" alt="">
                        <span class="nav-item-title">
                            <h6 class="mt-1 mb-0 ms-2">Jenny Wilson</h6>
                            <small class="ms-2 text-secondary">jen.wilson@example.com</small>
                        </span>
                    </div>
                    <li class="nav-item mt-3 rounded" style="background: #F6F7F8; width: 270px; margin-left: 14px;">
                        <a href="#" class="nav-link text-center text-dark rounded" style="height: 50px;">
                            <i class="lni lni-exit mt-2" style="margin-left: -15px;"></i>
                            <span class="nav-item-title ms-2">Logout</span>
                        </a>
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
    <?php
        $page = 'dashboard';
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        $controller = new Admin();
        switch ($page) {
            case 'dashboard':
                // include __DIR__ . '../../../Admin/Main.view.php';
                $controller->main();
                break;
            
            case 'trackHistory':
                // include __DIR__ . '../../../Admin/History.view.php';
                $controller->history();
                break;
            
            case 'manage/employee':
                // include __DIR__ . '../../../Admin/Management.view.php';
                $controller->management();
                break;
            
            default:
                $controller->main();
                // include __DIR__ . '../../../Admin/Main.view.php';
                break;
        }
    ?>

    <script src="<?= ROOT ?>scripts/Admin/sidebar.js"></script>
    <script src="<?= ROOT ?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>