<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login | WTN</title>
  <link rel="icon" type="image/x-icon" href="<?php ROOT ?>assets/img/login/logo_wtn.png">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo ROOT ?>node_modules/bootstrap/dist/css/bootstrap.css" />
  <link rel="stylesheet" href="<?php echo ROOT ?>css/recover/reconfirm.css" />
  <link rel="stylesheet" href="<?php echo ROOT ?>css/default.css" />
  <link rel="stylesheet" href="<?php echo ROOT ?>node_modules/sweetalert2/dist/sweetalert2.css" />
</head>

<body>
  <div id="form-wrapper" class="d-flex align-items-center justify-content-center vh-100 text-center p-3">
    <form id="reconfirm_form" method="POST">
      <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>
      <div>
        <img src="<?php echo ROOT ?>assets/img/login/logo_wtn.png" alt="WhereToNext Logo" style="max-width: 30%"
          class="d-flex m-auto mt-4" />
      </div>
      <div class="mb-3 d-flex">
        <h1 class="px-3 m-auto" style="font-weight: 500; font-size: xx-large">
          WTN Time Tracker
        </h1>
      </div>
      <small class="mb-3"><small class="text-danger">*</small>Enter confirmation code.</small>
      <!-- ID input -->
      <div class="form-outline mb-4 position-relative form-floating">
        <input type="email" id="idNumber" name="idNumber" class="form-control" placeholder="" />
        <label for="idNumber">Confirmation code</label>
      </div>
      <!-- Birth date input -->
      <!-- <div class="form-outline mb-4 position-relative form-floating">
        <input type="date" id="bday" name="bday" class="form-control" placeholder="" />
        <label for="bday">Date of birth</label>
      </div> -->
      <div>
        <!-- Submit button -->
        <button type="submit" id="continueBtn" class="btn btn-primary btn-block mt-4 mb-4 rounded-3 w-100">
          Continue
        </button>
      </div>
    </form>
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex align-items-center justify-content-center text-center p-3">
          <form id="change-pass" method="POST">
            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <div>
                <img src="<?php echo ROOT ?>assets/img/login/logo_wtn.png" alt="WhereToNext Logo" style="max-width: 30%"
                    class="d-flex m-auto mt-4" />
            </div>
            <div class="mb-3 d-flex">
                <h1 class="px-3 m-auto" style="font-weight: 500; font-size: xx-large">
                    WTN Time Tracker
                </h1>
            </div>

            <div class="form-outline mb-4 position-relative">
                <input type="password" id="pass" name="pass" class="form-control" placeholder="Password" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4 position-relative">
                <input type="password" id="confirm_pass" name="confirm_pass" class="form-control" placeholder="Confirm Password" />
            </div>

            <div>
                <input type="checkbox" id="showPass" name="showPass" class="form-check-input" />
                <label for="showPass" class="form-check-label">Show Password</label>
            </div>
            <div>
                <!-- Submit button -->
                <button type="submit" id="submitBtn" value="ToHome"
                    class="btn btn-primary btn-block mt-4 mb-4 rounded-3 w-100">
                    Confirm
                </button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>



  <script src="<?php echo ROOT ?>node_modules/sweetalert2/dist/sweetalert2.js"></script>
  <script defer type="module" src="<?php echo ROOT ?>scripts/Recovery/secondary_check.js"></script>
  <script defer src="<?php echo ROOT ?>scripts/Recovery/change_pass.js"></script>
</body>

</html>