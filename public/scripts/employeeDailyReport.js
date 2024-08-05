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
