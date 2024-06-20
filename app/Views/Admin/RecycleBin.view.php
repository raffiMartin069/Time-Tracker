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
    <link rel="stylesheet" href="<?= ROOT ?>css/Employee/search.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/manage-admin.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/recycle-bin.css" />
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
                    <li><a class="nav-link" href="?page=manageAdmin">Manage Admin</a></li>
                    <li><a class="nav-link active" href="?page=recycleBin">Recycle Bin</a></li>
                </ul>
                <div class="accordion" id="accordionRecycleBin">
                    <div class="accordion-item">
                        <div class="accordion-header" id="recoverEmployeeHeader" style="font-weight: 600;">
                            Recover Employee
                        </div>
                        <div class="accordion-body" id="recoverEmployeeBody">
                            <form id="recoverForm">
                                <div class="form-group">
                                    <input type="number" placeholder="Enter Tracker ID" class="form-control" id="empIdRecover" required min="1">
                                </div>
                                <button type="submit" class="btn btn-primary" style="min-width: 6rem; padding-bottom: 2rem; border: none">Recover</button>
                                <div id="recoverMessage" class="error-message"></div>
                            </form>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <div class="accordion-header" id="permanentDeleteHeader" style="font-weight: 600;">
                            Permanent Delete Employee
                        </div>
                        <div class="accordion-body" id="permanentDeleteBody">
                            <form id="permanentDeleteForm">
                                <div class="form-group">
                                    <input type="number" placeholder="Enter Tracker ID" class="form-control" id="empIdDelete" required min="1">
                                </div>
                                <button type="submit" class="btn btn-danger" style="min-width: 6rem; padding-bottom: 2rem; border: none">Delete</button>
                                <div id="deleteMessage" class="error-message"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            function preventInvalidInputs(event) {
                if (event.key === '.' || event.key === 'e' || event.key === '-' || event.key === '+') {
                    event.preventDefault();
                }
            }

            $('#empIdRecover').on('keypress', preventInvalidInputs);
            $('#empIdDelete').on('keypress', preventInvalidInputs);


            $('#recoverForm').submit(function(event) {
                event.preventDefault();
                var empId = $('#empIdRecover').val();

                $.ajax({
                    url: "Admin/RecoverAccount",
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        empId: empId
                    },
                    success: function(response) { 
                        if (response.success) {
                            $('#recoverMessage').html('<p class="text-success">' + response.message + '</p>');
                        } else {
                            $('#recoverMessage').html('<p class="text-danger">' + response.message + '</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        console.log('Response:', xhr.responseText);
                        $('#recoverMessage').html('<p class="text-danger">Not found. Try again.</p>');
                    }
                });
            });

            $('#permanentDeleteForm').submit(function(event) {
                event.preventDefault();
                var empId = $('#empIdDelete').val();

                $.ajax({
                    url: "Admin/DeleteAccount",
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        empId: empId
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#deleteMessage').html('<p class="text-success">' + response.message + '</p>');
                        } else {
                            $('#deleteMessage').html('<p class="text-danger">' + response.message + '</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        $('#deleteMessage').html('<p class="text-danger">Not found. Try again.</p>');
                    }
                });
            });

            $('.accordion-header').click(function() {
                $(this).next('.accordion-body').slideToggle();
            });
        });
    </script>
</body>
</html>
