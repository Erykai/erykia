function wrapTextWithBraces(element) {
    const textContent = element.textContent.trim();
    element.textContent = "{{" + textContent + "}}";
}

window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }

    // Wrap specific texts with braces
    const entriesPerPageLabel = document.querySelector('.datatable-dropdown label');
    const searchInput = document.querySelector('.datatable-search input');
    const datatableInfo = document.querySelector('.datatable-info');

    wrapTextWithBraces(entriesPerPageLabel);
    wrapTextWithBraces(datatableInfo);
    searchInput.placeholder = "{{" + searchInput.placeholder + "}}";
});