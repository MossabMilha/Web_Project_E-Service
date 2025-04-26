// Function to apply colspan dynamically
function applyColspanAll() {
    const tables = document.querySelectorAll('table'); // Target all tables (or use a specific class)

    tables.forEach(table => {
        const rows = table.rows;
        if (rows.length === 0) return;

        const columnCount = rows[0].cells.length; // Get columns from the first row

        // Find all .colspan-all cells in this table
        const fullWidthCells = table.querySelectorAll('.colspan-all');
        fullWidthCells.forEach(cell => {
            cell.colSpan = columnCount;
        });
    });
}

// Run on page load and if table changes dynamically
document.addEventListener('DOMContentLoaded', applyColspanAll);
