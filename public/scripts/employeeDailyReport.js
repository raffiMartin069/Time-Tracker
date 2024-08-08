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
        var errorMessage = "An error has occured while fetching break data. Please try again later.";
        if (xhr.responseJSON && xhr.responseJSON.error) {
          errorMessage = xhr.responseJSON.error;
        }
  
        $accordionBody.html(errorMessage);
      },
    });
  }
});
