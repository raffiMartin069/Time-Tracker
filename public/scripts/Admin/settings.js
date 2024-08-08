let isEditAllowed = true;

$("#editGeneralBtn").click(function () {
  if (isEditAllowed) {
    // Enable form inputs and submit button to allow editing
    $("#generalInfoForm input").prop("disabled", false);
    $("#saveGeneralBtn").prop("disabled", false);

    $("#generalInfoForm")
      .off("submit")
      .on("submit", function (event) {
        event.preventDefault();

        // Disable form inputs and submit button after changes has been made
        $("#generalInfoForm input").prop("disabled", true);
        $("#saveGeneralBtn").prop("disabled", true);

        // This is a flag to keep track of changes submission
        isEditAllowed = false;

        // Fetch updated values from form inputs
        var fName = $("#getmyfname").val();
        var mName = $("#getmymname").val();
        var lName = $("#getmylname").val();
        var birthDate = $("#getmybirthday").val();

        // Send request to server and process changes
        $.ajax({
          url: "Employee/UpdateSettingsGeneralInfo",
          method: "POST",
          data: {
            f_name: fName,
            m_name: mName,
            l_name: lName,
            birth_date: birthDate,
          },
          success: function (data) {
            Swal.fire({
              title: "Success",
              text: "Your changes have been successfully saved!",
              icon: "success",
            });

            $(".swal2-confirm").click(function () {
              location.reload();
            });
          },

          error: function (xhr, status, error) {
            var errorMessage =
              "Unable to save changes. Please try again later.";
            if (xhr.responseJSON && xhr.responseJSON.error) {
              errorMessage = xhr.responseJSON.error;
            }

            Swal.fire({
              title: "Error",
              text: errorMessage,
              icon: "error",
            });

            $(".swal2-confirm").click(function () {
              location.reload();
            });
          },
        });
      });
  }
});

// Updating password starts here
$("#editPasswordBtn").click(function () {
  $("#passwordInfoForm input").prop("disabled", false);
  $("#savePasswordBtn").prop("disabled", false);
});

// Password form
$("#passwordInfoForm").submit(function (event) {
  event.preventDefault();
  $("#passwordInfoForm input").prop("disabled", true);
  var currPassword = $("#getmycurrpassword").val();
  var newPassword = $("#getmynewpassword").val();

  $.ajax({
    url: "Employee/UpdateSettingsPasswordInfo",
    method: "POST",
    data: {
      curr_password: currPassword,
      new_password: newPassword,
    },
    success: function (data) {
      Swal.fire({
        title: "Success",
        text: "Your changes have been successfully saved!",
        icon: "success",
      });

      $(".swal2-confirm").click(function () {
        location.reload();
      });
    },
    error: function (xhr, status, error) {
      var errorMessage = "Unable to save changes. Please try again later.";
      if (xhr.responseJSON && xhr.responseJSON.error) {
        errorMessage = xhr.responseJSON.error;
      }

      Swal.fire({
        title: "Error",
        text: errorMessage,
        icon: "error",
      });

      $(".swal2-confirm").click(function () {
        location.reload();
      });
    },
  });
});

// Contact change starts here
$("#editContactBtn").click(function () {
  $("#contactInfoForm input").prop("disabled", false);
  $("#saveContactBtn").prop("disabled", false);
});

// Contact Form
$("#editContactBtn").click(function () {
  $("#contactInfoForm input").prop("disabled", false);
  $("#saveContactBtn").prop("disabled", false);
});

$("#contactInfoForm").submit(function (event) {
  event.preventDefault();
  $("#contactInfoForm input").prop("disabled", true);
  var email = $("#getmyemail").val();
  var ecn = $("#getmyecn").val();

  $.ajax({
    url: "Employee/UpdateSettingsContactInfo",
    method: "POST",
    data: {
      email: email,
      ecn: ecn,
    },
    success: function (data) {
      Swal.fire({
        title: "Success",
        text: "Your changes have been successfully saved!",
        icon: "success",
      });

      $(".swal2-confirm").click(function () {
        location.reload();
      });
    },
    error: function (xhr, status, error) {
      var errorMessage = "Unable to save changes. Please try again later.";
      if (xhr.responseJSON && xhr.responseJSON.error) {
        errorMessage = xhr.responseJSON.error;
      }

      Swal.fire({
        title: "Error",
        text: errorMessage,
        icon: "error",
      });

      $(".swal2-confirm").click(function () {
        location.reload();
      });
    },
  });
});

$("#profilePic").on("click", function () {
  $("#profilePhoto").click();
});

$("#profilePhoto").on("change", function () {
  let file = this.files[0];
  if (file) {
    // Allowed file types
    let allowedTypes = [
      "image/jpeg",
      "image/jpg",
      "image/png",
      "image/gif",
      "image/svg+xml",
    ];

    // Checks if the file type is in the list of allowed types
    if (!allowedTypes.includes(file.type)) {
      Swal.fire({
        title: "Warning",
        html: "Invalid file type! <br>Only JPG, PNG, GIF, and SVG files are allowed.",
        icon: "warning",
      });

      return;
    }

    // Checks if file size is not greater than 2MB for efficiency and security
    // File size can be change
    let maxSize = 2 * 1024 * 1024;
    if (file.size > maxSize) {
      Swal.fire({
        title: "Warning",
        html: "File too large! <br>The file size should not exceed 2MB.",
        icon: "warning",
      });

      return;
    }

    // Submits the form once file type and file size are checked and is valid
    let reader = new FileReader();
    reader.onload = function (e) {
      $("#profilePic").attr("src", e.target.result);
    };
    reader.readAsDataURL(file);

    // Automatically submit the form after validation
    $("#profilePicForm").submit();
  }
});

$(".profilePicChange").on("submit", function (e) {
  e.preventDefault();
  let profilePhoto = new FormData(this);

  $.ajax({
    url: "Employee/UpdateProfilePic",
    type: "POST",
    data: profilePhoto,
    processData: false,
    contentType: false,
    success: function (data) {
      $("#profilePic").attr("src", data.profilePhoto);

      Swal.fire({
        title: "Success",
        text: "Your changes have been successfully saved!",
        icon: "success",
      });

      $(".swal2-confirm").click(function () {
        location.reload();
      });
    },
    error: function (xhr, status, error) {
      var errorMessage = "Unable to save changes. Please try again later.";
      if (xhr.responseJSON && xhr.responseJSON.error) {
        errorMessage = xhr.responseJSON.error;
      }

      Swal.fire({
        title: "Error",
        text: errorMessage,
        icon: "error",
      });

      $(".swal2-confirm").click(function () {
        location.reload();
      });
    },
  });
});
