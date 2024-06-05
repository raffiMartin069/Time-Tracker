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
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/history.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/history-icons.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/history-form-spacing.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css" />
</head>
<body>
    <div id="wrapper">
        <div class="px-2 pt-5">
            <div class="container">
                <h4>Search by Employee I.D.</h4>
            </div>
        </div>
        <div class="m-2 mt-3 rounded p-2 shadow-sm">
            <form class="container d-lg-flex" id="search-form">
                <div class="search-container w-100">
                    <img src="<?= ROOT ?>node_modules/bootstrap-icons/icons/search.svg" class="search-icon d-none d-lg-block"></img>  
                    <input class="form-control bg-light mr-sm-1 w-100 search-input" type="search" placeholder="Search" aria-label="Search">
                </div>
                <div class="mx-lg-3 filter-width">
                    <select class="h-100 rounded border filter-hover bg-light mr-sm-1 text-center">
                        <option disabled selected class="bg-light">Filter</option>
                        <option value="1" class="bg-light" style="color:black;">Oldest</option>
                        <option value="2" class="bg-light" style="color:black;">Newest</option>
                    </select>
                </div>
                <div class=" mr-sm-1 w-100 d-lg-flex justify-content-end ">
                    <ul class="m-0 p-0 list-unstyled justify-content-center align-items-center gap-1 d-flex">
                        <li class="p-1 px-lg-3 py-lg-1 rounded option-pane"><img src="<?= ROOT ?>assets/img/admin/list.png" alt="List Icon" /></li>
                        <li class="p-1 px-lg-3 py-lg-1 rounded option-pane"><img src="<?= ROOT ?>assets/img/admin/grid.png" alt="Grid Icon" /></li>
                        <li class="p-1 px-lg-3 py-lg-1 rounded option-pane"><img src="<?= ROOT ?>assets/img/admin/calendar.png" alt="Calendar Icon" /></li>
                    </ul>
                </div>
            </form>
        </div>
        <div>
            <div class="mx-2 my-4 rounded p-2 shadow" id="content-section">
                <div class="container">
                    <div>
                        <table class="table align-middle mb-0 bg-white text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>Employee I.D.</th>
                                    <th>Employee Name</th>
                                    <th>Hours Worked</th>
                                    <th>Date Confirmed</th>
                                    <th>Admin I.D.</th>
                                    <th>Admin Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p>101-06-24</p>
                                    </td>
                                    <td>
                                        <p>Internal T. Test</p>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <p class="border px-2 rounded-3">40</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p>2024-03-29</p>
                                    </td>
                                    <td>
                                        <p>200-60-23</p>
                                    </td>
                                    <td>
                                        <p>Internal Test</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>

</html>