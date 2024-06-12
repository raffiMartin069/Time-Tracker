import * as Err from "../error.js";

document.addEventListener("DOMContentLoaded", function () {
  var contactInput = document.getElementById("contact");

  contactInput.addEventListener("input", function () {
    // Replace any non-digit character with an empty string
    this.value = this.value.replace(/\D/g, "");
  });
});

const employmentMapping = {
  2: { emp_stat_name: "Part-time", req_hrs: 20 },
  3: { emp_stat_name: "Part-time", req_hrs: 30 },
  1: { emp_stat_name: "Full-time", req_hrs: 40 },
};

const positionMapping = {
  1: "Learning and Development Specialist",
  2: "Chief Financial Officer",
  3: "Head of Sales",
  4: "Relations Director",
  5: "Director of Training",
  6: "Chief Operations Officer",
  7: "Co Founder",
  8: "Virtual Assistant",
  9: "Chief Executive Officer",
};

const shiftMapping = {
  36: "Wednesday-Sunday",
  37: "Thursday-Monday",
  38: "Friday-Tuesday",
  39: "Saturday-Wednesday",
  35: "Tuesday-Saturday",
  33: "Sunday-Thursday",
  34: "Monday-Friday",
};

const emptyFields = () => {
  // return a swal warning
  Swal.fire({
    icon: "warning",
    title: "Oops...",
    text: "Please fill out all fields!",
  });
};

const phoneLength = () => {
  Swal.fire({
    icon: "warning",
    title: "Oops...",
    text: "Number should be exactly 11 digits!",
  });
};

const validateInput = (arr) => {
  for (let i = 0; i < arr.length; i++) {
    if (
      arr[i] === "" ||
      arr[i] === undefined ||
      arr[i] === null ||
      arr[i] === "undefined"
    ) {
      return false;
    }
  }

  return true; // Ensure the function returns true if all validations pass
};

const summary = () => {
  let fname = document.getElementById("fname").value;
  let mname = document.getElementById("mname").value;
  let lname = document.getElementById("lname").value;
  let email = document.getElementById("email").value;
  let dob = document.getElementById("dob").value;
  let hireDate = document.getElementById("hireDate").value;
  let contact = document.getElementById("contact").value;

  let empType = Array.from(document.getElementsByName("type")).find(
    (r) => r.checked
  )?.value;
  let role = Array.from(document.getElementsByName("role")).find(
    (r) => r.checked
  )?.value;
  let shift = Array.from(document.getElementsByName("shift")).find(
    (r) => r.checked
  )?.value;

  let empTypeText = empType
    ? `${employmentMapping[empType].emp_stat_name} (${employmentMapping[empType].req_hrs} Hours)`
    : null;
  let roleText = role ? positionMapping[role] : null;
  let shiftText = shift ? shiftMapping[shift] : null;

  // array for validation
  let array = [
    fname,
    lname,
    email,
    dob,
    hireDate,
    contact,
    empType,
    role,
    shift,
  ];

  if (!validateInput(array)) {
    emptyFields();
    return;
  }

  if (contact.length < 11) {
    phoneLength();
    return;
  }

  let fullname = `${fname} ${mname} ${lname}`;
  return `
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <h4 class="mb-3 fw-bold">Employee Details</h4>
    
        <p><strong>Full Name:</strong> ${fullname}</p>
        <p><strong>Date of birth:</strong> ${dob}</p>
        <p><strong>Position/Title:</strong> ${roleText}</p>
        <p><strong>Hired Date:</strong> ${hireDate}</p>
        <p><strong>Email:</strong> ${email}</p>
        <p><strong>Employment Type:</strong> ${empTypeText}</p>
        <p><strong>Contact Number:</strong> ${contact}</p>
        <p><strong>Shift:</strong> ${shiftText}</p>
    </div>
    <div class="modal-footer justify-content-center">
        <button type="button" class="btn fs-5 fw-medium" style="color: #595959" data-bs-dismiss="modal">Cancel</button>
        <input type="submit" id="sendForm" class="btn text-white rounded-5 fs-5 fw-medium" style="background: hsl(202, 71%, 42%)" value="OK">
    </div>
    </div>
</div>
`;
};

const openSummary = () => {
  document.addEventListener("DOMContentLoaded", function () {
    // This ensures the DOM is fully loaded before trying to attach the event listener
    const showSummaryBtn = document.getElementById("submit");
    if (showSummaryBtn) {
      showSummaryBtn.addEventListener("click", function (e) {
        // Call summary() to get the modal HTML
        const modalHtml = summary();

        // Check if modalHtml is not null or undefined
        if (modalHtml) {
          // Insert the modal HTML into the div with ID 'empSummary'
          const modalDiv = document.getElementById("empSummary");
          modalDiv.innerHTML = modalHtml;

          // Use Bootstrap's modal method to show the modal
          const modalElement = new bootstrap.Modal(modalDiv);
          modalElement.show();
        }
      });
    }
  });
};

document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("employeeForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();
      httpRequest(this);
    });
});

const errors = (err) => {
  let mess = "";

  if (err.error.includes(Err.DUPLICATE_EMAIL)) {
    Swal.fire({
      title: "Duplicate Email",
      text: Err.DUPLICATE_EMAIL_MESS,
      icon: "error",
    });
    return false;
  }

  if (err.error.includes(Err.DUPLICATE_PHONE)) {
    Swal.fire({
      title: "Duplicate Phone Number",
      text: Err.DUPLICATE_PHONE_MESS,
      icon: "error",
    });
    return false;
  }
  return true;
};

const getName = () => {
  return (
    document.getElementById("fname").value +
    "_" +
    document.getElementById("lname").value
  );
};

const decodePdf = (data, empData) => {
  // Decode the base64 PDF string
  const base64Pdf = data.pdf;
  const binaryString = window.atob(base64Pdf);
  const len = binaryString.length;
  const bytes = new Uint8Array(len);
  for (let i = 0; i < len; i++) {
    bytes[i] = binaryString.charCodeAt(i);
  }

  // Create a Blob from the bytes array
  const pdfBlob = new Blob([bytes], { type: "application/pdf" });

  // Create a download link
  const downloadLink = document.createElement("a");
  downloadLink.href = URL.createObjectURL(pdfBlob);
  downloadLink.download =
    getName() + "_credentials.pdf_" + empData.login_id + ".pdf";

  // Trigger the download
  return downloadLink.click();
};

const httpRequest = (formData) => {
  let url = "Admin/AddEmployee";
  let form = new FormData(formData);

  let jsonObject = {};
  for (let [key, value] of form.entries()) {
    jsonObject[key] = value;
  }

  fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(jsonObject),
  })
    .then((response) => {
      if (!response.ok) {
        return response.json().then((errorData) => {
          throw new Error(errorData.error || "An unknown error occurred");
        });
      }
      return response.json();
    })
    .then((data) => {
      console.log(data);
      const empData = data.data[0];
      decodePdf(data, empData);

      Swal.fire({
        title: "Employee Added!",
        html:
          "Thank you for confirming the details. Employee account has been added successfully." +
          "<br/><br/><strong>Employee Details</strong>" +
          "<br/><br/><strong>User ID:</strong> " +
          empData.login_id +
          "<br/><strong>Password:</strong> " +
          empData.password,
        icon: "success",
      }).then(() => {
        window.location.reload();
      });
    })
    .catch((error) => {
      Swal.fire({
        title: "Oops.",
        text: error.toString().replace("Error: ", ""),
        icon: "error",
      });
    });
};
openSummary();
