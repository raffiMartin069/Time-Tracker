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

    const formCheck = (formData) => {
        // Check if the formData has 'email' and it's not empty
        if (!formData.has('email') || formData.get('email').trim() === '') {
            return [false, 'email'];
        }
        return [true];
    }

    const validate = () => {
        const btn = document.getElementById('sendBtn');
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const form = document.getElementById('initial-forgotpass');
            const formData = new FormData(form);
            const result = formCheck(formData);
            if(!result[0]) {
                if(result[1] === 'email') {
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

    const httpRequest = (formData) => {
        const url = "initialReset";

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
                success('Email sent!', 'Please check your email for further instructions.');
                return;
            }).catch(error => {
                warning('Error', error);
            });
     }
     document.addEventListener('DOMContentLoaded', () => {
        validate();
     });
})();