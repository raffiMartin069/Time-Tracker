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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/reports.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css">
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/table.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/tabs-modal.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/job-position.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/job-position-btns.css" />
</head>

<body>
    <div id="wrapper">
        <div class="px-2" style="padding-top: 2.5rem;">
            <div class="container"></div>
        </div>
        <div class="mx-2 my-4 rounded p-2 shadow reports-body" style="margin-top: -2rem !important;">
            <div class="container" style="text-align: center;">

                <div class="button-container">
                    <button class="btn" id="addJobPositionBtn" title="Add Job Position" data-bs-toggle="modal" data-bs-target="#addJobPositionModal" style="width: 6rem; height: 1.8rem; margin-top: .5rem; border: 1px solid #e0e0e0; margin-left: auto; margin-right: 1px !important;">
                        <i class="lni lni-plus" style="font-size: 10px;"></i>
                        <span class="ms-2" style="font-size: 12px;">Create</span>
                    </button>
                </div>

                <div class="tabs-container">
                    <ul class="tabs">
                        <li><a class="nav-link" href="?page=editProfile">Edit Profile</a></li>
                        <li><a class="nav-link" href="?page=manageAdmin">Manage Admin</a></li>
                        <li><a class="nav-link" href="?page=manageShift">Manage Shift</a></li>
                        <li><a class="nav-link" href="?page=employmentClassification">Employment Status</a></li>
                        <li><a class="nav-link active" href="?page=manageJobPosition">Job Position</a></li>
                        <li><a class="nav-link" href="?page=recycleBin">Recycle Bin</a></li>
                    </ul>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0 bg-white text-center">
                        <thead style="position: sticky; top: 0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <tr>
                                <th hidden>Position ID</th>
                                <th>Job Title</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="adminTableBody">
                            <?php if (!empty($positions) && is_array($positions)) : ?>
                                <?php foreach ($positions as $position) : ?>
                                    <tr>
                                        <td hidden><?php echo $position->getTITLEID(); ?></td>
                                        <td><?php echo $position->getTITLENAME(); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary text-white" id="update-job-position-btn" data-bs-toggle="modal" data-bs-target="#updateJobPositionModal" title="Update Job Position" style="width: 2.5rem; height: 1.7rem; border: none;">
                                                <i class="fa-regular fa-pen-to-square UpdateJobPositionBtn" style="font-size: .8rem;" data-position-id="<?php echo $position->getTITLEID(); ?>" data-position-title="<?php echo $position->getTITLENAME(); ?>"></i>
                                            </button>

                                            <button type="button" class="btn btn-danger deleteJobPositionBtn" title="Delete Job Position" style="width: 2.5rem; height: 1.7rem; border: none;" data-position-id="<?php echo $position->getTITLEID(); ?>">
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

                <!-- Add Job Position Modal -->
                <div class="modal fade" id="addJobPositionModal" tabindex="-1" aria-labelledby="addJobPositionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addJobPositionModalLabel">Add Job Position</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-2">
                                    Job Title:
                                    <input type="text" class="form-control mt-1" id="addJobPosition">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cancelAddJobPositionBtn" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="saveAddJobPositionBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Employment Classification Modal -->
                <div class="modal fade" id="updateJobPositionModal" tabindex="-1" aria-labelledby="updateJobPositionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Job Position</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group mb-2">
                                        Title:
                                        <input type="text" class="form-control mt-1" id="modal-update-job-position">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cancelUpdatedJobPositionBtn" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="saveUpdatedJobPositionBtn">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="<?= ROOT ?>scripts/Admin/jobPosition.js"></script>

</body>

</html>
