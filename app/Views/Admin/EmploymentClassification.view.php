<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhereToNext | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/reports.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css">
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/table.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/tabs-modal.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/employment-classification.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/employment-classification-btns.css" />
</head>

<body>
    <div id="wrapper">
        <div class="px-2" style="padding-top: 2.5rem;">
            <div class="container"></div>
        </div>
        <div class="mx-2 my-4 rounded p-2 shadow reports-body" style="margin-top: -2rem !important;">
            <div class="container" style="text-align: center;">

                <div class="button-container">
                    <button class="btn" id="addEmploymentBtn" title="Add Employment Classification" data-bs-toggle="modal" data-bs-target="#addEmploymentTypeModal" style="width: 6rem; height: 1.8rem; margin-top: .5rem; border: 1px solid #e0e0e0; margin-left: auto; margin-right: 1px !important;">
                        <i class="lni lni-plus" style="font-size: 10px;"></i>
                        <span class="ms-2" style="font-size: 12px;">Create</span>
                    </button>
                </div>

                <div class="tabs-container">
                    <ul class="tabs">
                        <li><a class="nav-link" href="?page=editProfile">Edit Profile</a></li>
                        <li><a class="nav-link" href="?page=manageAdmin">Manage Admin</a></li>
                        <li><a class="nav-link" href="?page=manageShift">Manage Shift</a></li>
                        <li><a class="nav-link active" href="?page=employmentClassification">Employment Status</a></li>
                        <li><a class="nav-link" href="?page=manageJobPosition">Job Position</a></li>
                        <li><a class="nav-link" href="?page=recycleBin">Recycle Bin</a></li>
                    </ul>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0 bg-white text-center">
                        <thead style="position: sticky; top: 0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <tr>
                                <th>Status ID</th>
                                <th>Status</th>
                                <th>Required Hours</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="adminTableBody">
                            <?php if (!empty($classifications) && is_array($classifications)) : ?>
                                <?php foreach ($classifications as $classification) : ?>
                                    <tr>
                                        <td><?php echo $classification->getEMPLOYMENTID(); ?></td>
                                        <td><?php echo $classification->getEMPLOYMENTNAME(); ?></td>
                                        <td><?php echo $classification->getEMPLOYMENTHRS(); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary text-white" id="UpdateBtn" data-bs-toggle="modal" data-bs-target="#updateEmploymentTypeModal" title="Update Employment Status" style="width: 2.5rem; height: 1.7rem; border: none;">
                                                <i class="fa-regular fa-pen-to-square UpdateEmploymentBtn" id="update-employment-type-btn" style="font-size: .8rem;" data-employment-id="<?php echo $classification->getEMPLOYMENTID(); ?>" data-employment-type="<?php echo $classification->getEMPLOYMENTNAME(); ?>" data-employment-hrs="<?php echo $classification->getEMPLOYMENTHRS(); ?>"></i>
                                            </button>

                                            <button type="button" class="btn btn-danger deleteEmploymentBtn" title="Delete Employment Status" style="width: 2.5rem; height: 1.7rem; border: none;" data-employment-id="<?php echo $classification->getEMPLOYMENTID(); ?>">
                                                <i class="fa-regular fa-trash-can" style="font-size: .8rem;"></i>
                                            </button>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6">No Data Found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Add Employment Classification Modal -->
                <div class="modal fade" id="addEmploymentTypeModal" tabindex="-1" aria-labelledby="addEmploymentTypeModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addEmploymentTypeModalLabel">Add Employment Status</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-2">
                                    Employment Status:
                                    <input type="text" class="form-control mt-1" id="addEmploymentType">
                                </div>
                                <div class="form-group mb-2">
                                    Required Hours:
                                    <input type="text" class="form-control mt-1" id="addRequiredHours">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cancelAddEmploymentBtn" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="saveAddEmploymentBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Employment Classification Modal -->
                <div class="modal fade" id="updateEmploymentTypeModal" tabindex="-1" aria-labelledby="updateEmploymentTypeModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Employment Status</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group mb-2">
                                        Employment Status:
                                        <input type="text" class="form-control mt-1" id="modal-update-employment-type">
                                    </div>
                                    <div class="form-group mb-2">
                                        Required Hours:
                                        <input type="text" class="form-control mt-1" id="modal-update-employment-hrs">
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cancelUpdatedEmploymentBtn" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="saveUpdatedEmploymentBtn">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="<?= ROOT ?>scripts/Admin/employmentClassification.js"></script>
</body>

</html>
