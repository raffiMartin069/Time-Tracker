(() => {
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

    const managementSorting = () => {
        document.addEventListener('DOMContentLoaded', () => {
            const sortBySelect = document.querySelector('.filter-hover');
            const tableBody = document.getElementById('tableBody');
    
            sortBySelect.addEventListener('change', function() {
                let rows = Array.from(tableBody.querySelectorAll('tr'));
                if (this.value === '1') { // Oldest First
                    rows.sort((a, b) => {
                        let hireDateA = new Date(a.cells[4].textContent.trim());
                        let hireDateB = new Date(b.cells[4].textContent.trim());
                        return hireDateA - hireDateB;
                    });
                } else if (this.value === '2') { // Newest First
                    rows.sort((a, b) => {
                        let hireDateA = new Date(a.cells[4].textContent.trim());
                        let hireDateB = new Date(b.cells[4].textContent.trim());
                        return hireDateB - hireDateA;
                    });
                }
                // Remove existing rows from the table body
                rows.forEach(row => tableBody.removeChild(row));
                // Re-append sorted rows to the table body
                rows.forEach(row => tableBody.appendChild(row));
            });
        });
    }

    managementSorting();
    search();
})();