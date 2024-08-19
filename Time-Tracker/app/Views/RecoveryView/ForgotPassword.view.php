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
  <link rel="stylesheet" href="<?php echo ROOT?>css/recover/recovery.css" />
  <link rel="stylesheet" href="<?php echo ROOT?>css/default.css" />
  <link rel="stylesheet" href="<?php echo ROOT?>node_modules/sweetalert2/dist/sweetalert2.css" />
</head>
<body>
  <div id="form-wrapper" class="d-flex align-items-center justify-content-center vh-100 text-center p-3">
    <form id="initial-forgotpass" method="POST">
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
      <!-- Email input -->
      <div class="form-outline mb-4 position-relative form-floating">
        <input type="email" id="email" name="email" class="form-control" placeholder=""/>
        <label for="email">Email</label>
      </div>
      <!-- Birth date input -->
      <!-- <div class="form-outline mb-4 position-relative form-floating">
        <input type="text" id="bday" name="bday" class="form-control" placeholder="" />
        <label for="bday">Token</label>
      </div>
      <div> -->
        <!-- Submit button -->
        <button type="submit" id="sendBtn" class="btn btn-primary btn-block mt-4 mb-4 rounded-3 w-100">
          Send
        </button>
      </div>
    </form>
  </div>
  <script src="<?php echo ROOT?>node_modules/sweetalert2/dist/sweetalert2.js"></script>
  <script defer type="module" src="<?php echo ROOT ?>scripts/Recovery/forgotpass.js"></script>
</body>
</html>