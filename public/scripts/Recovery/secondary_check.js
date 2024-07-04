import { formCheck } from "../security.js";
import "../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js";
(() => {

    const warning = (title, body) => {
        Swal.fire({
            icon: "warning",
            title: title,
            text: body,
          }).then(() => {
            return false;
          });
    }

    const success = (title, body) => {
        Swal.fire({
            icon: "success",
            title: title,
            text: body,
          }).then(() => {
            return false;
          });
    }

    const validate = () => {
        const btn = document.getElementById('continueBtn');
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const form = document.getElementById('reconfirm_form');
            const formData = new FormData(form);
            const result = formCheck(formData);
            if(!result[0]) {
                if(result[1] === 'idNumber') {
                    warning('Forgot something?', 'Id can not be empty.');
                }
                return;
            }
            httpRequest(formData);
        })  
     }

    const convertJson = (formData) => {
        let object = {};
        formData.forEach((value, key) => (object[key] = value));
        let json = JSON.stringify(object);
        return json;
     }

     // Create a request going to server.
    const httpRequest = (formData) => {
        const url = "secondaryReset";

        const form = {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: convertJson(formData),
        };
    
        fetch(url, form)
            .then((response) => {
                if (!response.ok) {
                    return response.json().then((errorData) => {
                        throw new Error(errorData.error || "An unknown error occurred");
                    });
                }
                return response.json();
            }).then((data) => {
                if(data.result !== true) {
                    warning('Error', 'Something went wrong.');
                    return;
                }
                
                // Reveal modal when request is successful.
                // This modal is used to display the actual resetting of the password.
                const modalElement = document.getElementById('exampleModal');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();

            }).catch(error => {
                warning('Error', error.error);
            });
     }
     document.addEventListener('DOMContentLoaded', () => {
        validate();
     });
})();