// Initialize the date range picker 
// Disabled its auto update to show placeholder of the input field
// Replace placeholder after a date is chosen
$("#dateRangePicker").daterangepicker({
    autoUpdateInput: false,
    locale: {
      cancelLabel: "Clear",
    },
  });
  
  // Filters report/s according to the date/s input after clicking the apply button of the date picker
  $("#dateRangePicker").on("apply.daterangepicker", function (ev, picker) {
    $(this).val(
      picker.startDate.format("MM/DD/YYYY") +
        " - " +
        picker.endDate.format("MM/DD/YYYY")
    );
  });
  
  // If the cancel/clear button of the date picker is clicked, 
  // Filter function will not proceed but previous date range chosen will remained
  $("#dateRangePicker").on("cancel.daterangepicker", function (ev, picker) {
    $(this).val("");
  });
  
  // Filters report/s based on the picked date/date range
  $("#filterDateRange").click(function () {
    var dateRange = $("#dateRangePicker").val();
    if (!dateRange) {
      // Show all rows and reset visibility to initial state
      $("tr.date-header, tr.employee-record, tr.break-details-row").each(function () {
        $(this).show();
        if (!$(this).data("initial-visible")) {
          $(this).hide();
        }
      });
  
      updateBreakIcon();
  
      $("#displayNoReportsFound").hide();
      return;
    }
  
    var startDate = moment(dateRange.split(" - ")[0], "MM/DD/YYYY").startOf("day").toDate();
    var endDate = moment(dateRange.split(" - ")[1], "MM/DD/YYYY").endOf("day").toDate();
    var reportsFound = false;
  
    $("tr.date-header").each(function () {
      var reportDate = new Date($(this).next("tr.employee-record").attr("data-date"));
      if (reportDate >= startDate && reportDate <= endDate) {
        $(this).show();
        reportsFound = true;
      } else {
        $(this).hide();
        $(this).nextUntil("tr.date-header").hide();
      }
    });
  
    $("tr.employee-record").each(function () {
      var reportDate = new Date($(this).attr("data-date"));
      if (reportDate >= startDate && reportDate <= endDate) {
        $(this).show();
        $(this).next(".break-details-row").each(function () {
          if ($(this).data("initial-visible")) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
        
        reportsFound = true;
      } else {
        $(this).hide();
        $(this).next(".break-details-row").hide();
      }
    });
  
    updateBreakIcon();
  
    if (!reportsFound) {
      $("#displayNoReportsFound").show();
    } else {
      $("#displayNoReportsFound").hide();
    }
  });
  
  // Reset button to show all available reports
  $("#resetDate").click(function () {
    $("tr.date-header, tr.employee-record").show();
    $("tr.break-details-row").each(function () {
      if ($(this).data("initial-visible")) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  
    // If this is not called, the arrow icon will remained open even after reset
    updateBreakIcon();
  
    $("#displayNoReportsFound").hide();
    $("#dateRangePicker").val("");
  });
  
  // Function to update the arrow icon based on the visibility of the break details row
  function updateBreakIcon() {
    $(".view-breaks-btn").each(function () {
      var $button = $(this);
      var $breakDetailsRow = $button.closest("tr").next(".break-details-row");
      if ($breakDetailsRow.is(":visible")) {
        $button.attr("src", ROOT + "assets/img/breaks-up-arrow.png");
      } else {
        $button.attr("src", ROOT + "assets/img/breaks-down-arrow.png");
      }
    });
  }
