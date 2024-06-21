(() => {
    $(document).ready(function() {
        $("#addAdminBtn").click(function() {
            $.ajax({
                url: "Admin/manageNoneAdminAccess",
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var addAdminModal = $(".checkbox-group");
                    addAdminModal.empty();
                    if (data.length > 0) {
                        data.forEach(function(report) {
                            var option = `
                                <label>
                                    <input type="checkbox" class="select-member" value="${report.EMP_ID}">
                                    ${report.EMPLOYEE}
                                </label>`;
                            addAdminModal.append(option);
                        });
                    } else {
                        addAdminModal.append('<p>No Data Found</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading non-admin employees:', xhr.responseText);
                    alert('Failed to load non-admin employees.');
                }
            });
            $('#addAdminModal').modal('show');
        });

        // Adds admin to the list of admins
        $('#saveAdminBtn').click(function() {
            var empIds = [];
            $('.select-member:checked').each(function() {
                empIds.push($(this).val());
            });

            if (empIds.length === 0) {
                alert('Please select at least one member to add as admin.');
                return;
            }

            $.ajax({
                url: 'Admin/manageNoneAdminAccess',
                method: 'POST',
                data: {
                    empId: empIds
                },
                dataType: 'json',
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error adding admins:', xhr.responseText);
                    alert('An error occurred while adding admin(s).');
                }
            });
        });

        // Opens delete admin modal
        $("#deleteBtn").click(function() {
            $.ajax({
                url: "Admin/manageAdminAccess",
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var delAdmin = $("#delCheckBox");
                    delAdmin.empty();
                    if (data.length > 0) {
                        data.forEach(function(report) {
                            var row = `
                                <label>
                                    <input type="checkbox" class="select-member" value="${report.emp_id}">
                                    ${report.employee}
                                </label>`;
                            delAdmin.append(row);
                        });
                    } else {
                        delAdmin.append('<p>No Data Found</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading admin employees:', xhr.responseText);
                    alert('Failed to load admin employees.');
                }
            });
            $('#deleteAdminModal').modal('show');
        });

        // Deleting admins from selection
        $('#confirmDeleteBtn').click(function() {
            var empIds = [];
            $('.select-member:checked').each(function() {
                empIds.push($(this).val());
            });

            if (empIds.length === 0) {
                alert('Please select at least one admin to delete.');
                return;
            }

            $.ajax({
                url: 'Admin/manageAdminAccess',
                method: 'POST',
                data: {
                    empId: empIds
                },
                dataType: 'json',
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting admins:', xhr.responseText);
                    alert('An error occurred while deleting admin(s).');
                }
            });
        });

        // Highlight active tab
        var currentPage = new URLSearchParams(window.location.search).get('page');
        if (currentPage) {
            $('.tabs a').removeClass('active');
            $('.tabs a[href="?page=' + currentPage + '"]').addClass('active');
        }
    });
})();