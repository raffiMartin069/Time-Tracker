(() => {
  $(document).ready(function () {
    let isEditAllowed = true;

    $("#editGeneralBtn").click(function () {
      if (isEditAllowed) {
        $("#generalInfoForm input").prop("disabled", false);
        $("#saveGeneralBtn").prop("disabled", false);
      } else {
        $("#errorModal").modal("show");
        $("#closeError").click(function () {
          $("#errorModal").modal("hide");
        });
      }
    });

    $("#generalInfoForm").submit(function (event) {
      event.preventDefault();
      $("#generalInfoForm input").prop("disabled", true);
      isEditAllowed = false;
      var fName = $("#getmyfname").val();
      var mName = $("#getmymname").val();
      var lName = $("#getmylname").val();
      var birthDate = $("#getmybirthday").val();

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
          $(".empFname").text(data.f_name);
          $(".empMname").text(data.m_name);
          $(".empLname").text(data.l_name);
          $("#changeModal").modal("show");
          $("#closeChangeModal").click(function () {
            window.location.reload();
          });
        },
        error: function (xhr, status, error) {
          $("#errorModal").modal("show");
          $("#closeError").click(function () {
            $("#errorModal").modal("hide");
          });
        },
      });
    });

    $("#editPasswordBtn").click(function () {
      $("#passwordInfoForm input").prop("disabled", false);
      $("#savePasswordBtn").prop("disabled", false);
    });

    // Password Form
    $("#passwordInfoForm").submit(function (event) {
      event.preventDefault();
      $("#passwordInfoForm input").prop("disabled", true);
      var currPassword = $("#getmycurrpassword").val();
      var newPassword = $("#getmynewpassword").val();

      console.log(
        "Fetching passwords, currpass: " +
          currPassword +
          ", newpass: " +
          newPassword
      );

      $.ajax({
        url: "Employee/UpdateSettingsPasswordInfo",
        method: "POST",
        data: {
          curr_password: currPassword,
          new_password: newPassword,
        },
        success: function (data) {
          $("#changeModal").modal("show");
          $("#closeChangeModal").click(function () {
            $("#changeModal").modal("hide");
            $("#getmycurrpassword").val("");
            $("#getmynewpassword").val("");
            window.location.reload();
          });
        },
        error: function (xhr, status, error) {
          var message = "An error occurred"; // Default error message
          try {
            // Attempt to parse the JSON response from the server
            var responseJson = JSON.parse(xhr.responseText);
            if (responseJson && responseJson.error) {
              // If the server response contains an error message, use it
              message = responseJson.error;
            }
          } catch (e) {
            // Log an error if parsing fails
            console.error("Error parsing server response:", e);
          }

          // Display the error message in the modal
          $(".modal-body").text(message); // Use .text() for security reasons
          $("#errorModal").modal("show");

          // Close the modal when the close button is clicked
          $("#closeError").click(function () {
            $("#errorModal").modal("hide");
          });
          // console.error('AJAX error:', status, error, xhr.responseText);
        },
      });
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

      console.log("Fetching contacts, email: " + email + ", ecn: " + ecn);

      $.ajax({
        url: "Employee/UpdateSettingsContactInfo",
        method: "POST",
        data: {
          email: email,
          ecn: ecn,
        },
        success: function (data) {
          $(".empEmail").text(data.email);
          $(".empContact").text(data.ecn);
          $("#changeModal").modal("show");
          $("#closeChangeModal").click(function () {
            $("#changeModal").modal("hide");
            window.location.reload();
          });
        },
        error: function (xhr, status, error) {
          console.error("AJAX error:", status, error, xhr.responseText);
        },
      });
    });

    $("#profilePic").on("click", function () {
      $("#profilePhoto").click();
    });

    $("#profilePhoto").on("change", function () {
      let file = this.files[0];
      if (file) {
        let reader = new FileReader();
        reader.onload = function (e) {
          $("#profilePic").attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
        // Automatically submit the form
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
          $("#changeModal").modal("show");
          $("#closeChangeModal").click(function () {
            $("#changeModal").modal("hide");
            window.location.reload();
          });
        },
        error: function () {
          alert("Error uploading profile picture");
        },
      });
    });
  });
})();
