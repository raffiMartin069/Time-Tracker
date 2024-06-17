const extractData = (formData) => {
    let jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });
    return jsonData;
}

const httpRequest = (formData) => {

  const url = "Admin/createMeeting";
  let jsonData = extractData(formData);
  
  const data = {
    method: "POST",
    headers: { // Correct placement of headers
      "Content-Type": "application/json"
    },
    body: JSON.stringify(jsonData), // Directly pass jsonData
  };

  fetch(url, data)
    .then((response) => {
      if (!response.ok) {
        return response.json().then((error) => {
          throw new Error(error.error || "Unknown error occurred");
        });
      }
      return response.json();
    })
    .then((response) => {
      Swal.fire({
        title: "Success",
        text: response.message,
        icon: "success",
      }).then(() => {
        window.location.reload(); // Reload the page after the alert is closed
      });
    })
    .catch(
        error => {
            Swal.fire({
                title: "Oops.",
                text: error.toString().replace("Error: ", ""),
                icon: "error",
            });
        }
    );
};


export default httpRequest;