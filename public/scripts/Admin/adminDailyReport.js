$('#dateRangePicker').daterangepicker({
  autoUpdateInput: false,
  locale: {
      cancelLabel: 'Clear'
  }
});

$('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
  $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
});
 
$('#dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
  $(this).val('');
});
 
$('#filterDateRange').click(function() {
  var dateRange = $('#dateRangePicker').val();
  if (!dateRange) {
      $('tr.date-header').show();
      $('tr.employee-record').show();
      $('#displayNoReportsFound').hide();
      return;
  }

  var startDate = moment(dateRange.split(' - ')[0], 'MM/DD/YYYY').startOf('day').toDate();
  var endDate = moment(dateRange.split(' - ')[1], 'MM/DD/YYYY').endOf('day').toDate();
  var reportsFound = false;

  $('tr.date-header').each(function() {
      var reportDate = new Date($(this).next('tr.employee-record').attr('data-date'));
      if (reportDate >= startDate && reportDate <= endDate) {
          $(this).show();
          reportsFound = true;
      } else {
          $(this).hide();
      }
  });

  $('tr.employee-record').each(function() {
      var reportDate = new Date($(this).attr('data-date'));
      if (reportDate >= startDate && reportDate <= endDate) {
          $(this).show();
          reportsFound = true;
      } else {
          $(this).hide();
      }
  });

  if (!reportsFound) {
      $('#displayNoReportsFound').show();
  } else {
      $('#displayNoReportsFound').hide();
  }
});

$('#resetDate').click(function() {
  $('tr.date-header').show();
  $('tr.employee-record').show();
  $('#displayNoReportsFound').hide();
  $('#dateRangePicker').val('');
});

$('.view-breaks-btn').click(function() {
  var $button = $(this);
  var dailyId = $button.closest('tr').find('.daily-id').text();
  var $breakDetailsRow = $button.closest('tr').next('.break-details-row');
  var $accordionBody = $breakDetailsRow.find('.accordion-body'); 
 

  $breakDetailsRow.toggle();

  if ($breakDetailsRow.is(':visible')) {
      $button.attr('src', ROOT + 'assets/img/breaks-up-arrow.png');  
  } else {
      $button.attr('src', ROOT + 'assets/img/breaks-down-arrow.png');
  }

  if ($breakDetailsRow.is(':visible') && $accordionBody.text().trim() === 'Loading...') {
      $.ajax({
          url: "Admin/BreakStamps",
          method: 'GET',
          data: {
              daily_id: dailyId
          },
          dataType: 'json',
          success: function(data) { 
              var content = '<table class="table table-responsive"><thead><tr>';
              for (let i = 0; i < data.length; i++) {
                  content += '<th>Break ' + (i + 1) + ' Start</th><th>Break ' + (i + 1) + ' End</th>';
              }
              content += '</tr></thead><tbody>';
              if (data.length > 0) {
                  content += '<tr>';
                  data.forEach(function(report) {
                      content += '<td>' + report.BREAK_IN + '</td><td>' + report.BREAK_OUT + '</td>';
                  });
                  content += '</tr>';
              } else {
                  content += '<tr><td colspan="' + (data.length * 2) + '">No breaks taken</td></tr>';
              }
              content += '</tbody></table>';
              $accordionBody.html(content);
          },
          error: function(xhr, status, error) {
              console.error('AJAX error:', status, error);
              $accordionBody.html('Error fetching break data');
          }
      });
  }
});

