const search = () => {
    document.addEventListener('DOMContentLoaded', (event) => {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('.table-row');
    
        searchInput.addEventListener('keyup', function() {
            const inputValue = searchInput.value.trim().toLowerCase();
            const minLength = 2; // Minimum characters required for initial search
    
            // Show all rows if search input is empty
            if (inputValue === '') {
                tableRows.forEach(row => {
                    row.style.display = '';
                });
                return;
            }
    
            // Show initial results if input length is less than minLength
            if (inputValue.length < minLength) {
                tableRows.forEach(row => {
                    row.style.display = 'none';
                });
                return;
            }
    
            // Filter rows based on search input
            tableRows.forEach(row => {
                const rowData = row.textContent.trim().toLowerCase();
                if (rowData.includes(inputValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
}


const dashboardSorting = () => {
    document.addEventListener('DOMContentLoaded', (event) => {
        const sortBySelect = document.querySelector('.form-control.mx-lg-2.mx-3');
        const tableBody = document.getElementById('tableBody');
    
        sortBySelect.addEventListener('change', function() {
            let rows = Array.from(tableBody.querySelectorAll('tr'));
            if (this.value === '1') { // Assuming '1' is for Oldest
                rows.sort((a, b) => {
                    let dateA = new Date(a.cells[0].textContent.trim()); // Assuming the date is in the first column
                    let dateB = new Date(b.cells[0].textContent.trim());
                    return dateA - dateB;
                });
            } else if (this.value === '2') { // Assuming '2' is for Newest
                rows.sort((a, b) => {
                    let dateA = new Date(a.cells[0].textContent.trim());
                    let dateB = new Date(b.cells[0].textContent.trim());
                    return dateB - dateA;
                });
            }
            // Re-append rows to the table body
            rows.forEach(row => tableBody.appendChild(row));
        });
    });
}

search();
dashboardSorting();