$(".view-breaks-btn").click(function () {
  var $button = $(this);
  var dailyId = $button.closest("tr").find(".daily-id").text();
  var $breakDetailsRow = $button.closest("tr").next(".break-details-row");
  var $accordionBody = $breakDetailsRow.find(".accordion-body");

  $breakDetailsRow.toggle();

  if ($breakDetailsRow.is(":visible")) {
    $button.attr("src", ROOT + "assets/img/breaks-up-arrow.png");
  } else {
    $button.attr("src", ROOT + "assets/img/breaks-down-arrow.png");
  }

  if (
    $breakDetailsRow.is(":visible") &&
    $accordionBody.text().trim() === "Loading..."
  ) {
    $.ajax({
      url: "Admin/BreakStamps",
      method: "GET",
      data: {
        daily_id: dailyId,
      },
      dataType: "json",
      success: function (data) {
        var content = '<table class="table table-responsive"><thead><tr>';
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
        console.error("AJAX error:", status, error);
        $accordionBody.html("Error fetching break data");
      },
    });
  }
});

const editButtons = document.querySelectorAll(".edit-report-btn");
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
    // Flag to track success messages of each updated inputs and only display one message all at once
    let successMsg = false;  

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
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", status, error);
      },
    });

    document
      .getElementById("updateReport")
      .addEventListener("click", function () {
        const modalClockIn = document.getElementById("modal-clock-in").value;
        const modalClockOut = document.getElementById("modal-clock-out").value;
        const modalLunchIn = document.getElementById("modal-lunch-in").value;
        const modalLunchOut = document.getElementById("modal-lunch-out").value;

        const timeFormat = /^(0?[1-9]|1[0-2]):[0-5][0-9]:[0-5][0-9] (AM|PM)$/i;

        if (empClockin !== modalClockIn) {
          $.ajax({
            url: "Admin/UpdateClockInReport",
            method: "POST",
            data: {
              daily_id: dailyId,
              report_date: reportDate,
              clock_in: modalClockIn,
            },
            success: function (data) {
              if (!successMsg) {
                $("#editReportModal").modal("hide");
                if (timeFormat.test(modalClockIn)) {
                  Swal.fire({
                    title: "Success",
                    text: "Report has been updated successfully!",
                    icon: "success",
                  }).then(() => location.reload());
                  successMsg = true;
                } else {
                  Swal.fire({
                    title: "Error",
                    html: "Failed to update report!<br>Invalid time format. Please use HH:MM:SS AM/PM.",
                    icon: "error",
                  }).then(() => location.reload());
                }
              }
            },
            error: function (xhr, status, error) {
              if (!successMsg) {
                Swal.fire({
                  title: "Error",
                  html: "Failed to update report!<br>Please make sure updated entries are within the correct range: not earlier, equal, or later than other time stamps.",
                  icon: "error",
                });
                successMsg = true;
              }
            },
          });
        }

        if (empClockout !== modalClockOut) {
          $.ajax({
            url: "Admin/UpdateClockOutReport",
            method: "POST",
            data: {
              daily_id: dailyId,
              report_date: reportDate,
              clock_out: modalClockOut,
            },
            success: function (data) {
              if (!successMsg) {
                $("#editReportModal").modal("hide");
                if (timeFormat.test(modalClockOut)) {
                  Swal.fire({
                    title: "Success",
                    text: "Report has been updated successfully!",
                    icon: "success",
                  }).then(() => location.reload());
                  successMsg = true;
                } else {
                  Swal.fire({
                    title: "Error",
                    html: "Failed to update report!<br>Invalid time format. Please use HH:MM:SS AM/PM.",
                    icon: "error",
                  }).then(() => location.reload());
                }
              }
            },
            error: function (xhr, status, error) {
              if (!successMsg) {
                Swal.fire({
                  title: "Error",
                  html: "Failed to update report!<br>Please make sure updated entries are within the correct range: not earlier, equal, or later than other time stamps.",
                  icon: "error",
                });
                successMsg = true;
              }
            },
          });
        }

        if (empLunchin !== modalLunchIn || empLunchout !== modalLunchOut) {
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
            success: function (data) {
              if (!successMsg) {
                $("#editReportModal").modal("hide");
                if (
                  timeFormat.test(modalLunchIn) &&
                  timeFormat.test(modalLunchOut)
                ) {
                  Swal.fire({
                    title: "Success",
                    text: "Report has been updated successfully!",
                    icon: "success",
                  }).then(() => location.reload());
                  successMsg = true;
                } else {
                  Swal.fire({
                    title: "Error",
                    html: "Failed to update report!<br>Invalid time format. Please use HH:MM:SS AM/PM.",
                    icon: "error",
                  }).then(() => location.reload());
                }
              }
            },
            error: function (xhr, status, error) {
              if (!successMsg) {
                Swal.fire({
                  title: "Error",
                  html: "Failed to update report!<br>Please make sure updated entries are within the correct range: not earlier, equal, or later than other time stamps.",
                  icon: "error",
                });
                successMsg = true;
              }
            },
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
                success: function (data) {
                  if (!successMsg) {
                    $("#editReportModal").modal("hide");
                    if (timeFormat.test(breakIn) && timeFormat.test(breakOut)) {
                      Swal.fire({
                        title: "Success",
                        text: "Report has been updated successfully!",
                        icon: "success",
                      }).then(() => location.reload());
                      successMsg = true;
                    } else {
                      Swal.fire({
                        title: "Error",
                        html: "Failed to update report!<br>Invalid time format. Please use HH:MM:SS AM/PM.",
                        icon: "error",
                      }).then(() => location.reload());
                    }
                  }
                },
                error: function (xhr, status, error) {
                  if (!successMsg) {
                    Swal.fire({
                      title: "Error",
                      html: "Failed to update report!<br>Please make sure updated entries are within the correct range: not earlier, equal, or later than other time stamps.",
                      icon: "error",
                    });
                    successMsg = true;
                  }
                },
              });
            }
          }
        }

        $("#closeReport").click(function () {
          $("#editReportModal").modal("hide");
        });
      });
  });
});
