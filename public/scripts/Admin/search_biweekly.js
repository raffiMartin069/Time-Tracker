(() => {

    // Attach the event listener to a static parent element, e.g., `document`
document.addEventListener('keyup', function(event) {
    // Check if the event target is the search input
    if (event.target && event.target.id === 'searchInput') {
        // Your existing search logic here
        event.target.value = event.target.value.replace(/[^0-9]/g, '');
        const filter = event.target.value.trim();
        const tableRows = document.querySelectorAll('.table tbody tr');

        tableRows.forEach(row => {
            const weeklyIdCell = row.querySelector('td:first-child');
            if (weeklyIdCell) {
                const txtValue = weeklyIdCell.textContent || weeklyIdCell.innerText;
                const rowDisplay = txtValue.indexOf(filter) > -1 ? '' : 'none';
                row.style.display = rowDisplay;
            }
        });
    }
});
})();