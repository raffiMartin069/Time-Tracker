$(".view-breaks-btn").click(function () {
  var $button = $(this);
  var $breakDetailsRow = $button.closest("tr").next(".break-details-row");
  var $accordionBody = $breakDetailsRow.find(".accordion-body");

  $breakDetailsRow.toggle();

  $button.attr(
    "src",
    $breakDetailsRow.is(":visible")
      ? ROOT + "assets/img/breaks-up-arrow.png"
      : ROOT + "assets/img/breaks-down-arrow.png"
  );

  if (
    $breakDetailsRow.is(":visible") &&
    $accordionBody.text().trim() === "Loading..."
  ) {
    $.ajax({
      url: "Admin/BreakStamps",
      method: "GET",
      data: {
        daily_id: $button.closest("tr").find(".daily-id").text(),
      },
      dataType: "json",
      success: function (data) {
        var content =
          '<table class="table table-responsive" id="breakStampsTable"><thead><tr>';
        for (let i = 0; i < data.length; i++) {
          content +=
            "<th>Break " +
            (i + 1) +
            " Start</th><th>Break " +
            (i + 1) +
            " End</th>";
        }
        content += "</tr></thead><tbody>";
        if (data.length > 0) {
          content += "<tr>";
          data.reverse().forEach(function (report) {
            content +=
              "<td>" +
              report.BREAK_IN +
              "</td><td>" +
              report.BREAK_OUT +
              "</td>";
          });
          content += "</tr>";
        } else {
          content +=
            '<tr><td colspan="' +
            data.length * 2 +
            '">No breaks taken</td></tr>';
        }
        content += "</tbody></table>";
        $accordionBody.html(content);
      },
      error: function (xhr, status, error) {
        var errorMessage =
          "An error has occured while fetching break data. Please try again later.";
        if (xhr.responseJSON && xhr.responseJSON.error) {
          errorMessage = xhr.responseJSON.error;
        }

        $accordionBody.html(errorMessage);
      },
    });
  }
});

