import httpRequest from './request.js';

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

const members = [];

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
            console.log(members); // Moved inside the event listener callback
        });
    });
};

const memberData = (members = []) => {
    members.forEach(member => {
        console.log(member);
    });
};

const extractData = () => {
    let form = document.getElementById('meeting_form');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let formData = new FormData(form);

        // Serialize members array as JSON string
        formData.append('participants', JSON.stringify(members));

        httpRequest(formData);
    });
};

document.addEventListener('DOMContentLoaded', (event) => {
    searchInput();
    printSelected();
    memberData();    
    extractData();
});
