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

const errorMsg = (error) => {
  let message = Err.DEFAULT_ERROR;

  if(error.message.includes(Err.ALREADY_CLOCKED_IN)){
    message = Err.TIME_IN_PAST;
  }

  if(error.message.includes(Err.INVALID_MEETING_HOUR)){
    message = Err.OUT_OF_HOURS_MEETING;
  }

  if(error.message.includes(Err.NO_MEETING)){
    message = Err.NO_MEETING_SCHEDULED;
  }

  if(error.message.includes(Err.NO_ASSIGNED_MEETING)){
    message = Err.NO_MEETING_ASSIGNED;
  }

  if(error.message.includes(Err.MEETING_ATTENDED)){
    message = Err.MEETING_ALREADY_LOGGED;
  }

  if(error.message.includes(Err.BREAK_ALREADY_LOGGED)){
    message = Err.BREAK_USED;
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
      Swal.fire({
        title: "Success",
        text: "Time in/out successful",
        icon: "success",
      }).then(() => {
        window.location.reload(); // Reload the page after the alert is closed
      });;
    })
    .catch((error) => {
      // Check if the error message contains the specific text
      let message = errorMsg(error);
      
      Swal.fire({
        title: "Error",
        text: message,
        icon: "error",
      });
    });
};

// Initialize the time in/out button
timeInOutButton();
meetingBtn();
breakBtn();