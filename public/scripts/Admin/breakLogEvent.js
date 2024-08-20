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
            const sortSelect = document.getElementById('sort-select');
            const tableBody = document.getElementById('table-body');
        
            sortSelect.addEventListener('change', () => {
                const option = sortSelect.value;
                const rows = Array.from(tableBody.querySelectorAll('tr'));
        
                rows.sort((a, b) => {
                    const dateA = new Date(a.cells[2].innerText);
                    const dateB = new Date(b.cells[2].innerText);
        
                    if (option === '1') {
                        // Sort by Oldest
                        return dateA - dateB;
                    } else if (option === '2') {
                        // Sort by Newest
                        return dateB - dateA;
                    }
                });
        
                // Clear the table body
                tableBody.innerHTML = '';
        
                // Append sorted rows
                rows.forEach(row => tableBody.appendChild(row));
            });
        });
    }
    
    managementSorting();
    search();    
})()