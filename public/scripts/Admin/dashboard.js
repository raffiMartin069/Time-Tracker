import * as Err from '../error.js';

// Function to handle time in/out button click
const timeInOutButton = () => {
  const textElement = timeToggle.querySelector("small");
  timeToggle.addEventListener("click", function (e) {
    e.preventDefault();

    let state = 0;
    let action = "";

    // Toggle the text and state
    if (textElement.innerText === "Time In") {
      action = "timeIn";
      state = 0; // User is timed in
    } else {
      action = "timeOut";
      state = 1;
    }
    // Perform HTTP request
    httpRequest(state, action);
  });
};

const sortByNewest = () => {
  const table = document.querySelector("#table");
  const tbody = table.querySelector("tbody");
  const rows = [...tbody.rows];

  rows.sort((a, b) => {
    let dateA = new Date(a.cells[0].textContent);
    let dateB = new Date(b.cells[0].textContent);

    return dateB - dateA;
  });

  rows.forEach((row) => {
    tbody.appendChild(row);
  });
};


const meetingBtn = () => {
    const meeting = meetingToggle.querySelector("small");    
    meetingToggle.addEventListener("click", function(e){
        e.preventDefault();
        let state = 2;
        let action = "";

        if(meeting.innerText === "Meeting In"){
            action = "startMeeting";
            state = 2;
        } else {
            action = "endMeeting";
            state = 3;
        }
        httpRequest(state, action);
    });
}

const breakBtn = () => {
    const adminBreak = breakToggle.querySelector("small");
    breakToggle.addEventListener("click", function(e){
        e.preventDefault();
        let state = 4;
        let action = "";

        if(adminBreak.innerText === "Break In"){
            action = "startBreak";
            state = 4;
        } else {
            action = "endBreak";
            state = 5;
        }
        httpRequest(state, action);
    });

}

const action = {
  timeIn: 0,
  timeOut: 1,
  startMeeting: 2,
  endMeeting: 3,
  startBreak: 4,
  endBreak: 5,
};

const mapAction = (response) => {
  let message = "";
      if (response === action.timeIn) {
        message = "Time in";
      } else if (response === action.timeOut) {
        message = "Time out";
      } else if (response === action.startMeeting) {
        message = "Meeting started";
      } else if (response === action.endMeeting) {
        message = "Meeting ended";
      } else if (response === action.startBreak) {
        message = "Break started";
      } else if (response === action.endBreak) {
        message = "Break ended";
      }
      return message;
}


const httpRequest = async (state, action) => {
  let url = "Admin/Status";

  let response = await fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ state, action }),
  })
    .then((response) => {
      if (!response.ok) {
        // If the response status code is not in the 200-299 range,
        // we still want to parse the response as JSON to get the error message.
        return response.json().then((errorData) => {
          throw new Error(errorData.error || "Unknown error occurred");
        });
      }
      return response.json(); // Parse successful response as JSON
    })
    .then((response) => {
      // Handle your successful response data
      let mess = mapAction(state);
      Swal.fire({
        title: "Success",
        text: mess + " successfully!",
        icon: "success",
      }).then(() => {
        window.location.reload(); // Reload the page after the alert is closed
      });
    })
    .catch((error) => {      
      Swal.fire({
        title: "Oops.",
        text: error.toString().replace("Error: ", ""),
        icon: "error",
      });
    });
};

// Initialize the time in/out button
timeInOutButton();
meetingBtn();
breakBtn();