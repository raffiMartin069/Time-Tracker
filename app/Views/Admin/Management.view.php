<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhereToNext | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo ROOT ?>css/default.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/main-page.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/media.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/management-icon.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/management.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/management-colors.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/management-form-spacing.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css" />
    <link rel="stylesheet" href="<?php echo ROOT ?>node_modules/sweetalert2/dist/sweetalert2.css" />
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
                    <img src="<?= ROOT ?>node_modules/bootstrap-icons/icons/search.svg"
                        class="search-icon d-none d-lg-block"></img>
                    <input class="form-control bg-light mr-sm-1 w-100 search-input" type="search" placeholder="Search"
                        aria-label="Search">
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
                        <li class="p-1 px-lg-3 py-lg-1 rounded option-pane"><img
                                src="<?= ROOT ?>assets/img/admin/list.png" alt="List Icon" /></li>
                        <li class="p-1 px-lg-3 py-lg-1 rounded option-pane"><img
                                src="<?= ROOT ?>assets/img/admin/calendar.png" alt="Calendar Icon" /></li>
                        <li class="p-1 px-lg-3 py-lg-1 rounded option-pane"><a href="" id="add-employee"
                                data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <img src="<?= ROOT ?>assets/img/admin/add-employee.png" alt="Add Employee" />
                            </a></li>
                    </ul>
                </div>
            </form>
        </div>
        <div>
            <div class="mx-2 my-4 rounded p-2 shadow" id="content-section">
                <div class="container">
                    <div class="table-container overflow-x-auto">
                        <table class="table align-middle mb-0 bg-white text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>I.D.</th>
                                    <th>Name</th>
                                    <th>Date of birth</th>
                                    <th>Position</th>
                                    <th>Hire date</th>
                                    <th>Email</th>
                                    <th>Employment type</th>
                                    <th>Working Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p>1</p>
                                    </td>
                                    <td>
                                        <p>Internal I. Test</p>
                                    </td>
                                    <td>
                                        <p>01/01/1990</p>
                                    </td>
                                    <td>
                                        <p>Dog style</p>
                                    </td>
                                    <td>
                                        <p>01/01/1990</p>
                                    </td>
                                    <td>
                                        <p>internal.test@test.com</p>
                                    </td>
                                    <td>
                                        <p>N/A</p>
                                    </td>
                                    <td>
                                        <p>0 Hours</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for add employee -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-modal="true">
            <div id="empModal" class="modal-dialog modal-xl">
                <div class="modal-content" style="background: hsl(45, 50%, 97%)">
                    <div class="modal-header">
                        <div class="d-flex m-auto">
                            <img src="<?= ROOT ?>assets/img/admin/add-employee.png" alt="Add Employee">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Employee</h1>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="employeeForm">
                            <div class="row">
                                <div class="col-lg-8 border-end">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="fname" name="fname"
                                            placeholder="e.g. John">
                                        <label for="fname" style="color: #595959">First name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="mname" name="mname"
                                            placeholder="e.g. Jacob">
                                        <label for="mname" style="color: #595959">Middle name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="lname" name="lname"
                                            placeholder="e.g. Doe">
                                        <label for="lname" style="color: #595959">Last name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="dob" name="dob">
                                        <label for="dob" style="color: #595959">Date of birth</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="hireDate" name="hireDate">
                                        <label for="hireDate" style="color: #595959">Hire date</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="john.doe@outlook.com">
                                        <label for="email" style="color: #595959">Email address</label>
                                    </div>
                                </div>
                                <div class="col-lg border-start">
                                    <div>
                                        <h4 style="color: #595959">Employment Type</h4>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="shift" id="fullTime"
                                                value="Full Time">
                                            <label class="form-check-label" for="fullTime" style="color: #595959">
                                                Full Time
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="shift" id="partTime"
                                                value="Part Time">
                                            <label class="form-check-label" for="partTime" style="color: #595959">
                                                Part Time
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 style="color: #595959">Working Hours</h4>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="numberOfHrs"
                                                id="twentyHrs" value="20">
                                            <label class="form-check-label" for="twentyHrs" style="color: #595959">
                                                20
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="numberOfHrs"
                                                id="thirtyHrs" value="30">
                                            <label class="form-check-label" for="thirtyHrs" style="color: #595959">
                                                30
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 style="color: #595959">Position/Title</h4>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="role" id="ceo"
                                                value="Chief Executive">
                                            <label class="form-check-label" for="ceo" style="color: #595959">
                                                Chief Executive
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="role" id="coo"
                                                value="Chief Operations Officer">
                                            <label class="form-check-label" for="coo" style="color: #595959">
                                                Chief Operations Officer
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="role" id="dot"
                                                value="Director of Training">
                                            <label class="form-check-label" for="dot" style="color: #595959">
                                                Director of Training
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="role" id="va"
                                                value="Virtual Assistant">
                                            <label class="form-check-label" for="va" style="color: #595959">
                                                Virtual Assistant
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" aria-hidden="false" class="btn fs-5 fw-medium"
                                    data-bs-dismiss="modal" style="color: #595959">Cancel</button>
                                <button type="button" id="submit" class="btn text-white rounded-5 fs-5 fw-medium"
                                    style="background: hsl(202, 71%, 42%)">Submit</button>
                            </div>
                            <!-- Modal for employee summary -->
                            <div class="modal fade" id="empSummary" tabindex="-1" aria-labelledby="empSummary"
                                aria-hidden="true"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script>
        var ROOT = "<?= ROOT ?>";
    </script>
    <script src="<?php echo ROOT ?>node_modules/sweetalert2/dist/sweetalert2.js"></script>
    <script defer src="<?= ROOT ?>scripts/Admin/employee.js"></script>

</body>

</html>