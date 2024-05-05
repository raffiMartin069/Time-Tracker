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
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/history.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/history-form-spacing.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css" />
</head>

<body>
    <div id="wrapper">
        <div class="px-2 pt-5">
            <div class="container">
                <h4>Search by Employee I.D.</h4>
            </div>

            <div class="container border border-danger">
                <form class="border border-danger" id="search-form">
                    <div><input class="form-control bg-light mr-sm-1 w-100" type="search" placeholder="Search" aria-label="Search"></div>
                    <div>
                        <select class="form-control bg-light mr-sm-1">
                            <option disabled selected>Filter</option>
                            <option value="1">Oldest</option>
                            <option value="2">Newest</option>
                        </select>
                    </div>
                    <div class=" bg-light mr-sm-1 w-100">
                    <ul class=" list-unstyled justify-content-center gap-5 d-flex">
                        <li><img src="<?=ROOT?>assets/img/admin/list.png" alt="List Icon"/></li>
                        <li><img src="<?=ROOT?>assets/img/admin/grid.png" alt="Grid Icon"/></li>
                        <li><img src="<?=ROOT?>assets/img/admin/calendar.png" alt="Calendar Icon"/></li>
                    </ul>
                </div>
                </form>
                
            </div>
        </div>
        <div>
            <div class="mx-2 my-4 rounded p-2 shadow" id="content-section">
                <div class="container">
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