const editButtons = document.querySelectorAll(".editReportBtn");
editButtons.forEach((button) => {
  button.addEventListener("click", function () {
    const dailyId = this.getAttribute("data-daily-id");
    const empId = this.getAttribute("data-emp-id");
    const empName = this.getAttribute("data-name");
    const reportDate = this.getAttribute("data-date");
    const empClockin = this.getAttribute("data-clock-in");
    const empLunchin = this.getAttribute("data-lunch-in");
    const empLunchout = this.getAttribute("data-lunch-out");
    const empClockout = this.getAttribute("data-clock-out");

    document.getElementById("modal-employee-name").value = empName;
    document.getElementById("modal-report-date").value = reportDate;
    document.getElementById("modal-clock-in").value = empClockin;
    document.getElementById("modal-lunch-in").value = empLunchin;
    document.getElementById("modal-lunch-out").value = empLunchout;
    document.getElementById("modal-clock-out").value = empClockout;

    let originalBreakData = [];
    // A Flag set to display a successful message only once
    let successMsg = false;
    // Tracks the number of AJAX requests
    let ajaxRequestsCount = 0;  
    let xhrError; 

    // If an error is encountered, the flag will reset to false
    function resetFlags() {
      successMsg = false;
    }

    // Sets the boolean flag to true if the new time stamp/s is/are correct
    // Displays the appropriate success message after the function call: checkAndDisplayMsgPrompt()
    function handleSuccessFlag(newTimeStamp, timeFormat) {
      if (timeFormat.test(newTimeStamp)) {
        successMsg = true;
      }
      checkAndDisplayMsgPrompt();
    }

    // Displays the appropriate error message returned from the server after the function call: checkAndDisplayMsgPrompt()
    function handleError(xhr) {
      xhrError = xhr;
      checkAndDisplayMsgPrompt();
    }

    function checkAndDisplayMsgPrompt() {
      ajaxRequestsCount -= 1;
      if (ajaxRequestsCount === 0) {
        if (successMsg) {
          Swal.fire({
            title: "Success",
            text: "Report has been updated successfully!",
            icon: "success",
          }).then(() => {
            location.reload();
            resetFlags();
          });
        } else {
          let errorMessage =
            "Failed to update the report! Please make sure updated entries are in the correct format (HH:MM:SS AM/PM) and doesn't overlap with other timestamps.";

            if (xhrError && xhrError.responseJSON && xhrError.responseJSON.error) {
              errorMessage = xhrError.responseJSON.error;
            }

          // Remove "Error." or "Error:" prefix from the returned message  
          errorMessage = errorMessage.replace(/Error[.:] /, "");

          Swal.fire({
            title: "Oops.",
            text: errorMessage,
            icon: "error",
          });
        }
      }
    }

    $.ajax({
      url: "Admin/BreakStamps",
      method: "GET",
      data: {
        daily_id: dailyId,
      },
      dataType: "json",
      success: function (data) {
        var breakInputs = "";
        data.reverse().forEach(function (report, index) {
          breakInputs += `<div class="mb-2" style="text-align: left;">
                 Break ${index + 1} Start:
                 <input type="text" class="mt-1 form-control break-start" value="${
                   report.BREAK_IN
                 }" data-record-id="${report.RECORD_ID}">
             </div>
             <div class="mb-2" style="text-align: left;">
                 Break ${index + 1} End:
                 <input type="text" class="mt-1 form-control break-end" value="${
                   report.BREAK_OUT
                 }" data-record-id="${report.RECORD_ID}">
             </div>`;
        });
        document.getElementById("breakInputs").innerHTML = breakInputs;
        originalBreakData = data;

        document.getElementById("loadingMessage").style.display = "none";
        document.getElementById("editReportForm").style.display = "block";
      },
      error: function (xhr) {
        var errorMessage = "Something went wrong. Please try again later.";
        if (xhr.responseJSON && xhr.responseJSON.error) {
          errorMessage = xhr.responseJSON.error;
        } 

        // Remove "Error." or "Error:" prefix from the returned message if there is
        errorMessage = errorMessage.replace(/Error[.:] /, "");

        Swal.fire({
          title: "Error",
          text: errorMessage,
          icon: "error",
        });

        $(".swal2-confirm").click(function () {
          location.reload();
        });
      },
    });

    document.getElementById("updateReport").onclick = function () {
      const modalClockIn = document.getElementById("modal-clock-in").value;
      const modalClockOut = document.getElementById("modal-clock-out").value;
      const modalLunchIn = document.getElementById("modal-lunch-in").value;
      const modalLunchOut = document.getElementById("modal-lunch-out").value;

      const timeFormat = /^(0?[1-9]|1[0-2]):[0-5][0-9]:[0-5][0-9] (AM|PM)$/i;

      ajaxRequestsCount = 0; // Reset pending AJAX requests

      if (empClockin !== modalClockIn) {
        ajaxRequestsCount++;
        $.ajax({
          url: "Admin/UpdateClockInReport",
          method: "POST",
          data: {
            daily_id: dailyId,
            report_date: reportDate,
            clock_in: modalClockIn,
          },
          success: function () {
            handleSuccessFlag(modalClockIn, timeFormat);
          },
          error: handleError,
        });
      }

      if (empClockout !== modalClockOut) {
        ajaxRequestsCount++;
        $.ajax({
          url: "Admin/UpdateClockOutReport",
          method: "POST",
          data: {
            daily_id: dailyId,
            report_date: reportDate,
            clock_out: modalClockOut,
          },
          success: function () {
            handleSuccessFlag(modalClockOut, timeFormat);
          },
          error: handleError,
        });
      }

      if (empLunchin !== modalLunchIn || empLunchout !== modalLunchOut) {
        ajaxRequestsCount++;
        $.ajax({
          url: "Admin/UpdateLunchReport",
          method: "POST",
          data: {
            daily_id: dailyId,
            emp_id: empId,
            report_date: reportDate,
            lunch_in: modalLunchIn,
            lunch_out: modalLunchOut,
          },
          success: function () {
            if (
              timeFormat.test(modalLunchIn) &&
              timeFormat.test(modalLunchOut)
            ) {
              handleSuccessFlag(modalLunchIn, timeFormat);
            } else {
              handleError();
            }
          },
          error: handleError,
        });
      }

      const breakInputs = document.querySelectorAll("#breakInputs input");
      for (let i = 0; i < breakInputs.length; i += 2) {
        const breakIn = breakInputs[i].value;
        const breakOut = breakInputs[i + 1].value;
        const recordId = breakInputs[i].getAttribute("data-record-id");

        if (originalBreakData[i / 2]) {
          if (
            breakIn !== originalBreakData[i / 2].BREAK_IN ||
            breakOut !== originalBreakData[i / 2].BREAK_OUT
          ) {
            ajaxRequestsCount++;
            $.ajax({
              url: "Admin/UpdateBreakReport",
              method: "POST",
              data: {
                daily_id: dailyId,
                record_id: recordId,
                emp_id: empId,
                report_date: reportDate,
                break_in: breakIn,
                break_out: breakOut,
              },
              success: function () {
                handleSuccessFlag(breakIn, timeFormat);
              },
              error: handleError,
            });
          }
        }
      }

      if (ajaxRequestsCount === 0) {
        // If no updates were made, the flag will reset
        resetFlags();
      }

      $("#closeReport").click(function () {
        $("#editReportModal").modal("hide");
      });
    };
  });
});
