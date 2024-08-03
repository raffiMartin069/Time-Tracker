// This will create a new job title after a successful request
$("#saveAddJobPositionBtn").click(function () {
  var addJobPosition = $("#addJobPosition").val().trim();

  // This will check if all input fields contains a value and display the appropriate message if there's none
  if (addJobPosition.length === 0) {
    var showAddJobPositionErrorMsg = "";
    showAddJobPositionErrorMsg = "Please do not leave the input field empty!";
    Swal.fire({
      title: "Oops",
      text: showAddJobPositionErrorMsg,
      icon: "warning",
    });

    return;
  }

  $.ajax({
    url: "Admin/addJobPosition",
    method: "POST",
    data: {
      title_name: addJobPosition,
    },
    dataType: "json",
    success: function (response) {
      Swal.fire({
        title: "Success",
        text: "Job position has been added successfully!",
        icon: "success",
      });
      $(".swal2-confirm").click(function () {
        location.reload();
      });
    },
    error: function (error) {
      Swal.fire({
        title: "Error",
        text: "Unable to save changes. Please try again later.",
        icon: "error",
      });
      $(".swal2-confirm").click(function () {
        location.reload();
      });
    },
  });
});

const updateBtn = document.querySelectorAll(".UpdateJobPositionBtn");
updateBtn.forEach((button) => {
  button.addEventListener("click", function () {
    // Fetches all the current data of the job title being updated and assigned them
    const titleId = this.getAttribute("data-position-id");
    const titleName = this.getAttribute("data-position-title");

    // Prefills the modal with the fetched data
    document.getElementById("modal-update-job-position").value = titleName;

    // Updates job position data with the new value from the modal
    document
      .getElementById("saveUpdatedJobPositionBtn")
      .addEventListener("click", function () {
        const modalTitleName = document.getElementById(
          "modal-update-job-position"
        ).value;

        // Handles the request and sends the updated values to the server
        $.ajax({
          url: "Admin/updateJobPosition",
          method: "POST",
          data: {
            title_id: titleId,
            title_name: modalTitleName,
          },
          dataType: "json",
          success: function (response) {
            Swal.fire({
              title: "Success",
              text: "Job position has been updated successfully!",
              icon: "success",
            });
            $(".swal2-confirm").click(function () {
              location.reload();
            });
          },
          error: function (error) {
            Swal.fire({
              title: "Error",
              text: "Unable to save changes. Please try again later.",
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

// Performs the deletion of a job title
const deleteBtns = document.querySelectorAll(".deleteJobPositionBtn");
deleteBtns.forEach((button) => {
  button.addEventListener("click", function () {
    // Gets the ID of the job title being clicked
    const titleId = this.getAttribute("data-position-id");

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
          url: "Admin/deleteJobPosition",
          method: "POST",
          data: {
            title_id: titleId,
          },
          dataType: "json",
          success: function (response) {
            Swal.fire({
              title: "Deleted",
              text: "Job position has been deleted successfully!",
              icon: "success",
            });
            $(".swal2-confirm").click(function () {
              location.reload();
            });
          },
          error: function (error) {
            Swal.fire({
              title: "Error",
              html: "Unable to save changes. Please try again later.",
              icon: "error",
            });

            $(".swal2-confirm").click(function () {
              location.reload();
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
