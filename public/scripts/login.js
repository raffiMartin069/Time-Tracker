$(document).ready(function() {

  // basic hide and view of password.
  // it is important to note that this is not tide to a password field which would reveal a text.
  $("#view").hide();
  $("#view-pass").on("click", function() {
      $(this).hide();
      $("#view").show();
  });

  $("#view").on("click", function() {
      $(this).hide();
      $("#view-pass").show();
  });
  
  // RegEx does not allow any characters other than numbers to be inputted.
  // Though type number can be added to the input field, it is not recommended as it can cause issues with the input field.
  // This function is used to suppress any characters that are not numbers.
  const restrictToNumbers = () => {
    $('#idNumber').on('input', function() {
      this.value = this.value.replace(/[^0-9]/g, '');
    });
  }


  // Modify alert when user inputs the data.
  const buttonClick = () => {
    $('#submitBtn').on('click', (e) => {
      e.preventDefault();
      Swal.fire({
        title: "Signed In",
        text: "Welcome!",
        icon: "success"
      });
    });
  }

  // Call the function to apply the restriction
  restrictToNumbers();
  buttonClick();
  
})