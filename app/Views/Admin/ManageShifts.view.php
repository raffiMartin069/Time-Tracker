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
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/manage-admin.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/table.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/tabs-modal.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/manage-shift.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/manage-shift-btns.css" />
</head>

<body>
    <div id="wrapper">
        <div class="px-2" style="padding-top: 2.5rem;">
            <div class="container"></div>
        </div>
        <div class="mx-2 my-4 rounded p-2 shadow reports-body" style="margin-top: -2rem !important;">
            <div class="container" style="text-align: center;">

                <div class="button-container">
                    <button class="btn" id="addShiftBtn" title="Add Shift" style="width: 6rem; height: 1.8rem; margin-top: .5rem; border: 1px solid #e0e0e0; margin-left: auto; margin-right: 1px !important;">
                        <i class="lni lni-plus" style="font-size: 10px;"></i>
                        <span class="ms-2" style="font-size: 12px;">Create</span>
                    </button>
                </div>

                <div class="tabs-container">
                    <ul class="tabs">
                        <li><a class="nav-link" href="?page=editProfile">Edit Profile</a></li>
                        <li><a class="nav-link" href="?page=manageAdmin">Manage Admin</a></li>
                        <li><a class="nav-link active" href="?page=manageShift">Manage Shift</a></li>
                        <li><a class="nav-link" href="?page=employmentClassification">Employment Status</a></li>
                        <li><a class="nav-link" href="?page=manageJobPosition">Job Position</a></li>
                        <li><a class="nav-link" href="?page=recycleBin">Recycle Bin</a></li>
                    </ul>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0 bg-white text-center">
                        <thead style="position: sticky; top: 0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <tr>
                                <th hidden>Shift ID</th>
                                <th>Shift Schedule</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="adminTableBody">
                            <?php if (!empty($shifts) && is_array($shifts)) : ?>
                                <?php foreach ($shifts as $shift) : ?>
                                    <tr>
                                        <td hidden><?php echo $shift->getSHIFTID(); ?></td>
                                        <td><?php echo $shift->getSHIFTNAME(); ?></td>
                                        <td>
                                            <button class="btn btn-danger deleteShiftBtn" title="Delete Shift" style="width: 2.5rem; height: 1.7rem; border: none; background-color: #dc3545 !important;" data-shift-id="<?php echo $shift->getSHIFTID(); ?>">
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

                <!-- Add Shift Modal -->
                <div class="modal fade" id="addShiftModal" tabindex="-1" aria-labelledby="addShiftModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addShiftModalLabel">Add Shift</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Select Days:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="0" id="sunday">
                                        <label class="form-check-label" for="sunday">Sunday</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="monday">
                                        <label class="form-check-label" for="monday">Monday</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="2" id="tuesday">
                                        <label class="form-check-label" for="tuesday">Tuesday</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="3" id="wednesday">
                                        <label class="form-check-label" for="wednesday">Wednesday</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="4" id="thursday">
                                        <label class="form-check-label" for="thursday">Thursday</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="5" id="friday">
                                        <label class="form-check-label" for="friday">Friday</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="6" id="saturday">
                                        <label class="form-check-label" for="saturday">Saturday</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cancelShiftBtn" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="saveShiftBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="<?= ROOT ?>scripts/Admin/manageShift.js"></script>

</body>

</html>
