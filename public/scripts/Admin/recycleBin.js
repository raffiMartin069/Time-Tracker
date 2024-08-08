// Recovers account after a successful request
$(".recoverAccountBtn").click(function () {
  // Fetches the employee id assigned to the employee being clicked
  const recycleId = this.getAttribute("data-recycle-id");

  // Sends request to the server and display appropriate message based on result
  $.ajax({
    url: "Admin/recoverAccount",
    method: "POST",
    data: {
      recycle_id: recycleId,
    },
    dataType: "json",
    success: function (response) {
      Swal.fire({
        title: "Success",
        text: "Employee account has been recovered successfully!",
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

const deleteAccBtn = document.querySelectorAll(".deleteAccountBtn");
deleteAccBtn.forEach((button) => {
  button.addEventListener("click", function () {
    // Fetches the employee id assigned to the employee being clicked
    const deleteRecycleId = this.getAttribute("data-delete-recycle-id");

    // Prompt confirmation dialog
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
          url: "Admin/permanentDeleteAccount",
          method: "POST",
          data: {
            delete_recycle_id: deleteRecycleId,
          },
          dataType: "json",
          success: function (response) {
            if (response.success) {
              Swal.fire({
                title: "Deleted",
                text: "Employee account has been permanently deleted!",
                icon: "success",
              });

              $(".swal2-confirm").click(function () {
                location.reload();
              });
            } else {
              Swal.fire({
                title: "Error",
                text:
                  response.message ||
                  "Unable to save changes. Please try again later.",
                icon: "error",
              });
            }
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