const editButtons = document.querySelectorAll(".edit-report-btn");
editButtons.forEach((button) => {
  button.addEventListener("click", function() {
      const dailyId = this.getAttribute("data-daily-id");
      const empId = this.getAttribute("data-emp-id");
      const empName = this.getAttribute("data-name");
      const reportDate = this.getAttribute("data-date");
      const empClockin = this.getAttribute("data-clock-in");
      const empLunchin = this.getAttribute("data-lunch-in");
      const empLunchout = this.getAttribute("data-lunch-out");
      const empClockout = this.getAttribute("data-clock-out");

      document.getElementById('modal-employee-name').value = empName;
      document.getElementById('modal-report-date').value = reportDate;
      document.getElementById('modal-clock-in').value = empClockin;
      document.getElementById('modal-lunch-in').value = empLunchin;
      document.getElementById('modal-lunch-out').value = empLunchout;
      document.getElementById('modal-clock-out').value = empClockout;

      let originalBreakData = [];

      $.ajax({
          url: "Admin/BreakStamps",
          method: 'GET',
          data: {
              daily_id: dailyId
          },
          dataType: 'json',
          success: function(data) {
              var breakInputs = '';
              data.forEach(function(report, index) {
                  breakInputs += `<div class="mb-2" style="text-align: left;">
                 Break ${index + 1} Start:
                 <input type="text" class="mt-1 form-control break-start" value="${report.BREAK_IN}" data-record-id="${report.RECORD_ID}">
             </div>
             <div class="mb-2" style="text-align: left;">
                 Break ${index + 1} End:
                 <input type="text" class="mt-1 form-control break-end" value="${report.BREAK_OUT}" data-record-id="${report.RECORD_ID}">
             </div>`;
              });
              document.getElementById('breakInputs').innerHTML = breakInputs;
              originalBreakData = data;
          },
          error: function(xhr, status, error) {
              console.error('AJAX error:', status, error);
          }
      });

      document.getElementById("updateReport").addEventListener("click", function() {
          const modalClockIn = document.getElementById('modal-clock-in').value;
          const modalClockOut = document.getElementById('modal-clock-out').value;
          const modalLunchIn = document.getElementById('modal-lunch-in').value;
          const modalLunchOut = document.getElementById('modal-lunch-out').value;

          // This will check if the input data is a valid time format
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
                  success: function(data) {
                      $('#editReportModal').modal('hide');
                      if (timeFormat.test(modalClockIn)) { 
                          Swal.fire({
                              title: "Success",
                              text: "Report has been updated successfully!",
                              icon: "success"
                          }); 
                      } else {
                          Swal.fire({
                              title: "Error",
                              html: "Failed to update report!<br>Invalid time format. Please use HH:MM:SS AM/PM.",
                              icon: "warning"
                          });
                      }
                      $('.swal2-confirm').click(function() {
                          location.reload();
                      })
                  },
                  error: function(xhr, status, error) {
                      Swal.fire({
                          title: "Error",
                          html: "Failed to update report!<br>Please make sure updated entries are within the correct range: not earlier, equal, or later than other time stamps.",
                          icon: "warning"
                      });
                      $('.swal2-confirm').click(function() {
                          location.reload();
                      })
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
                  success: function(data) {
                      $('#editReportModal').modal('hide');
                      if (timeFormat.test(modalClockOut)) {
                          Swal.fire({
                              title: "Success",
                              text: "Report has been updated successfully!",
                              icon: "success"
                          });
                      } else {
                          Swal.fire({
                              title: "Error",
                              html: "Failed to update report!<br>Invalid time format. Please use HH:MM:SS AM/PM.",
                              icon: "warning"
                          });
                      }
                      $('.swal2-confirm').click(function() {
                          location.reload();
                      })
                  },
                  error: function(xhr, status, error) {
                      Swal.fire({
                          title: "Error",
                          html: "Failed to update report!<br>Please make sure updated entries are within the correct range: not earlier, equal, or later than other time stamps.",
                          icon: "warning"
                      });
                      $('.swal2-confirm').click(function() {
                          location.reload();
                      })
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
                  success: function(data) {
                      $('#editReportModal').modal('hide');
                      if (timeFormat.test(modalLunchIn) && timeFormat.test(modalLunchOut)) {
                          Swal.fire({
                              title: "Success",
                              text: "Report has been updated successfully!",
                              icon: "success"
                          });
                      } else {
                          Swal.fire({
                              title: "Error",
                              html: "Failed to update report!<br>Invalid time format. Please use HH:MM:SS AM/PM.",
                              icon: "warning"
                          });
                      }
                      $('.swal2-confirm').click(function() {
                          location.reload();
                      })
                  },
                  error: function(xhr, status, error) {
                      Swal.fire({
                          title: "Error",
                          html: "Failed to update report!<br>Please make sure updated entries are within the correct range: not earlier, equal, or later than other time stamps.",
                          icon: "warning"
                      });
                      $('.swal2-confirm').click(function() {
                          location.reload();
                      })
                  },
              });
          }

          const breakInputs = document.querySelectorAll('#breakInputs input');
          for (let i = 0; i < breakInputs.length; i += 2) {
              const breakIn = breakInputs[i].value;
              const breakOut = breakInputs[i + 1].value;
              const recordId = breakInputs[i].getAttribute("data-record-id");

              if (breakIn !== originalBreakData[i / 2].BREAK_IN || breakOut !== originalBreakData[i / 2].BREAK_OUT) {
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
                      success: function(data) {
                          $('#editReportModal').modal('hide');
                          if (timeFormat.test(breakIn) && timeFormat.test(breakOut)) {
                              Swal.fire({
                                  title: "Success",
                                  text: "Report has been updated successfully!",
                                  icon: "success"
                              });
                          } else {
                              Swal.fire({
                                  title: "Error",
                                  html: "Failed to update report!<br>Invalid time format. Please use HH:MM:SS AM/PM.",
                                  icon: "warning"
                              });
                          }
                          $('.swal2-confirm').click(function() {
                              location.reload();
                          })
                      },
                      error: function(xhr, status, error) {
                          Swal.fire({
                              title: "Error",
                              html: "Failed to update report!<br>Please make sure updated entries are within the correct range: not earlier, equal, or later than other time stamps.",
                              icon: "warning"
                          });
                          $('.swal2-confirm').click(function() {
                              location.reload();
                          })
                      }
                  });
              }
          }

          $('#closeReport').click(function() {
              $('#editReportModal').modal('hide');
          })

      });
  });
});