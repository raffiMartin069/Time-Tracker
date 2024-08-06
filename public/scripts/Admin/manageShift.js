// This will open the modal for adding a shift
$('#addShiftBtn').click(function() {
    $('#addShiftModal').modal('show');
});

$('#saveShiftBtn').click(function() { 
    var daysSelected = [];
    $('.form-check-input:checked').each(function() {
        daysSelected.push($(this).val());
    });

    if (daysSelected.length === 0) { 
        var showShiftErrorMsg = 'Please do not leave the input field empty!';
          
        Swal.fire({
            title: "Oops",
            text: showShiftErrorMsg,
            icon: "warning"
        });

        return;
    }

    $.ajax({
        url: "Admin/addShift",
        method: 'POST',
        data: { 
            days: daysSelected
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: "Success",
                    text: "Shift has been added successfully!",
                    icon: "success"
                });
                $('.swal2-confirm').click(function() {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: response.message,
                    icon: "error"
                });
            }
        },
        error: function(xhr) {
            // Use the response JSON from the server-side error
            var errorMessage = xhr.responseJSON && xhr.responseJSON.message
                ? xhr.responseJSON.message
                : "Unable to save changes. Please try again later.";

            Swal.fire({
                title: "Error",
                text: errorMessage,
                icon: "error"
            });
        }
    }); 
});


// This will perform a deletion of a shift
const deleteBtns = document.querySelectorAll(".deleteShiftBtn");
deleteBtns.forEach((button) => {
    button.addEventListener("click", function() {
        //Gets the ID of the shift clicked based on its delete button
        const shiftId = this.getAttribute("data-shift-id");

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
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "Admin/deleteShift",
                    method: 'POST',
                    data: {
                        shift_id: shiftId
                    },
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Shift has been deleted successfully!",
                            icon: "success"
                        });
                        $('.swal2-confirm').click(function() {
                            location.reload();
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: "Error",
                            html: "Unable to save changes. Please try again later.",
                            icon: "error"
                        });

                        $('.swal2-confirm').click(function() {
                            location.reload();
                        });
                    }
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
});
