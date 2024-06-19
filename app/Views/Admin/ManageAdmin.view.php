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
                <div class="button-container" style="justify-content: flex-end;"> 
                    <button class="btn btn-primary" id="addAdminBtn" style="width: 3rem; height: 2rem; border: none; margin-right: -.4rem;"><i class="lni lni-plus"></i></i></button>
                    <button class="btn btn-danger" id="deleteBtn" style="width: 3rem; height: 2rem; border: none;"><i class="lni lni-remove-file"></i></button>
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
                            <?php if (!empty($admins) && is_array($admins)) : ?>
                                <?php foreach ($admins as $admin) : ?>
                                    <tr>
                                        <td><?php echo $admin->getEMPID(); ?></td>
                                        <td><?php echo $admin->getEMPNAME(); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3">No data found.</td>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#addAdminBtn").click(function() {
                $.ajax({
                    url: "Admin/manageNoneAdminAccess",
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var addAdminModal = $(".checkbox-group");
                        addAdminModal.empty();
                        if (data.length > 0) {
                            data.forEach(function(report) {
                                var option = `
                                    <label>
                                        <input type="checkbox" class="select-member" value="${report.EMP_ID}">
                                        ${report.EMPLOYEE}
                                    </label>`;
                                addAdminModal.append(option);
                            });
                        } else {
                            addAdminModal.append('<p>No Data Found</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading non-admin employees:', xhr.responseText);
                        alert('Failed to load non-admin employees.');
                    }
                });
                $('#addAdminModal').modal('show');
            });

            // Adds admin to the list of admins
            $('#saveAdminBtn').click(function() {
                var empIds = [];
                $('.select-member:checked').each(function() {
                    empIds.push($(this).val());
                });

                if (empIds.length === 0) {
                    alert('Please select at least one member to add as admin.');
                    return;
                }

                $.ajax({
                    url: 'Admin/manageNoneAdminAccess',
                    method: 'POST',
                    data: {
                        empId: empIds
                    },
                    dataType: 'json',
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error adding admins:', xhr.responseText);
                        alert('An error occurred while adding admin(s).');
                    }
                });
            });

            // Opens delete admin modal
            $("#deleteBtn").click(function() {
                $.ajax({
                    url: "Admin/manageAdminAccess",
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var delAdmin = $("#delCheckBox");
                        delAdmin.empty();
                        if (data.length > 0) {
                            data.forEach(function(report) {
                                var row = `
                                    <label>
                                        <input type="checkbox" class="select-member" value="${report.emp_id}">
                                        ${report.employee}
                                    </label>`;
                                delAdmin.append(row);
                            });
                        } else {
                            delAdmin.append('<p>No Data Found</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading admin employees:', xhr.responseText);
                        alert('Failed to load admin employees.');
                    }
                });
                $('#deleteAdminModal').modal('show');
            });

            // Deleting admins from selection
            $('#confirmDeleteBtn').click(function() {
                var empIds = [];
                $('.select-member:checked').each(function() {
                    empIds.push($(this).val());
                });

                if (empIds.length === 0) {
                    alert('Please select at least one admin to delete.');
                    return;
                }

                $.ajax({
                    url: 'Admin/manageAdminAccess',
                    method: 'POST',
                    data: {
                        empId: empIds
                    },
                    dataType: 'json',
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting admins:', xhr.responseText);
                        alert('An error occurred while deleting admin(s).');
                    }
                });
            });

            // Highlight active tab
            var currentPage = new URLSearchParams(window.location.search).get('page');
            if (currentPage) {
                $('.tabs a').removeClass('active');
                $('.tabs a[href="?page=' + currentPage + '"]').addClass('active');
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>