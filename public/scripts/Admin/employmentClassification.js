// This will create a new employment classification after a successful request
$("#saveAddEmploymentBtn").click(function () {
  // Gets all the input field values
  var addEmploymentType = $("#addEmploymentType").val().trim();
  var addRequiredHours = $("#addRequiredHours").val().trim();

  // This will check if all input fields contains a value and display the appropriate message if there's none
  if (addEmploymentType.length === 0 || addRequiredHours.length === 0) {
    var showClassificationErrorMsg =
      "Please do not leave an input field empty!";

    Swal.fire({
      title: "Oops",
      text: showClassificationErrorMsg,
      icon: "warning",
    });

    return;
  }

  $.ajax({
    url: "Admin/addEmploymentType",
    method: "POST",
    data: {
      employment_type: addEmploymentType,
      required_hours: addRequiredHours,
    },
    dataType: "json",
    success: function (response) {
      Swal.fire({
        title: "Success",
        text: "Employment status has been added successfully!",
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
    },
  });
});

const updateBtn = document.querySelectorAll(".UpdateEmploymentBtn");
updateBtn.forEach((button) => {
  button.addEventListener("click", function () {
    // Fetches all the current data of the employment classification being updated and assigned them
    const employmentId = this.getAttribute("data-employment-id");
    const employmentType = this.getAttribute("data-employment-type");
    const employmentHrs = this.getAttribute("data-employment-hrs");

    // Prefills the update modal with all the fetched data
    document.getElementById("modal-update-employment-type").value =
      employmentType;
    document.getElementById("modal-update-employment-hrs").value =
      employmentHrs;

    document
      .getElementById("saveUpdatedEmploymentBtn")
      .addEventListener("click", function () {
        // After submitting the modal, the new input values will be fetched and assigned
        const modalEmploymentType = document.getElementById(
          "modal-update-employment-type"
        ).value;
        const modalEmploymentHrs = document.getElementById(
          "modal-update-employment-hrs"
        ).value;

        // Handles the request and sends the updated values to the server
        $.ajax({
          url: "Admin/updateEmploymentType",
          method: "POST",
          data: {
            employment_id: employmentId,
            employment_type: modalEmploymentType,
            employment_hrs: modalEmploymentHrs,
          },
          dataType: "json",
          success: function (response) {
            Swal.fire({
              title: "Success",
              text: "Employment status has been updated successfully!",
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
  });
});

// Performs the deletion of an employment classification
const deleteBtns = document.querySelectorAll(".deleteEmploymentBtn");
deleteBtns.forEach((button) => {
  button.addEventListener("click", function () {
    // Gets the ID of the classification being clicked
    const employmentId = this.getAttribute("data-employment-id");

    // After the ID is fetched, the following message will prompt:
    // if the confirm button is clicked, it will then determine whether the deletion is a success or not
    // else, if the cancel button is clicked, the deletion process in progress will not push through
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "Admin/deleteEmploymentType",
          method: "POST",
          data: {
            employment_id: employmentId,
          },
          dataType: "json",
          success: function (response) {
            Swal.fire({
              title: "Deleted",
              text: "Employment status has been deleted successfully!",
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
          },
        });
      } else {
        Swal.fire({
          title: "Cancelled",
          text: "The deletion has been cancelled!",
          icon: "success",
        });
      }
    });
  });
});
