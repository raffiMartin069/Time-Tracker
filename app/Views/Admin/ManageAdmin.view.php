<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhereToNext | Employee</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/reports.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css">
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/manage-admin.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/manage-admin-btns.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/table.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/tabs-modal.css" />
</head>

<body>
    <div id="wrapper">
        <div class="px-2" style="padding-top: 2.5rem;">
            <div class="container"></div>
        </div>
        <div class="mx-2 my-4 rounded p-2 shadow reports-body" style="margin-top: -2rem !important;">
            <div class="container" style="text-align: center;">

                <div class="button-container">
                    <button class="btn" id="addAdminBtn" title="Add Admin(s)" style="width: 6rem; height: 1.8rem; margin-top: .5rem; margin-left: 70rem !important; border: 1px solid #e0e0e0; margin-left: auto; margin-right: 1px !important;">
                        <i class="lni lni-plus" style="font-size: 10px;"></i>
                        <span class="ms-2" style="font-size: 12px;">Create</span>
                    </button>
                    <button class="btn" id="deleteBtn" title="Delete Admin(s)" style="width: 6rem; height: 1.8rem; margin-top: .5rem; border: 1px solid #e0e0e0; margin-left: auto; margin-right: 1px !important;">
                        <i class="fa-regular fa-trash-can" style="font-size: 10px;"></i>
                        <span class="ms-2" style="font-size: 12px;">Remove</span>
                    </button>
                </div>

                <div class="tabs-container">
                    <ul class="tabs">
                        <li><a class="nav-link" href="?page=editProfile">Edit Profile</a></li>
                        <li><a class="nav-link active" href="?page=manageAdmin">Manage Admin</a></li>
                        <li><a class="nav-link" href="?page=manageShift">Manage Shift</a></li>
                        <li><a class="nav-link" href="?page=employmentClassification">Employment Status</a></li>
                        <li><a class="nav-link" href="?page=manageJobPosition">Job Position</a></li>
                        <li><a class="nav-link" href="?page=recycleBin">Recycle Bin</a></li>
                    </ul>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0 bg-white text-center">
                        <thead style="position: sticky; top: 0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody id="adminTableBody">
                            <?php if (!empty($admins) && is_array($admins)) : ?>
                                <?php foreach ($admins as $admin) : ?>
                                    <tr>
                                        <td><?php echo $admin->getEMPID(); ?></td>
                                        <td><?php echo $admin->getEMPNAME(); ?></td>
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
            </div>
        </div>
    </div>

    <!-- Add admin modal -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminModalLabel" style="border-radius: 10px; width:8rem;">Add Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="checkbox-group">
                    </div>
                </div>
                <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 2px;">
                    <button type="button" class="btn btn-secondary" id="cancelAddAdminBtn" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveAdminBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete admin modal -->
    <div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAdminModalLabel">Delete Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="checkbox-group" id="delCheckBox">
                    </div>
                </div>
                <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 2px;">
                    <button type="button" class="btn btn-secondary" id="cancelDeleteAdminBtn" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= ROOT ?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="<?= ROOT ?>scripts/Admin/manageAdmin.js"></script>
</body>

</html>