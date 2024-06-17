import { formCheck } from '../security.js';

(() => {
    const getElementsValue = () => {
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener to all radio buttons with the name 'type'
            document.querySelectorAll('input[name="type"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    // Get the value of the selected radio button (employment ID).
                    var employmentID = this.value;
                });
            });
        });
    }

    const mapFields = (data) => {

        if(data === 'search_emp') {
            throw new Error('Please enter an employee ID.');
        }

        if(data === 'type') {
            throw new Error('Please select an employee type.');
        }

        if(data === '' || data === "") {
            throw new Error('Please enter a value.');
        }
        
    }

    const checkRadio = (radio) => {
        
        let isValid = 0;

        for (var i = 0; i < radio.length; i++) {
            if (radio[i].checked) {
                isValid++;
            }
        }

        if(isValid < 1) {
            throw new Error('Please select an employee type.');
        }
    }

    const fieldValidation = (data) => {
        try {

            let checked_data = formCheck(data);
            if(!checked_data[0]){
                mapFields(checked_data[1]);
            }
            let empType = document.getElementsByName('type');
            let empTypeValid = checkRadio(empType);
            return true;
        } catch(e) {
            Swal.fire({
                title: "Oops...",
                text: e.message,
                icon: "warning",
              });
              return false;
        }
    }
    
    const httpRequest = () => {
        document.getElementById('updateEmployee').addEventListener('submit', function(event) {
            event.preventDefault();
            const data = new FormData(event.target);

            let result = fieldValidation(data);
            
            if(result) {
                sendRequest(data);
            } else {
                return;
            }
        });
    }
    
    const sendRequest = async (formData) => {
        const jsonData = {};
        formData.forEach((value, key) => { jsonData[key] = value; });
        
        const url = 'Admin/updateEmployee';
        const settings = {
            method: "POST",
            headers: { // Correct placement of headers
              "Content-Type": "application/json"
            },
            body: JSON.stringify(jsonData), // Directly pass jsonData
          };
    
        try {
            const response = await fetch(url, settings);
        
            if(!response.ok) {
                throw new Error('Something went wrong.');
            }
    
            const jsonResponse = await response.json();
            
            if(!response.status) {
                Swal.fire({
                    title: "Oops...",
                    text: "Unable to update, please try again later.",
                    icon: "error",
                  });
            } else {
                Swal.fire({
                    title: "Information Update",
                    text: "Update success!",
                    icon: "success",
                  }).then(() => {
                    window.location.reload();
                  });
            }
        
        } catch(e) {
            Swal.fire({
                title: "Oops...",
                text: "Something went wrong.",
                icon: "error",
              });
        }
    }
    
    document.addEventListener('DOMContentLoaded', function(){
        getElementsValue();
        httpRequest();
    });
})();