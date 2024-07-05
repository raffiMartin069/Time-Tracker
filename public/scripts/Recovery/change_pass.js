(() => {
  const warning = (title, body) => {
    Swal.fire({
      icon: "warning",
      title: title,
      text: body,
    }).then(() => {
      return false;
    });
  };

  const success = (title, body, url) => {
    Swal.fire({
      icon: "success",
      title: title,
      text: body,
    }).then(() => {
      window.location.href = url;
    });
  };

  const toggleVisiblity = () => {
    const isVisible = document.getElementById("showPass");

    isVisible.addEventListener("click", () => {
      if (isVisible.checked) {
        document.getElementById("new_pw").type = "text";
        document.getElementById("confirm_pw").type = "text";
      } else {
        document.getElementById("new_pw").type = "password";
        document.getElementById("confirm_pw").type = "password";
      }
    });
  };

  const checkFields = (formData) => {
    for (let [key, value] of formData.entries()) {
      if (value.trim() === "") {
        return false;
      }
    }
    return true;
  };

  const prepareRequest = () => {
    document.getElementById("change-pass").addEventListener("submit", (e) => {
      e.preventDefault();
      const formElement = e.target;
      const formData = new FormData(formElement);
      let chk_result = checkFields(formData);
      if (!chk_result) {
        warning("Forgot something?", "Please fill out all fields.");
        return;
      }
      httpRequest(formData);
    });
  };

  const httpRequest = (formData) => {
    const jsonData = {};
    formData.forEach((value, key) => {
      jsonData[key] = value;
    });

    const settings = {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(jsonData),
    };

    const url = "resetPassword";
    fetch(url, settings)
      .then((response) => {
        if (!response.ok) {
          return response.json().then((errorData) => {
            throw new Error(errorData.error || "An unknown error occurred");
          });
        }
        return response.json();
      })
      .then((data) => {
        if (!data.result) {
          warning("Failed!", "Password change failed.");
        }

        success("Success!", "Password changed successfully.", data.redirect);
      })
      .catch((error) => {
        warning("Failed!", error);
      });
  };

  document.addEventListener("DOMContentLoaded", () => {
    toggleVisiblity();
    prepareRequest();
  });
})();
