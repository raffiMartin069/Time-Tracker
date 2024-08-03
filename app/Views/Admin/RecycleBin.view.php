<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhereToNext | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/reports.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css">
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/table.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/tabs-modal.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/recycle-bin.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/recycle-bin-btns.css" />

</head>

<body>
    <div id="wrapper">
        <div class="px-2" style="padding-top: 2.5rem;">
            <div class="container"></div>
        </div>
        <div class="mx-2 my-4 rounded p-2 shadow reports-body" style="margin-top: -2rem !important;">
            <div class="container" style="text-align: center;">
                <div class="tabs-container">
                    <ul class="tabs">
                        <li><a class="nav-link" href="?page=editProfile">Edit Profile</a></li>
                        <li><a class="nav-link" href="?page=manageAdmin">Manage Admin</a></li>
                        <li><a class="nav-link" href="?page=manageShift">Manage Shift</a></li>
                        <li><a class="nav-link" href="?page=employmentClassification">Employment Status</a></li>
                        <li><a class="nav-link" href="?page=manageJobPosition">Job Position</a></li>
                        <li><a class="nav-link active" href="?page=recycleBin">Recycle Bin</a></li>
                    </ul>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0 bg-white text-center" id="try">
                        <thead style="position: sticky; top: 0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <tr>
                                <th>Employee ID</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Birthdate</th>
                                <th>Hired Date</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Position</th>
                                <th>Shift</th>
                                <th>Employment Status</th>
                                <th>Required Hours</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="adminTableBody">
                            <?php if (!empty($recycles) && is_array($recycles)) : ?>
                                <?php foreach ($recycles as $recycle) : ?>
                                    <tr>
                                        <td><?php echo $recycle->getEMPID(); ?></td>
                                        <td><?php echo $recycle->getEMPLNAME(); ?></td>
                                        <td><?php echo $recycle->getEMPFNAME(); ?></td>
                                        <td><?php echo $recycle->getEMPMNAME(); ?></td>
                                        <td><?php echo $recycle->getEMPBIRTHDATE(); ?></td>
                                        <td><?php echo $recycle->getEMPHIREDATE(); ?></td>
                                        <td><?php echo $recycle->getEMPEMAIL(); ?></td>
                                        <td><?php echo $recycle->getEMPCONTACT(); ?></td>
                                        <td><?php echo $recycle->getEMPPOSITION(); ?></td>
                                        <td><?php echo $recycle->getEMPSHIFT(); ?></td>
                                        <td><?php echo $recycle->getEMPSTAT(); ?></td>
                                        <td><?php echo $recycle->getEMPHRS(); ?></td>
                                        <td>
                                            <div class="button-group">
                                                <button type="button" class="btn btn-primary text-white recoverAccountBtn" id="recover-account-btn" title="Recover Employee Account" style="width: 2.5rem; height: 1.7rem; border: none;" data-recycle-id="<?php echo $recycle->getEMPID(); ?>">
                                                    <i class="fa-solid fa-arrows-rotate" style="font-size: .8rem;"></i>
                                                </button>

                                                <button type="button" class="btn btn-danger deleteAccountBtn" id="delete-account-btn" title="Permanently Delete Employee Account" style="width: 2.5rem; height: 1.7rem; border: none;" data-delete-recycle-id="<?php echo $recycle->getEMPID(); ?>">
                                                    <i class="fa-regular fa-trash-can" style="font-size: .8rem;"></i>
                                                </button>
                                            </div>
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

            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="<?= ROOT ?>scripts/Admin/recycleBin.js"></script> 
</body>

</html>