 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>WhereToNext | Employee</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <link rel="preconnect" href="https://fonts.googleapis.com" />
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <link rel="stylesheet" href="<?= ROOT ?>css/Employee/reports.css" />
     <link rel="stylesheet" href="<?= ROOT ?>css/settings.css" /> 
     <link rel="stylesheet" href="<?= ROOT ?>css/default.css" />
</head>

 <body>
     <div id="wrapper">
         <div class="px-2" style="padding-top: 2.5rem;">
             <div class="container"></div>
         </div>
         <div class="mx-2 my-4 rounded p-2 shadow reports-body" style="margin-top: -2rem !important;">
             <div class="container" style="text-align: center;">
                 <div class="header">
                     <h6>Profile Settings</h6>
                     <br>
                 </div>

                 <?php 
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
 
                    $empId = isset($_SESSION["userId"]) ? $_SESSION["userId"] : null;

                    // This is the path for the default profile photo
                    $defaultPhoto = ROOT . "assets/img/employee/default-settings-profile.png";

                    // Sets the default image as the profile photo if the user have not yet uploaded any
                    // Otherwise, this will fetch their uploaded profile photo from the database
                    $getProfilePhoto = $defaultPhoto;  

                    if ($empId) {
                        $returnQuery = "SELECT image FROM employee_credential WHERE emp_id = :emp_id";
                        $returnParams = [':emp_id' => $empId];

                         $returnData = $this->Query($returnQuery, $returnParams);
 
                        if (!empty($returnData) && !empty($returnData[0]->image)) {
                            $getProfilePhoto = $returnData[0]->image;
                        }
                    }
                    ?> 

                 <div class="profile-pic-container">
                     <form id="profilePicForm" class="profilePicChange" method="post" enctype="multipart/form-data">
                         <img id="profilePic" class="profile-pic" src="<?php echo $getProfilePhoto; ?>" alt="Profile Picture">
                         <input type="file" id="profilePhoto" class="getmyimg" name="profilePhoto">
                     </form>
                 </div>


                 <?php foreach ($results as $report) : ?>
                     <div class="profile-info">
                         <h6><span class="empFname"><?php echo $report->getFNAME();?></span> <span> </span> <span class="empMname"><?php echo $report->getMNAME();?></span> <span> </span> <span class="empLname"><?php echo $report->getLNAME(); ?></span></h6>
                         <span class="empEmail"><?php echo $report->getEMAIL(); ?></span><span> | </span><span class="empContact"><?php echo $report->getECN(); ?></span>
                     </div>
                 <?php endforeach; ?>

                 <div class="container light-style flex-grow-1 container-p-y">

                     <div class="card overflow-hidden">
                         <div class="row no-gutters row-bordered row-border-light">
                             <div class="col-md-3 pt-0">
                                 <div class="list-group account-settings-links">
                                     <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account-general">General</a>
                                     <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#account-change-password">Change password</a>
                                     <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#account-info">Contact</a>
                                 </div>
                             </div>
                             <div class="col-md-9">
                                 <div class="tab-content">
                                     <div class="tab-pane fade active show" id="account-general">
                                         <hr class="border-light m-0">
                                         <div class="card-body">
                                             <form id="generalInfoForm">
                                                 <?php foreach ($results as $report) : ?>
                                                    <div class="form-group">
                                                         <input type="text" class="form-control mb-1" id="getmylname" value="<?php echo $report->getLNAME(); ?>" placeholder="Last Name" disabled>
                                                     </div>
                                                      
                                                     <div class="form-group">
                                                         <input type="text" class="form-control mt-3" id="getmymname" value="<?php echo $report->getMNAME(); ?>" placeholder="Middle Name" disabled>
                                                     </div>
                                                     <div class="form-group">
                                                         <input type="text" class="form-control mt-3" id="getmyfname" value="<?php echo $report->getFNAME(); ?>" placeholder="First Name" disabled>
                                                     </div>
                                                     <div class="form-group">
                                                         <input placeholder="Birth Date" class="form-control mt-3" id="getmybirthday" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo $report->getBIRTHDATE(); ?>" id="date" disabled>
                                                     </div>
                                                 <?php endforeach; ?>
                                                 <button type="button" class="save-btn mt-3" id="editGeneralBtn">Update</button>
                                                 <button type="submit" class="save-btn mt-3" id="saveGeneralBtn" disabled>Save</button>
                                             </form>
                                         </div>
                                     </div>
                                     <div class="tab-pane fade" id="account-change-password">
                                         <div class="card-body pb-2">
                                             <form id="passwordInfoForm">
                                                 <?php foreach ($results as $report) : ?>
                                                     <div class="form-group">
                                                         <input type="password" class="form-control" id="getmycurrpassword" placeholder="Password" disabled required>
                                                     </div>
                                                     <div class="form-group">
                                                         <input type="password" class="form-control mt-3" id="getmynewpassword" placeholder="New password" disabled required>
                                                     </div>
                                                 <?php endforeach; ?>
                                                 <button type="button" class="save-btn mt-3" id="editPasswordBtn">Update</button>
                                                 <button type="submit" class="save-btn mt-3" id="savePasswordBtn" disabled>Save</button>
                                             </form>
                                         </div>
                                     </div>
                                     <div class="tab-pane fade" id="account-info">
                                         <hr class="border-light m-0">
                                         <div class="card-body pb-2">
                                             <form id="contactInfoForm">
                                                 <?php foreach ($results as $report) : ?>
                                                     <div class="form-group">
                                                         <input type="text" class="form-control mt-3" id="getmyemail" value="<?php echo $report->getEMAIL(); ?>" placeholder="Email" disabled>
                                                     </div>
                                                     <div class="form-group">
                                                         <input type="text" class="form-control mt-3" id="getmyecn" value="<?php echo $report->getECN(); ?>" placeholder="Contact Number" disabled>
                                                     </div>
                                                 <?php endforeach; ?>
                                                 <button type="button" class="save-btn mt-3" id="editContactBtn">Update</button>
                                                 <button type="submit" class="save-btn mt-3" id="saveContactBtn" disabled>Save</button>
                                             </form>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     </div>
     </div>

     <!-- Error Modal -->
     <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-body">
                     Sorry, you've already used your attempt to change your personal information. Please contact support if you need further assistance.
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" id="closeError" data-dismiss="modal">Close</button>
                 </div>
             </div>
         </div>
     </div>

     <!-- Changes Modal -->
     <div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-body">
                     Your changes has been successfully saved!
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" id="closeChangeModal" data-dismiss="modal">Close</button>
                 </div>
             </div>
         </div>
     </div>

     </div>

     <script>
         $(document).ready(function() {
             let isEditAllowed = true;

             $('#editGeneralBtn').click(function() {
                 if (isEditAllowed) {
                     $('#generalInfoForm input').prop('disabled', false);
                     $('#saveGeneralBtn').prop('disabled', false);
                 } else {
                     $('#errorModal').modal('show');
                     $('#closeError').click(function() {
                         $('#errorModal').modal('hide');
                     })
                 }
             });

             $("#generalInfoForm").submit(function(event) {
                 event.preventDefault();
                 $('#generalInfoForm input').prop('disabled', true);
                 isEditAllowed = false;
                 var fName = $("#getmyfname").val();
                 var mName = $("#getmymname").val();
                 var lName = $("#getmylname").val();
                 var birthDate = $("#getmybirthday").val();

                 $.ajax({
                     url: "Employee/UpdateSettingsGeneralInfo",
                     method: 'POST',
                     data: {
                         f_name: fName,
                         m_name: mName,
                         l_name: lName,
                         birth_date: birthDate
                     },
                     success: function(data) {
                         $(".empFname").text(data.f_name);
                         $(".empMname").text(data.m_name);
                         $(".empLname").text(data.l_name);
                         $('#changeModal').modal('show');
                         $('#closeChangeModal').click(function() {
                             $('#changeModal').modal('hide');
                         })
                     },
                     error: function(xhr, status, error) {
                         $('#errorModal').modal('show');
                         $('#closeError').click(function() {
                             $('#errorModal').modal('hide');
                         })
                     }
                 });
             });


             $('#editPasswordBtn').click(function() {
                 $('#passwordInfoForm input').prop('disabled', false);
                 $('#savePasswordBtn').prop('disabled', false);
             });

             // Password Form 
             $("#passwordInfoForm").submit(function(event) {
                 event.preventDefault();
                 $('#passwordInfoForm input').prop('disabled', true);
                 var currPassword = $("#getmycurrpassword").val();
                 var newPassword = $("#getmynewpassword").val();

                 console.log("Fetching passwords, currpass: " + currPassword + ", newpass: " + newPassword);

                 $.ajax({
                     url: "Employee/UpdateSettingsPasswordInfo",
                     method: 'POST',
                     data: {
                         curr_password: currPassword,
                         new_password: newPassword
                     },
                     success: function(data) {
                         $('#changeModal').modal('show');
                         $('#closeChangeModal').click(function() {
                             $('#changeModal').modal('hide');
                             $('#getmycurrpassword').val('');
                             $('#getmynewpassword').val('');
                         })
                     },
                     error: function(xhr, status, error) {
                         $('.modal-body').replaceWith("Password is too common and easily guessable. Please try again.");
                         $('#errorModal').modal('show');
                         $('#closeError').click(function() {
                             $('#errorModal').modal('hide');
                         })
                         // console.error('AJAX error:', status, error, xhr.responseText);
                     }
                 });
             });

             // Contact Form 
             $('#editContactBtn').click(function() {
                 $('#contactInfoForm input').prop('disabled', false);
                 $('#saveContactBtn').prop('disabled', false);
             });

             $("#contactInfoForm").submit(function(event) {
                 event.preventDefault();
                 $('#contactInfoForm input').prop('disabled', true);
                 var email = $("#getmyemail").val();
                 var ecn = $("#getmyecn").val();

                 console.log("Fetching contacts, email: " + email + ", ecn: " + ecn);

                 $.ajax({
                     url: "Employee/UpdateSettingsContactInfo",
                     method: 'POST',
                     data: {
                         email: email,
                         ecn: ecn
                     },
                     success: function(data) {
                         $(".empEmail").text(data.email);
                         $(".empContact").text(data.ecn);
                         $('#changeModal').modal('show');
                         $('#closeChangeModal').click(function() {
                             $('#changeModal').modal('hide');
                         })
                     },
                     error: function(xhr, status, error) {
                         console.error('AJAX error:', status, error, xhr.responseText);
                     }
                 });
             });

             $('#profilePic').on('click', function() {
                 $('#profilePhoto').click();
             });

             $('#profilePhoto').on('change', function() {
                 let file = this.files[0];
                 if (file) {
                     let reader = new FileReader();
                     reader.onload = function(e) {
                         $('#profilePic').attr('src', e.target.result);
                     }
                     reader.readAsDataURL(file);
                     // Automatically submit the form
                     $('#profilePicForm').submit();
                 }
             });

             $('.profilePicChange').on('submit', function(e) {
                 e.preventDefault();
                 let profilePhoto = new FormData(this);

                 $.ajax({
                     url: 'Employee/UpdateProfilePic',
                     type: 'POST',
                     data: profilePhoto,
                     processData: false,
                     contentType: false,
                     success: function(data) { 
                         $('#profilePic').attr('src', data.profilePhoto);
                         $('#changeModal').modal('show');
                         $('#closeChangeModal').click(function() {
                             $('#changeModal').modal('hide');
                         });

                     },
                     error: function() {
                         alert('Error uploading profile picture');
                     }
                 });
             });


         });
     </script>

     <script src="<?= ROOT ?>scripts/Admin/sidebar.js"></script>
     <script src="<?= ROOT ?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdn.lordicon.com/lordicon.js"></script>
 </body>

 </html>