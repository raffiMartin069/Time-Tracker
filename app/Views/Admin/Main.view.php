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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo ROOT?>css/default.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/main-page.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/main-page-hovers.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/main-page-icon.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/media.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css" />
</head>

<body>
    <div id="wrapper">
        <div class="px-2 pt-5">
            <div class="container">
                <h4>Hello Lorem Ipsum👋🏼,</h4>
            </div>
        </div>
        <div class=" m-2 mt-3 rounded p-2 shadow-sm ">
            <div class="container d-flex justify-content-center  ">
                <div class="row row-cols gap-5 gap-md-5   w-100 text-center">
                    <div class=" col   p-1 rounded-5 d-flex align-items-center justify-content-center ">
                        <a><img src="<?= ROOT ?>assets/img/admin/Time-in.png" class="img-fluid" /> <small class="fs-3 fw-medium">Time In</small></a>
                    </div>
                    <div class=" col p-1 rounded-5 d-flex align-items-center justify-content-center">
                        <a><img src="<?= ROOT ?>assets/img/admin/break.png" class="img-fluid" /> <small class="fs-3 fw-medium">Break</small></a>
                    </div>
                    <div class=" col   p-1 rounded-5 d-flex align-items-center justify-content-center">
                        <a><img src="<?= ROOT ?>assets/img/admin/meeting.png" class="img-fluid" /> <small class="fs-3 fw-medium">Meeting</small></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-2 my-4 rounded p-2 shadow" id="content-section">
            <div class="container">
                <div>
                    <nav class=" d-md-flex justify-content-between">
                        <h1 class="navbar-brand fs-4 fw-bolder ">My Daily Record</h1>
                        <p style="color:hsl(166, 79%, 42%);" class="d-md-none">I.D.</p>
                        <form class="d-flex">
                            <div class="search-container">
                            <img src="<?= ROOT ?>node_modules/bootstrap-icons/icons/search.svg" class="search-icon d-none d-lg-block"></img>  
                                <input class="form-control bg-light mr-sm-1 w-100 search-input" type="search" placeholder="Search" aria-label="Search">
                            </div>
                            <div>
                                <select class="h-100 w-100 form-control mx-lg-2 mx-3 rounded-3 bg-light filter-hover text-center ">
                                    <option disabled selected>Sort By</option>
                                    <option value="1">Oldest</option>
                                    <option value="2">Newest</option>
                                </select>
                            </div>
                        </form>
                    </nav>
                    <p class="d-none d-md-block" style="color:hsl(166, 79%, 42%);">I.D.</p>
                </div>
                <div>
                    <table class="table align-middle mb-0 bg-white text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Break In</th>
                                <th>Break Out</th>
                                <th>Meeting</th>
                                <th>Time Out</th>
                                <th>Total Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <p>2024-05-05</p>
                                </td>
                                <td>
                                    <p>8:00 AM</p>
                                </td>
                                <td>
                                    <p>12:00 PM</p>
                                </td>
                                <td>
                                    <p>1:00 PM</p>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <p class="border px-2 rounded-3" style=" background-color:hsl(166, 58%, 78%); color:hsl(166, 100%, 26%);">Available</p>
                                    </div>
                                </td>
                                <td>
                                    <p>5:00 PM</p>
                                </td>
                                <td>
                                    <p>9 Hours</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>
</html>