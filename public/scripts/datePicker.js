$("#dateRangePicker").daterangepicker({
  autoUpdateInput: false,
  locale: {
    cancelLabel: "Clear",
  },
});

$("#dateRangePicker").on("apply.daterangepicker", function (ev, picker) {
  $(this).val(
    picker.startDate.format("MM/DD/YYYY") +
      " - " +
      picker.endDate.format("MM/DD/YYYY")
  );
});

$("#dateRangePicker").on("cancel.daterangepicker", function (ev, picker) {
  $(this).val("");
});

$("#filterDateRange").click(function () {
  var dateRange = $("#dateRangePicker").val();
  if (!dateRange) {
    $("tr.date-header").show();
    $("tr.employee-record").show();
    $("#displayNoReportsFound").hide();
    return;
  }

  var startDate = moment(dateRange.split(" - ")[0], "MM/DD/YYYY")
    .startOf("day")
    .toDate();
  var endDate = moment(dateRange.split(" - ")[1], "MM/DD/YYYY")
    .endOf("day")
    .toDate();
  var reportsFound = false;

  $("tr.date-header").each(function () {
    var reportDate = new Date(
      $(this).next("tr.employee-record").attr("data-date")
    );
    if (reportDate >= startDate && reportDate <= endDate) {
      $(this).show();
      reportsFound = true;
    } else {
      $(this).hide();
    }
  });

  $("tr.employee-record").each(function () {
    var reportDate = new Date($(this).attr("data-date"));
    if (reportDate >= startDate && reportDate <= endDate) {
      $(this).show();
      reportsFound = true;
    } else {
      $(this).hide();
    }
  });

  if (!reportsFound) {
    $("#displayNoReportsFound").show();
  } else {
    $("#displayNoReportsFound").hide();
  }
});

$("#resetDate").click(function () {
  $("tr.date-header").show();
  $("tr.employee-record").show();
  $("#displayNoReportsFound").hide();
  $("#dateRangePicker").val("");
});
