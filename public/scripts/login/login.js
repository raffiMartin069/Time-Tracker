document.addEventListener("DOMContentLoaded", () => {
  hideView();
  show();
  hide();
  // regEx();
});

// initial state should be hidden
const hideView = () => {
  const view = document.getElementById("view");
  view.hidden = true;
};

// show when toggled
const show = () => {
  const view = document.getElementById("view-pass");
  view.addEventListener("click", () => {
    view.hidden = true;
    document.getElementById("view").hidden = false;
    let password = document.getElementById("pass");
    password = password.setAttribute("type", "text");
  });
};

// hide when toggled
const hide = () => {
  const view = document.getElementById("view");
  view.addEventListener("click", () => {
    view.hidden = true;
    document.getElementById("view-pass").hidden = false;
    let password = document.getElementById("pass");
    password = password.setAttribute("type", "password");
  });
}



//  const regEx = () => {
//   const id = document.getElementById("idNumber");

//   id.addEventListener("input", (event) => {
//     const input = event.target;
//     const value = input.value;

//     // Create a regular expression to match allowed characters (digits and dashes)
//     const regex = /^[0-9-]*$/;

//     if (!regex.test(value)) {
//       // If the value contains invalid characters, remove them
//       input.value = value.replace(/[^0-9-]/g, "");

//       // Move the cursor to the end of the input
//       input.setSelectionRange(input.value.length, input.value.length);
//     }
//   });
// }