 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>WhereToNext | Employee</title>
     <link rel="preconnect" href="https://fonts.googleapis.com" />
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                         <h6><span class="empFname"><?php echo $report->getFNAME(); ?></span> <span> </span> <span class="empMname"><?php echo $report->getMNAME(); ?></span> <span> </span> <span class="empLname"><?php echo $report->getLNAME(); ?></span></h6>
                         <span class="empEmail"><?php echo $report->getEMAIL(); ?></span><span> | </span><span class="empContact"><?php echo $report->getECN(); ?></span>
                     </div>
                 <?php endforeach; ?>

                 <div class="container light-style flex-grow-4 container-p-y"> 
                     <div class="card overflow-hidden">
                         <div class="row no-gutters row-bordered row-border-light">
                             <div class="col-md-3 pt-0">
                                 <div class="list-group account-settings-links">
                                     <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account-general">General</a>
                                     <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#account-change-password">Change Password</a>
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
                                                    <div class="form-group row" style="margin-bottom: 10px;">
                                                        <div class="col-md-4">
                                                            <label for="getmyfname" class="text-secondary text-start" style="font-size: 12px; display:block;">First Name</label>
                                                            <input type="text" class="form-control mt-1" id="getmyfname" value="<?php echo $report->getFNAME(); ?>" disabled>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="getmymname" class="text-secondary text-start" style="font-size: 12px; display:block;">Middle Name</label>
                                                            <input type="text" class="form-control mt-1" id="getmymname" value="<?php echo $report->getMNAME(); ?>" disabled>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="getmylname" class="text-secondary text-start" style="font-size: 12px; display:block;">Last Name</label>
                                                            <input type="text" class="form-control mt-1" id="getmylname" value="<?php echo $report->getLNAME(); ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="getmybirthday" class="text-secondary text-start" style="font-size: 12px; display:block;">Birthdate</label>
                                                        <input class="form-control mt-1" id="getmybirthday" type="date" value="<?php echo $report->getBIRTHDATE(); ?>" id="date" disabled>
                                                    </div>
                                                <?php endforeach; ?>
                                                <button type="button" class="save-btn" id="editGeneralBtn">Update</button>
                                                <button type="submit" class="save-btn align-end" id="saveGeneralBtn" disabled>Save</button>
                                            </form>
                                         </div>
                                     </div>
                                     <div class="tab-pane fade" id="account-change-password">
                                         <div class="card-body pb-2">
                                             <form id="passwordInfoForm">
                                             <?php foreach ($results as $report) : ?>
                                                    <div class="form-group" style="margin-bottom: 10px;">
                                                        <label for="getmycurrpassword" class="text-secondary text-start" style="font-size: 12px; display:block;">Old Password</label>
                                                        <input type="password" class="form-control mt-1" id="getmycurrpassword" disabled required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="getmynewpassword" class="text-secondary text-start" style="font-size: 12px; display:block;">New Password</label>
                                                        <input type="password" class="form-control mt-1" id="getmynewpassword" disabled required>
                                                    </div>
                                                <?php endforeach; ?>
                                                 <button type="button" class="save-btn mt-1" id="editPasswordBtn">Update</button>
                                                 <button type="submit" class="save-btn mt-1" id="savePasswordBtn" disabled>Save</button>
                                             </form>
                                         </div>
                                     </div>
                                     <div class="tab-pane fade" id="account-info">
                                         <hr class="border-light m-0">
                                         <div class="card-body pb-2">
                                             <form id="contactInfoForm">
                                             <?php foreach ($results as $report) : ?>
                                                    <div class="form-group" style="margin-bottom: 10px;">
                                                        <label for="getmyemail" class="text-secondary text-start" style="font-size: 12px; display:block;">Email</label>
                                                        <input type="email" class="form-control mt-1" id="getmyemail" value="<?php echo $report->getEMAIL(); ?>" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="getmyecn" class="text-secondary text-start" style="font-size: 12px; display:block;">Contact Number</label>
                                                        <input type="text" class="form-control mt-1" id="getmyecn" value="<?php echo $report->getECN(); ?>" disabled>
                                                    </div>
                                                <?php endforeach; ?>
                                                 <button type="button" class="save-btn mt-1" id="editContactBtn">Update</button>
                                                 <button type="submit" class="save-btn mt-1" id="saveContactBtn" disabled>Save</button>
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
     </div>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="<?= ROOT ?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
     <script>
        var isSuperAdminID = "<?php echo $_SESSION['userId']; ?>";
     </script>  
     <script defer src="<?= ROOT ?>scripts/Admin/settings.js"></script> 

 </body>

 </html>
