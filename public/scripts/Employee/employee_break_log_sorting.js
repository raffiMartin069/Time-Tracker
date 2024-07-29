(() => {
    // sort from oldest to newest and vice versa according to the date.
    const sortSelect = document.getElementById('sort-select');
    const tableBody = document.getElementById('table-body');
    const tableRows = tableBody.getElementsByClassName('table-row');
    sortSelect.addEventListener('change', () => {
        const sortValue = sortSelect.value;
        const rows = Array.from(tableRows);
        if (sortValue === '1') {
            rows.sort((a, b) => {
                const dateA = new Date(a.cells[0].textContent);
                const dateB = new Date(b.cells[0].textContent);
                return dateA - dateB;
            });
        } else if (sortValue === '2') {
            rows.sort((a, b) => {
                const dateA = new Date(a.cells[0].textContent);
                const dateB = new Date(b.cells[0].textContent);
                return dateB - dateA;
            });
        }
        tableBody.innerHTML = '';
        rows.forEach(row => tableBody.appendChild(row));
    });
})();