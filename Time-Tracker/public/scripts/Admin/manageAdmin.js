// Opens the add admin modal and populate it with all the list of non-admin employees
$("#addAdminBtn").click(function() {
    $.ajax({
        url: "Admin/manageNoneAdminAccess",
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var addAdminModal = $(".checkbox-group");
            addAdminModal.empty();
            if (data.length > 0) {
                data.forEach(function(report) {
                    var option = `
                        <label>
                            <input type="checkbox" class="select-member" value="${report.ID}">
                            ${report.EMPLOYEE}
                        </label>`;
                    addAdminModal.append(option);
                });
            } else {
                addAdminModal.append('<p>There is currently no non-admin employees.</p>');
            }
        }, 
         error: function (xhr) {
            let errorMessage =
              "Failed to load non-admin employees. Please reload or try again later.";

            if (xhr.responseJSON && xhr.responseJSON.error) {
              errorMessage = xhr.responseJSON.error;
            }

            errorMessage = errorMessage.replace(/Error[.:] /, "");
 
              Swal.fire({
                title: "Oops.",
                text: errorMessage,
                icon: "error",
              }); 

            $(".swal2-confirm").click(function () {
                $('#addAdminModal').modal('hide');
            });
          }, 
    });
    $('#addAdminModal').modal('show');
});

// Performs the action of adding an admin
$('#saveAdminBtn').click(function() {
    var empIds = [];
    $('.select-member:checked').each(function() {
        empIds.push($(this).val());
    });

    // Checks if input field is empty or not
    if (empIds.length === 0) {
        Swal.fire({
            title: "Opss",
            text: "Please select at least one employee to add as admin!",
            icon: "warning"
        });
         
        return;
    } 

    $.ajax({
        url: 'Admin/manageNoneAdminAccess',
        method: 'POST',
        data: {
            empId: empIds
        },
        dataType: 'json',
        success: function(response) {
            Swal.fire({
                title: "Success",
                text: "Admin(s) has been added successfully!",
                icon: "success"
            });
            $('.swal2-confirm').click(function() {
                location.reload();
            })
        }, 
          error: function (xhr) {
            let errorMessage =
              "Unable to save changes. Please try again later.";

            if (xhr.responseJSON && xhr.responseJSON.error) {
              errorMessage = xhr.responseJSON.error;
            }

            errorMessage = errorMessage.replace(/Error[.:] /, "");
 
              Swal.fire({
                title: "Oops.",
                text: errorMessage,
                icon: "error",
              }); 

            $(".swal2-confirm").click(function () {
              location.reload();
            });
          },
    });
});

// Opens the delete admin modal and populate it with all the list of admin employees
$("#deleteBtn").click(function() {
    $.ajax({
        url: "Admin/manageAdminAccess",
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var delAdmin = $("#delCheckBox");
            delAdmin.empty();
            if (data.length > 0) {
                data.forEach(function(report) {
                    var row = `
                        <label>
                            <input type="checkbox" class="select-member" value="${report.id}">
                            ${report.employee}
                        </label>`;
                    delAdmin.append(row);
                });
            } else {
                delAdmin.append('<p>There is currently no admin employees.</p>');
            }
        }, 
        error: function (xhr) {
            let errorMessage =
              "Failed to load admin employees. Please reload or try again later.";

            if (xhr.responseJSON && xhr.responseJSON.error) {
              errorMessage = xhr.responseJSON.error;
            }

            errorMessage = errorMessage.replace(/Error[.:] /, "");
 
              Swal.fire({
                title: "Oops.",
                text: errorMessage,
                icon: "error",
              }); 

            $(".swal2-confirm").click(function () {
                $('#deleteAdminModal').modal('hide');
            });
        },
    });

    $('#deleteAdminModal').modal('show');
});

// Performs the action of deleting an admin
$('#confirmDeleteBtn').click(function() {
    var empIds = [];
    $('.select-member:checked').each(function() {
        empIds.push($(this).val());
    });

    // Checks if input field is empty or not
    if (empIds.length === 0) {
        Swal.fire({
            title: "Oops",
            text: "Please select at least one admin to delete!",
            icon: "warning"
        }); 

        return;
    }

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'Admin/manageAdminAccess',
                method: 'POST',
                data: {
                    empId: empIds
                },
                dataType: 'json',
                success: function(response) {
                    // Checks if the employee to be remove is/includes the currently logged in employee, if so, it will then go to the login page
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        Swal.fire(
                            "Success",
                            "Admin(s) has been deleted successfully!",
                            "success"
                        );
                        $('.swal2-confirm').click(function() { 
                            location.reload();
                        });
                    }
                }, 
                error: function (xhr) {
                    let errorMessage =
                      "Unable to save changes. Please try again later.";
        
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                      errorMessage = xhr.responseJSON.error;
                    }
        
                    errorMessage = errorMessage.replace(/Error[.:] /, "");
         
                      Swal.fire({
                        title: "Oops.",
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
                icon: "success"
            });
        }
    });
}); 
 
// Adds CSS active selector to enable CSS color for the current active tab
var currentPage = new URLSearchParams(window.location.search).get('page');
if (currentPage) {
    $('.tabs a').removeClass('active');
    $('.tabs a[href="?page=' + currentPage + '"]').addClass('active');
}