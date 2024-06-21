(() => {
    $(document).ready(function() {
        function preventInvalidInputs(event) {
            if (event.key === '.' || event.key === 'e' || event.key === '-' || event.key === '+') {
                event.preventDefault();
            }
        }

        $('#empIdRecover').on('keypress', preventInvalidInputs);
        $('#empIdDelete').on('keypress', preventInvalidInputs);


        $('#recoverForm').submit(function(event) {
            event.preventDefault();
            var empId = $('#empIdRecover').val();

            $.ajax({
                url: "Admin/RecoverAccount",
                method: 'POST',
                dataType: 'json',
                data: {
                    empId: empId
                },
                success: function(response) {
                    if (response.success) {
                        $('#recoverMessage').html('<p class="text-success">' + response.message + '</p>');
                    } else {
                        $('#recoverMessage').html('<p class="text-danger">' + response.message + '</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#recoverMessage').html('<p class="text-danger">Employee does not exists. Try again.</p>');
                }
            });
        });

        $('#permanentDeleteForm').submit(function(event) {
            event.preventDefault();
            var empId = $('#empIdDelete').val();

            $.ajax({
                url: "Admin/DeleteAccount",
                method: 'POST',
                dataType: 'json',
                data: {
                    empId: empId
                },
                success: function(response) {
                    if (response.success) {
                        $('#deleteMessage').html('<p class="text-success">' + response.message + '</p>');
                    } else {
                        $('#deleteMessage').html('<p class="text-danger">' + response.message + '</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#deleteMessage').html('<p class="text-danger">Employee does not exists. Try again.</p>');
                }
            });
        });

        $('.accordion-header').click(function() {
            $(this).next('.accordion-body').slideToggle();
        });
    });
})();