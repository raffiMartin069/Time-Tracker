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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/main-page.css" />
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
                    <div class=" col   p-1 rounded-5 d-flex align-items-center justify-content-center">
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
                        <form class="d-flex">
                            <div class="d-flex"><input class="form-control bg-light mr-sm-1 w-100 h" type="search" placeholder="Search" aria-label="Search">
                            </div>
                            <div>
                                <select class="form-control mx-2 rounded-3 bg-light">
                                    <option disabled selected>Sort By</option>
                                    <option value="1">Oldest</option>
                                    <option value="2">Newest</option>
                                </select>
                            </div>
                        </form>
                        
                        
                    </nav>
                    <p style="color:hsl(166, 79%, 42%);">I.D.</p>
                </div>
                <div>
                    <table class="table align-middle mb-0 bg-white">
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
                                    <div class="d-flex align-items-center">
                                        <p>2024-05-05</p>
                                    </div>
                </div>
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
                    <p>Available</p>
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