import httpRequest from './request.js';
import { formCheck, nullCheck  } from '../security.js';


/**
 * @function searchInput - filters the checkboxes based on the search input
 * @returns {void}
 * @description This function listens for changes in the search input and filters the checkboxes based on the search input.
 * The search input is compared with the label of the checkboxes.
 * If the label includes the search input, the checkbox is displayed.
 * If the label does not include the search input, the checkbox is hidden.  
 */
const searchInput = () => {
    const searchInput = document.getElementById('search');
    const employeeCheckboxes = document.querySelectorAll('.employee-checkbox');

    searchInput.addEventListener('keyup', function() {
        const inputValue = searchInput.value.trim().toLowerCase();
        const minLength = 2; // Minimum characters required for initial search

        // Show all checkboxes if search input is empty
        if (inputValue === '') {
            employeeCheckboxes.forEach(checkbox => {
                checkbox.style.display = '';
            });
            return;
        }

        // Show initial results if input length is less than minLength
        if (inputValue.length < minLength) {
            employeeCheckboxes.forEach(checkbox => {
                checkbox.style.display = 'none';
            });
            return;
        }

        // Filter checkboxes based on search input
        employeeCheckboxes.forEach(checkbox => {
            const label = checkbox.querySelector('label').textContent.trim().toLowerCase();
            if (label.includes(inputValue)) {
                checkbox.style.display = '';
            } else {
                checkbox.style.display = 'none';
            }
        });
    });
}

/**
 * @var members - array to store selected members for the meeting
 * @type {Array}
 * @description This array is used to store the selected members for the meeting.
 * This array is then serialized as a JSON string and appended to the form data.
 * 
 */
const members = [];

/**
 * @function printSelected - prints selected members to the table
 * @returns {void}
 * @description This function listens for changes in the checkboxes and prints the selected members to the table.
 * It also adds the selected members to the members array.
 * The members array is used to store the selected members for the meeting.
 * This array is then serialized as a JSON string and appended to the form data.
 * @see extractData
 * @see prepareChecks
 * @see httpRequest
 */
const printSelected = () => {
    const checkboxes = document.querySelectorAll('.form-check-input');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const participantTableBody = document.getElementById('participantTableBody');
            const label = this.nextElementSibling.textContent.trim();

            if (this.checked) {
                const newRow = document.createElement('tr');
                newRow.classList.add('participant-row');
                newRow.innerHTML = `<td>${label}</td>`;
                participantTableBody.appendChild(newRow);
                members.push(this.value);
            } else {
                const rows = participantTableBody.getElementsByClassName('participant-row');
                for (let row of rows) {
                    if (row.textContent.trim() === label) {
                        participantTableBody.removeChild(row);
                        const index = members.indexOf(this.value);
                        if (index > -1) {
                            members.splice(index, 1); // Correctly remove the member from the array
                        }
                        break;
                    }
                }
            }
        });
    });
};

/**
 * @param {*} formData 
 * @returns boolean as an identifier. If true, all checks passed
 * If false, an error was thrown and checks failed.
 */
const prepareChecks = (formData) => {
    try {
        let result = formCheck(formData);

        
        if(!result[0]) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: `${map_fields[result[1]]} is required.`,
            });
            return false;
        }
        return true;
    } catch(e) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: "Please check all fields and try again.",
        });
        return false;
    }
}

const memberArrayCheck = ($members) => {
    try {
        let result = nullCheck($members);
        if(result) {
            return true;
        }
    } catch(e) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: "Meeting should have at least one participant.",
        });
        return false;
    }
}

/**
 * @description this object is used to map form fields to be used for error handling.
 */
const map_fields = {
    'meet_title': 'Meeting title',
    'meet_date': 'Meeting date',
    'meet_start': 'Meeting start date and time',
    'meet_end': 'Meeting end date and time',
    'meet_link': 'Meeting link',
    'mess_desc' : 'Meeting description',
    'platform' : 'Meeting platform'
}

const extractData = () => {
    let form = document.getElementById('meeting_form');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let formData = new FormData(form);

        // check the members data first
        let memberData = memberArrayCheck(members);
    
        // Serialize members array as JSON string
        formData.append('participants', JSON.stringify(members));

        // Prepare data for checking null values
        // If null values are found, an error will be thrown
        let result = prepareChecks(formData);
        if(!result) {
            return;
        }

        if(!memberData) {
            return;
        } else {
            httpRequest(formData);
        }
    });
};

document.addEventListener('DOMContentLoaded', (event) => {
    searchInput();
    printSelected();
    // memberData();    
    extractData();
});
