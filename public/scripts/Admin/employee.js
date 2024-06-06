/**
 * Validates an array of employee fields.
 * @param {Array} array - The array of employee fields to validate.
 * @returns {boolean} - Returns true if all fields are valid, false otherwise.
 */
function validateEmployeeFields(array) {
    for (let i = 0; i < array.length; i++) {
        if (array[i] === undefined || array[i] === "") {
            return false;
        }
    }
    return true;
}

/**
 * Retrieves the employee details from the form.
 * @returns {Array} - Returns an array containing the employee details.
 */
function getEmployees() {
    let fname = document.getElementById('fname').value;
    let mname = document.getElementById('mname').value;
    let lname = document.getElementById('lname').value;
    let email = document.getElementById('email').value;
    let dob = document.getElementById('dob').value;
    let hireDate = document.getElementById('hireDate').value;

    let empType = Array.from(document.getElementsByName('shift')).find(r => r.checked)?.value;
    let workingHrs = Array.from(document.getElementsByName('numberOfHrs')).find(r => r.checked)?.value;
    let role = Array.from(document.getElementsByName('role')).find(r => r.checked)?.value;
    let data = [fname, mname, lname, email, dob, hireDate, empType, workingHrs, role];

    let validateField = validateEmployeeFields(data);

    if (!validateField) {
        Swal.fire({
            title: "Forgot something?",
            text: "Some fields might be empty. Please fill them up.",
            icon: "warning"
        });
        return [false];
    }
    return [true, data];
}

/**
 * Generates the HTML markup for the employee details summary modal.
 * @param {string} fullname - The full name of the employee.
 * @param {string} dob - The date of birth of the employee.
 * @param {string} hireDate - The hire date of the employee.
 * @param {string} email - The email address of the employee.
 * @param {string} empType - The employment type of the employee.
 * @param {string} workingHrs - The working hours of the employee.
 * @param {string} role - The role of the employee.
 * @returns {string} - Returns the HTML markup for the summary modal.
 */
const summaryDetails = (fullname, dob, hireDate, email, empType, workingHrs, role) => {
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
            <p><strong>Position/Title:</strong> ${hireDate}</p>
            <p><strong>Hired Date:</strong> ${email}</p>
            <p><strong>Email:</strong> ${empType}</p>
            <p><strong>Employment Type:</strong> ${workingHrs}</p>
            <p><strong>Working Hours:</strong> ${role}</p>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn fs-5 fw-medium" style="color: #595959" data-bs-dismiss="modal">Cancel</button>
            <input type="submit" id="sendForm" class="btn text-white rounded-5 fs-5 fw-medium" style="background: hsl(202, 71%, 42%)" value="OK">
        </div>
        </div>
    </div>
    `;
}

/**
 * Creates and displays the employee details summary modal.
 * @param {Array} array - The array containing the employee details.
 */
const createModal = (array) => {
    let fullname = array[0] + " " + array[1] + " " + array[2];
    let dob = array[3];
    let hireDate = array[4];
    let email = array[5];
    let empType = array[6];
    let workingHrs = array[7];
    let role = array[8];

    let renderModal = summaryDetails(fullname, dob, hireDate, email, empType, workingHrs, role);

    // render modal to the document
    document.getElementById('empSummary').innerHTML = renderModal;

    var myModal = new bootstrap.Modal(document.getElementById('empSummary'), {});
    myModal.show();
    prepareForm(array);
}

/**
 * Prepares the form for submission.
 * @param {Array} array - The array containing the employee details.
 */
const prepareForm = (array) => {
    let sendForm = document.getElementById('employeeForm');
    sendForm.addEventListener('submit', function (e) {
        e.preventDefault();
        console.log("I am sending a data: " + array);
        httpRequest(sendForm);
    });
}

/**
 * Opens the employee details summary modal.
 */
const openSummaryModal = () => {
    document.addEventListener('DOMContentLoaded', function () {
        let openSummary = document.getElementById('submit');
        openSummary.addEventListener('click', function () {

            if (!getEmployees()[0]) {
                return;
            }

            let data = getEmployees()[1];
            createModal(data);
        });
    });
}

/**
 * Sends an HTTP request to add the employee.
 * @param {FormData} formData - The form data to be sent.
 */
const httpRequest = async (formData) => {
    let form = new FormData(formData);

    let jsonObject = {};
    for (let [key, value] of form.entries()) {
        jsonObject[key] = value;
    }

    try {
        const response = await fetch("Admin/AddEmployee", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(jsonObject)
        });

        if (!response.ok) {
            throw new Error(`Something went wrong: ${response.status}`);
        }

        let responseBody = await response.json();

        if (!responseBody.status) {
            Swal.fire({
                title: "Error",
                text: responseBody.message,
                icon: "error"
            });
            return;
        }

        Swal.fire({
            title: " Employee Added!",
            html: "Thank you for confirming the details. Employee account has been added successfully." +
                "<br/><br/><strong>Employee Details</strong>" +
                "<br/><br/><strong>User ID:</strong> " +
                "<br/><strong>Password:</strong> " +
                "<br/><br/><a class=' fs-6' href=''>Download Credentials</a>",
            icon: "success"
        }).then(() => {
            window.location.reload();
        });
    } catch (error) {
        console.error("Something went wrong " + error);
    }
}

openSummaryModal();