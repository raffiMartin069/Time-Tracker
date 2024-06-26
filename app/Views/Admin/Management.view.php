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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo ROOT ?>css/default.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/main-page.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/media.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/management-icon.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/management.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/management-colors.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/management-form-spacing.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css" />
    <link rel="stylesheet" href="<?php echo ROOT ?>node_modules/sweetalert2/dist/sweetalert2.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/tables.css" />
</head>

<body>
    <div id="wrapper">
        <div class="px-2 pt-5 ">
            <div class="container">
                <h4>Search by Employee I.D.</h4>
            </div>
        </div>
        <noscript>
            <div class="noscript-visible"
                style="background-color: #ffcc00; color: black; padding: 20px; text-align: center;">
                Warning: JavaScript is disabled in your browser. Some features of this site will not work.
                Please enable
                JavaScript to continue.
            </div>
        </noscript>
        <div class="m-2 mt-3 p-2 rounded shadow-sm">
            <div class="container d-lg-flex" id="search-form">
                <div class="search-container">
                    <img src="<?= ROOT ?>node_modules/bootstrap-icons/icons/search.svg"
                        class="search-icon d-none d-lg-block"></img>
                    <input class="form-control bg-light mr-sm-1 search-input" id="searchInput" type="search"
                        placeholder="Search" aria-label="Search">
                </div>
                <div class="mx-lg-3 filter-width">
                    <select class="h-100 rounded border filter-hover bg-light mr-sm-1 text-center">
                        <option disabled selected class="bg-light">Filter</option>
                        <option value="1" class="bg-light" style="color:black;">Oldest</option>
                        <option value="2" class="bg-light" style="color:black;">Newest</option>
                    </select>
                </div>
            </div>
            <div class="container">
                <button id="add-employee" class="btn border shadow-sm text-center filter-hover"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Employee <i class="bi bi-person-fill-add"></i></button>
                <button id="emp_setting" class="btn border shadow-sm text-center filter-hover"  data-bs-toggle="modal" data-bs-target="#employee_setting">Employee Settings <i class="bi bi-gear-wide-connected"></i></button>
            </div>
        </div>
        <div>
            <div class="my-4 rounded p-2 shadow" id="content-section">
                <div class="d-flex">
                    <div class="w-100 overflow-x-auto" style="height:43rem!important;">
                        <table class="table table-stripped align-middle mb-0 bg-white text-center">
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
                            <tbody id="tableBody">
                                <?php foreach ($management as $employee): ?>
                                    <tr class="table-row">
                                        <td>
                                            <p><?php echo $employee->getID() ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $employee->getFirstName() . " " . $employee->getMiddleName() . " " . $employee->getLastName() ?>
                                            </p>
                                        </td>

                                        <td>
                                            <p><?php echo $employee->getDOB() ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $employee->getPosition() ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $employee->getHireDate() ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $employee->getEmail() ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $employee->getPosition() ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $employee->getWorkingHours() ?> Hours</p>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="employee_setting" tabindex="-1" aria-labelledby="employee_setting"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="employee_settingLabel">Employee Settings</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <form method="post" id="updateEmployee">
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                            aria-expanded="false" aria-controls="flush-collapseOne">
                                            <b>Update Employee Type</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class=" form-floating">
                                            <input type="search" id="search_emp" name="search_emp"
                                                class="mt-3 form-control" placeholder="" />
                                            <label for="search_emp" class="form-label">Employee I.D.</label>
                                        </div>
                                        <section class="mt-2">
                                            <div>
                                                <h4 style="color: #595959">Employment Type</h4>
                                                <?php foreach ($employment as $employments): ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="type"
                                                            id="employmentType<?php echo $employments->getEmploymentID() ?>"
                                                            value="<?php echo $employments->getEmploymentID() ?>">
                                                        <label class="form-check-label"
                                                            for="employmentType<?php echo $employments->getEmploymentID() ?>"
                                                            style="color: #595959">
                                                            <?php echo $employments->getEmploymentType() . " " . "( " . $employments->getWorkHours() . " Hours )" ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </section>
                                        <div class="modal-footer mt-3">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form method="post" id="updatePosition">
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                            aria-expanded="false" aria-controls="flush-collapseTwo">
                                            <b>Update Employee Position</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class=" form-floating">
                                                <input type="text" id="update_position" name="update_position"
                                                    class="mt-3 form-control" placeholder="" />
                                                <label for="update_position" class="form-label">Employee I.D.</label>
                                                <div>
                                                    <h4 style="color: #595959" class="mt-4">Position/Title</h4>
                                                    <?php foreach ($positions as $position): ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="update_role"
                                                                id="<?php echo $position->getPositionID() ?>"
                                                                value="<?php echo $position->getPositionID() ?>">
                                                            <label class="form-check-label"
                                                                for="<?php echo $position->getPositionID() ?>"
                                                                style="color: #595959">
                                                                <?php echo $position->getPositionName() ?>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer mt-3">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form method="post" id="deleteEmployeeForm">
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                            aria-expanded="false" aria-controls="flush-collapseThree">
                                            <b>Remove Employee</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <p><b>WARNING:</b> This action will deactivate the employee's
                                                account. The employee's data will be archived and no longer be
                                                accessible
                                                for day-to-day operations. Are you sure you want to proceed?</p>
                                        </div>

                                        <div class=" form-floating">
                                            <input type="text" id="del" name="del" class="mt-3 form-control"
                                                placeholder="" />
                                            <label for="del" class="form-label">Employee I.D.</label>
                                        </div>

                                        <div class="modal-footer mt-3">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                                        <input type="text" class="form-control" id="fname" name="fname">
                                        <label for="fname" style="color: #595959">First name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="mname" name="mname">
                                        <label for="mname" style="color: #595959">Middle name</label>
                                        <small style="color: gray;"><small style="color:red;">*</small> Note: Middle
                                            name is optional</small>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="lname" name="lname">
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
                                        <input type="email" class="form-control" id="email" name="email">
                                        <label for="email" style="color: #595959">Email address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="contact" name="contact"
                                            maxlength="11">
                                        <label for="contact" style="color: #595959">Contact number</label>
                                    </div>
                                </div>
                                <div class="col-lg border-start">
                                    <div>
                                        <h4 style="color: #595959">Employment Type</h4>
                                        <?php foreach ($employment as $employments): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type"
                                                    id="employmentType<?php echo $employments->getEmploymentID() ?>"
                                                    value="<?php echo $employments->getEmploymentID() ?>">
                                                <label class="form-check-label"
                                                    for="employmentType<?php echo $employments->getEmploymentID() ?>"
                                                    style="color: #595959">
                                                    <?php echo $employments->getEmploymentType() . " " . "( " . $employments->getWorkHours() . " Hours )" ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div>
                                        <h4 style="color: #595959" class="mt-4">Position/Title</h4>
                                        <?php foreach ($positions as $position): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="role"
                                                    id="<?php echo $position->getPositionID() ?>"
                                                    value="<?php echo $position->getPositionID() ?>">
                                                <label class="form-check-label"
                                                    for="<?php echo $position->getPositionID() ?>" style="color: #595959">
                                                    <?php echo $position->getPositionName() ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div>
                                        <h4 style="color: #595959" class="mt-4">Shift</h4>
                                        <?php foreach ($shift as $shifts): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="shift"
                                                    id="<?php echo $shifts->getShiftID() ?>"
                                                    value="<?php echo $shifts->getShiftID() ?>">
                                                <label class="form-check-label" for="<?php echo $shifts->getShiftID() ?>"
                                                    style="color: #595959">
                                                    <?php echo $shifts->getShiftName() ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
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
    <script defer type="module" src="<?= ROOT ?>scripts/Admin/employee.js"></script>
    <script defer src="<?= ROOT ?>scripts/Admin/manage_sort.js"></script>
    <script defer src="<?= ROOT ?>scripts/Admin/managemenValidate.js"></script>
    <script defer type="module" src="<?= ROOT ?>scripts/Admin/updateHours.js"></script>
    <script defer type="module" src="<?= ROOT ?>scripts/Admin/deleteEmployee.js"></script>
    <script defer type="module" src="<?= ROOT ?>scripts/Admin/updateEmployeePosition.js"></script>
</body>

</html>