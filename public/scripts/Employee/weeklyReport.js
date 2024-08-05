var dailyReportsModal = $("#myModal");

$(".clickMyDots").click(function () {
  var reportDate = $(this).closest("tr").find(".getmyreportdate").text();

  $.ajax({
    url: "Employee/fetchWeeklyDailyReports",
    method: "GET",
    data: {
      report_date: reportDate,
      emp_id: empId,
    },
    dataType: "json",
    success: function (data) {
      var dailyReportsBody = $("#dailyReportsBody");
      dailyReportsBody.empty();

      if (data.length > 0) {
        data.forEach(function (report) {
          if (report.DATE !== "") {
            var checkClockIn;
            if (
              report.CLOCK_IN !== null &&
              report.CLOCK_IN !== undefined &&
              report.CLOCK_IN !== ""
            ) {
              checkClockIn = report.CLOCK_IN;
            } else {
              checkClockIn = "N/A";
            }

            var checkLunchIn;
            if (
              report.LUNCH_IN !== null &&
              report.LUNCH_IN !== undefined &&
              report.LUNCH_IN !== ""
            ) {
              checkLunchIn = report.LUNCH_IN;
            } else {
              checkLunchIn = "N/A";
            }

            var checkLunchOut;
            if (
              report.LUNCH_OUT !== null &&
              report.LUNCH_OUT !== undefined &&
              report.LUNCH_OUT !== ""
            ) {
              checkLunchOut = report.LUNCH_OUT;
            } else {
              checkLunchOut = "N/A";
            }

            var checkBreakTaken = report.TOTAL_BREAK;
            if (report.TOTAL_BREAK !== "N/A") {
              checkBreakTaken += `<img src="${ROOT}/assets/img/breaks-down-arrow.png" class="img-fluid ms-2 view-breaks-btn" style="width: 20px;" data-daily-id="${report.DAILY_ID}">`;
            }

            var checkClockOut;
            if (
              report.CLOCK_OUT !== null &&
              report.CLOCK_OUT !== undefined &&
              report.CLOCK_OUT !== ""
            ) {
              checkClockOut = report.CLOCK_OUT;
            } else {
              checkClockOut = "N/A";
            }

            var checkTotalDailyHrs;
            if (checkClockIn !== "N/A") {
              if (
                report.HRS_WORKED !== null &&
                report.HRS_WORKED !== undefined &&
                report.HRS_WORKED !== ""
              ) {
                checkTotalDailyHrs = report.HRS_WORKED;
              } else {
                checkTotalDailyHrs = "";
              }
            } else {
              checkTotalDailyHrs = "N/A";
            }

            var row = `
                            <tr>  
                                <td>${report.DATE}</td>
                                <td>${checkClockIn}</td>
                                <td>${checkLunchIn}</td>
                                <td>${checkLunchOut}</td>
                                <td class="viewBreaks">
                                    ${checkBreakTaken}
                                </td>                                
                                <td>${checkClockOut}</td>  
                                <td>${checkTotalDailyHrs}</td>
                            </tr>
                            <tr class="break-details-row" style="display: none;">
                    <td colspan="7">
                        <div class="accordion" id="accordionBreaks${report.DAILY_ID}">
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="heading${report.DAILY_ID}">
                                    <span class="ms-2 mt-1 mb-1" style="text-align: left; display: block;"><i class="lni lni-coffee-cup"></i><span class="ms-2">Break Periods</span></span>
                                </h6>
                                <div id="collapse${report.DAILY_ID}" class="accordion-collapse collapse show" aria-labelledby="heading${report.DAILY_ID}" data-bs-parent="#accordionBreaks${report.DAILY_ID}">
                                    <div class="accordion-body">
                                        Loading...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                        `;
          }
          dailyReportsBody.append(row);
        });
      } else {
        dailyReportsBody.html(
          '<tr><td colspan="6">No daily reports found for this week.</td></tr>'
        );
      }

      dailyReportsModal.show();
    },
    error: function (xhr, status, error) {
      console.error("AJAX error:", status, error);
      var errorMessage = xhr.responseJSON
        ? xhr.responseJSON.error
        : "An error occurred while fetching data.";
      var dailyReportsBody = $("#dailyReportsBody");
      dailyReportsBody.html(
        '<tr><td colspan="6">' + errorMessage + "</td></tr>"
      );
      dailyReportsModal.show();
    },
  });
});

$(document).on("click", ".view-breaks-btn", function () {
  var $button = $(this);
  var dailyId = $button.data("daily-id");
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

$(".downloadBtn").click(function (event) {
  event.preventDefault();
  var reportDate = $(this).closest("tr").find(".getmyreportdate").text();
  var form = $(this).closest("form");

  var isAlreadyDownloaded = form.find('input[name="date[]"]').length > 0;

  if (!isAlreadyDownloaded) {
    $.ajax({
      url: "Admin/fetchWeeklyDailyReports",
      method: "GET",
      data: {
        report_date: reportDate,
        emp_id: empId,
      },
      dataType: "json",
      success: function (data) {
        if (data.length > 0) {
          data.forEach(function (report) {
            form.append(
              '<input type="hidden" name="date[]" value="' + report.DATE + '">'
            );
            form.append(
              '<input type="hidden" name="clockin[]" value="' +
                report.CLOCK_IN +
                '">'
            );
            form.append(
              '<input type="hidden" name="lunchduration[]" value="' +
                report.LUNCH_DURATION +
                '">'
            );
            form.append(
              '<input type="hidden" name="breakduration[]" value="' +
                report.TOTAL_BREAK +
                '">'
            );
            form.append(
              '<input type="hidden" name="clockout[]" value="' +
                report.CLOCK_OUT +
                '">'
            );
            form.append(
              '<input type="hidden" name="hoursworked[]" value="' +
                report.HRS_WORKED +
                '">'
            );
            form.append(
              '<input type="hidden" name="shifty" value="' +
                report.SHIFTY +
                '">'
            );
          });

          form.submit();
        } else {
          alert("No daily reports found for this report.");
        }
      },
      error: function (xhr, status, error) {
        console.error(error);
      },
    });
  } else {
    form.submit();
  }
});

dailyReportsModal.hide();

$(window).click(function (event) {
  if (event.target == dailyReportsModal[0]) {
    dailyReportsModal.hide();
  }
});
