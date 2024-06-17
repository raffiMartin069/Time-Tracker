import { formCheck } from '../security.js';

const confirmAction = () => {
  let confirmDelete = confirm("Are you sure you want to delete this employee?");
  if (confirmDelete) {
    return true;
  }
  return false;
};

const verifyData = (data) => {
  if(data === 'del') {
    throw new Error('Please enter an employee ID.');
  }
  return true;
}

const checkData = (formData) => {

  try {
    let result = formCheck(formData);
    
    if(!result[0]) {
      verifyData(result[1]);
    }

    return true;
  
  } catch (error) {
    Swal.fire({
      title: "Oops...",
      text: error.message,
      icon: "warning",
    });
    return false;
  }
}

const getForm = () => {
  document
    .getElementById("deleteEmployeeForm")
    .addEventListener("submit", (e) => {
      e.preventDefault();
      let formData = new FormData(e.target);
      let check_content = checkData(formData);
      if(!check_content) {
        return;
      }

      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {    
          request(formData);
        }
      });
    });
};

const request = async (formData) => {
  let jsonData = {};

  formData.forEach((value, key) => {
    jsonData[key] = value;
  });

  let url = "Admin/softDeleteEmployee";

  let settings = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(jsonData),
  };

  try {
    const response = await fetch(url, settings);
    if (!response.ok) {
      throw new Error("Something went wrong." || response.statusText);
    }
    const jsonResponse = await response.json();

    if (!jsonResponse.status) {
        console.log(jsonResponse.serverResponse['status']);
      Swal.fire({
        title: "Oops...",
        text: "Unable to delete, please try again later.",
        icon: "error",
      });
    } else {
      Swal.fire({
        title: "Account deleted",
        text: "Deletion success!",
        icon: "success",
      }).then(() => {
        window.location.reload();
      });
    }
  } catch (e) {
    Swal.fire({
      title: "Oops...",
      text: "Unable to delete, please try again later.",
      icon: "error",
    });
  }
};

document.addEventListener("DOMContentLoaded", function () {
  getForm();
});
