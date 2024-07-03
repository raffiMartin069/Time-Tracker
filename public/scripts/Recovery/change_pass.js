(() => {
  const toggleVisiblity = () => {
    const isVisible = document.getElementById("showPass");

    isVisible.addEventListener("click", () => {
      if (isVisible.checked) {
        document.getElementById("pass").type = "text";
        document.getElementById("confirm_pass").type = "text";
      } else {
        document.getElementById("pass").type = "password";
        document.getElementById("confirm_pass").type = "password";
      }
    });
  };

  const fetch = () => {
    const formData = new FormData(document.getElementById("change-pass"));

    const jsonData = {}
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

  }

  document.addEventListener("DOMContentLoaded", () => {
    toggleVisiblity();
  });
})();
