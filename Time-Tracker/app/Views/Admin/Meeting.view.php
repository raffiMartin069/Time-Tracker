<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhereToNext | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo ROOT ?>css/default.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/main-page.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/main-page-hovers.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/main-page-icon.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/Admin/media.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/default.css" />
    <link rel="stylesheet" href="<?php echo ROOT ?>node_modules/sweetalert2/dist/sweetalert2.css" />
    <link rel="stylesheet" href="<?= ROOT ?>css/tables.css" />
</head>

<body>
    <div id="wrapper">
        <div class="px-2 pt-5 ">
            <div class="container">
                <noscript>
                    <div class="noscript-visible"
                        style="background-color: #ffcc00; color: black; padding: 20px; text-align: center;">
                        Warning: JavaScript is disabled in your browser. Some features of this site will not work.
                        Please enable
                        JavaScript to continue.
                    </div>
                </noscript>
                <form class="rounded p-5 shadow" style="background: hsl(45, 50%, 97%);">
                    <!-- Name input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" id="form4Example1" class="form-control" placeholder="" />
                        <label class="form-label" for="form4Example1">Meeting Title</label>
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <div>
                            <input type="datetime-local" id="form4Example2" class="form-control" />
                            <label class="form-label" for="form4Example2">Meeting Start</label>
                        </div>
                        <div>
                            <input type="datetime-local" id="form4Example2" class="form-control" />
                            <div class=""><label class="form-label" for="form4Example2">MeetingEnd</label></div>
                        </div>
                    </div>

                    <!-- Message input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" class="form-control" id="form4Example3" placeholder=""></input>
                        <label class="form-label" for="form4Example3">Link</label>
                    </div>

                    <!-- Message input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <select name="platform" id="platform" class="form-control form-select">
                            <option disable checked>Select Platform</option>
                        </select>
                        <label class="form-label" for="form4Example3">Platform</label>
                    </div>

                    <!-- Message input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <textarea class="form-control form-text" id="form4Example3" rows="4"></textarea>
                        <label class="form-label" for="form4Example3">Message</label>
                    </div>

                    <!-- Checkbox -->
                    <div class="form-check d-flex justify-content-center mb-4">
                        <input class="form-check-input me-2" type="checkbox" value="" id="form4Example4" checked />
                        <label class="form-check-label" for="form4Example4">
                            Send me a copy of this message
                        </label>
                    </div>

                    <!-- Submit button -->
                    <button data-mdb-ripple-init type="button"
                        class="btn btn-primary btn-block mb-4 w-100">Send</button>
                </form>
            </div>

        </div>
    </div>
</body>
<script src="https://cdn.lordicon.com/lordicon.js"></script>

<script src="<?= ROOT ?>node_modules/jquery/dist/jquery.min.js"></script>
<script src="<?php echo ROOT ?>node_modules/sweetalert2/dist/sweetalert2.js"></script>
<script type="text/javascript">
    var ROOT = "<?= ROOT ?>";
</script>
<script defer type="module" src="<?= ROOT ?>scripts/Admin/dashboard.js"></script>
<script defer type="module" src="<?= ROOT ?>scripts/Admin/events.js"></script>
</body>

</html>