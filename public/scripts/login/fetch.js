document.addEventListener("DOMContentLoaded", function () {
  sendData();
});

const sendData = async () => {
  document.getElementById("login-form").addEventListener("submit", function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    httpRequest(formData); // Pass formData to httpRequest
  });
}

const httpRequest = async (formData) => {
  // Convert FormData to JSON
  let object = {};
  formData.forEach((value, key) => object[key] = value);
  let json = JSON.stringify(object);

  const url = "Login/auth";
  const form = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: json, // Use the converted JSON
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
      window.location.href = data.redirect;
    })
    .catch((error) => {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: error.message,
      });
    });
}