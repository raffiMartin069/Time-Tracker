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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo ROOT?>node_modules/bootstrap/dist/css/bootstrap.css" />
  <link rel="stylesheet" href="<?php echo ROOT?>css/login/login.css" />
  <link rel="stylesheet" href="<?php echo ROOT?>css/login/login-media.css" />
  <link rel="stylesheet" href="<?php echo ROOT?>css/default.css" />
  <link rel="stylesheet" href="<?php echo ROOT?>node_modules/sweetalert2/dist/sweetalert2.css" />
</head>
<body>
  <div id="form-wrapper" class="d-flex align-items-center justify-content-center vh-100 text-center p-3">
    <form id="login-form" method="POST">
      <?php if (isset($error)) : ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>
      <div>
        <img src="<?php echo ROOT?>assets/img/login/logo_wtn.png" alt="WhereToNext Logo" style="max-width: 30%" class="d-flex m-auto mt-4" />
      </div>
      <div class="mb-3 d-flex">
        <h1 class="px-3 m-auto" style="font-weight: 500; font-size: xx-large">
          WTN Time Tracker
        </h1>
      </div>
      <small class="mb-3"><small class="text-danger">*</small>Confirm I.D. and date of birth to continue.</small>
      <!-- ID input -->
      <div class="form-outline mb-4 position-relative form-floating">
        <input type="text" id="idNumber" name="idNumber" class="form-control" placeholder=""/>
        <label for="idNumber">Employee I.D.</label>
      </div>
      <!-- Birth date input -->
      <div class="form-outline mb-4 position-relative form-floating">
        <input type="date" id="bday" name="bday" class="form-control" placeholder="" />
        <label for="bday">Date of birth</label>
      </div>
      <div>
        <!-- Submit button -->
        <button type="submit" id="continueBtn" class="btn btn-primary btn-block mt-4 mb-4 rounded-3 w-100">
          Continue
        </button>
      </div>
    </form>
  </div>
  <script src="<?php echo ROOT?>node_modules/sweetalert2/dist/sweetalert2.js"></script>
</body>
</html>