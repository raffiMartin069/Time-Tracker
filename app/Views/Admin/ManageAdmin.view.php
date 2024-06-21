<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhereToNext | Employee</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/reports.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/search.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/manage-admin.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css">
    <link rel="stylesheet" href="<?= ROOT ?>css/tables.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div id="wrapper">
        <div class="px-2" style="padding-top: 2.5rem;">
            <div class="container"></div>
        </div>
        <div class="mx-2 my-4 rounded p-2 shadow reports-body" style="margin-top: -2rem !important;">
            <div class="container" style="text-align: center;">
                <ul class="tabs">
                    <li><a class="nav-link" href="?page=editProfile">Edit Profile Information</a></li>
                    <li><a class="nav-link active" href="?page=manageAdmin">Manage Admin</a></li>
                    <li><a class="nav-link" href="?page=recycleBin">Recycle Bin</a></li>
                </ul>
                <div class="button-container gap-3 mb-3" style="justify-content: flex-end;">
                    <button class="btn btn-primary" id="addAdminBtn"
                        style="width: 3rem; height: 2rem; border: none; margin-right: -.4rem;"><i
                            class="lni lni-plus"></i></i></button>
                    <button class="btn btn-danger" id="deleteBtn" style="width: 4rem; height: 2rem; border: none;"><i
                            class="lni lni-remove-file"></i></button>
                </div>
                <div class="table-responsive" style="margin-top: -1rem;">
                    <table class="table table-striped align-middle mb-0 bg-white text-center">
                        <thead style="position: sticky; top: 0;">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody id="adminTableBody">
                            <?php if (!empty($admins) && is_array($admins)): ?>
                                <?php foreach ($admins as $admin): ?>
                                    <tr>
                                        <td><?php echo $admin->getEMPID(); ?></td>
                                        <td><?php echo $admin->getEMPNAME(); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2">No data found.</td>
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
                    <h5 class="modal-title" id="addAdminModalLabel" style="border-radius: 10px; width:8rem;">Add Admin
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="checkbox-group">
                    </div>
                </div>
                <div class="modal-footer border">
                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary w-100" id="saveAdminBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete admin modal -->
    <div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel"
        aria-hidden="true">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger w-100" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT ?>node_modules/jquery/dist/jquery.min.js"></script>
    <script defer type="module" src="<?= ROOT ?>scripts/Admin/manage_admin.js"></script>
</body>

</html>