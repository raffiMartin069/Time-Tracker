<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login | WTN</title>
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
  <div id="form-wrapper" class="d-flex align-items-center justify-content-center vh-100">
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
      <!-- ID input -->
      <div class="form-outline mb-4 position-relative">
        <input type="number" id="idNumber" name="idNumber" class="form-control" placeholder="Employee I.D." />
        <img id="login-img" src="<?php echo ROOT?>assets/img/login/person.png" alt="..." style="
              max-width: 1.3rem;
              position: absolute;
              right: 10px;
              top: 50%;
              transform: translateY(-50%);
            " />
      </div>
      <!-- Password input -->
      <div class="form-outline mb-4 position-relative">
        <input type="password" id="pass" name="pass" class="form-control" placeholder="Password" />
        <img id="view-pass" src="<?php echo ROOT?>assets/img/login/view-pass.png" alt="..." style="
              max-width: 1.3rem;
              position: absolute;
              right: 10px;
              top: 0%;
              transform: translateY(-100%);
            " />
        <img id="view" src="<?php echo ROOT?>assets/img/login/view.png" alt="..." style="position: absolute; right: 8px; top: 30%; max-width: 1.6rem" />
      </div>

      <!-- 2 column grid layout for inline styling -->
      <div class="row mb-4">
        <div class="col d-flex justify-content-end">
          <!-- Checkbox -->
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="rememberMe" checked />
            <label class="form-check-label" for="rememberMe">
              Remember me
            </label>
          </div>
        </div>
        <div class="text-end">
          <!-- Simple link -->
          <a href="#!">Forgot password?</a>
        </div>
      </div>
      <div>
        <!-- Submit button -->
        <button type="submit" id="submitBtn" value="ToHome" class="btn btn-primary btn-block mt-4 mb-4 rounded-3 w-100">
          Sign in
        </button>
      </div>
    </form>
  </div>
  <script src="<?php echo ROOT?>node_modules/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo ROOT?>node_modules/sweetalert2/dist/sweetalert2.js"></script>
  <script src="<?php echo ROOT?>scripts/login/login.js"></script>
</body>
</html>