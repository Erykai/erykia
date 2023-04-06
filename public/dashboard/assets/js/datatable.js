//create datatable erykia
async function handleDeleteBtnClick(event, endpoint, newTrashValue) {
    event.preventDefault();

    const response = await fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + bearerErykia
        },
        body: JSON.stringify({ trash: newTrashValue })
    });

    const result = await response.json();
    displayMessage(result.text, result.type);
}
async function handlePermanentDeleteBtnClick(event, endpoint) {
    event.preventDefault();

    const response = await fetch(endpoint, {
        method: 'DELETE',
        headers: {
            'Authorization': 'Bearer ' + bearerErykia
        }
    });

    const result = await response.json();
    displayMessage(result.text, result.type);
}
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
function displayMessage(message, messageType) {
    const returnMsgElement = document.querySelector('#return-msg');
    returnMsgElement.textContent = capitalizeFirstLetter(message);
    returnMsgElement.style.color = messageType === 'error' ? 'red' : 'green';

    if (messageType === 'success') {
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    }
}
function createDataTable(endpoint, endpointAction, columnNames, trash) {
    const columns = columnNames.map(name => {
        return {"data": name, "searchable": true};
    });

    document.addEventListener('DOMContentLoaded', function () {
        let table = new DataTable(document.querySelector('#datatables'), {
            scrollX: '100%',
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    text: globalVariables.COPY,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    text: globalVariables.PRINT,
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ],
            "ajax": {
                "url": endpoint + trash,
                "headers": {
                    "Authorization": "Bearer " + bearerErykia
                },
                "dataSrc": "data",
                "data": function (d) {
                    d.start = d.start || 0;
                    d.length = d.length || 10;
                },
                "dataFilter": function (response) {
                    let json = JSON.parse(response);
                    json.recordsTotal = json.all || 0;
                    json.recordsFiltered = json.all || 0;
                    return JSON.stringify(json);
                }
            },
            "columns": columns.concat({
                "title": globalVariables.Action,
                "data": null,
                "render": function (data, type, row, meta) {
                    let readBtn = trash.endsWith('1') ? '' : globalVariables.readBtnTemplate.replace('%rowId%', row.id).replace('%endpointAction%', endpointAction);
                    let editBtn = trash.endsWith('1') ? '' : globalVariables.editBtnTemplate.replace('%rowId%', row.id).replace('%endpointAction%', endpointAction);
                    let deleteIcon = trash.endsWith('1') ? 'fas fa-undo' : 'fas fa-trash';
                    let deleteBtnColor = trash.endsWith('1') ? 'style="color: green;"' : '';
                    let newTrashValue = trash.endsWith('1') ? '0' : '1';
                    let deleteBtn = globalVariables.deleteBtnTemplate.replace('%rowId%', row.id).replace('%endpoint%', endpoint).replace('%newTrashValue%', newTrashValue).replace('%deleteIcon%', deleteIcon).replace('%deleteBtnColor%', deleteBtnColor);

                    let permanentDeleteBtn = '';
                    if (trash.endsWith('1')) {
                        permanentDeleteBtn = globalVariables.permanentDeleteBtnTemplate.replace('%rowId%', row.id).replace('%endpoint%', endpoint);
                    }

                    return `${readBtn} ${editBtn} ${deleteBtn} ${permanentDeleteBtn}`
                },
                "orderable": false,
                "searchable": false
            }),
            "paging": true,
            "pageLength": 10,
            "searching": true,
            "serverSide": true,
            "language": {
                "emptyTable": globalVariables.emptyTable,
                "info": globalVariables.info,
                "infoEmpty": globalVariables.infoEmpty,
                "infoFiltered": globalVariables.infoFiltered,
                "infoPostFix": globalVariables.infoPostFix,
                "thousands": globalVariables.thousands,
                "lengthMenu": globalVariables.lengthMenu,
                "loadingRecords": globalVariables.loadingRecords,
                "processing": globalVariables.processing,
                "search": globalVariables.search,
                "zeroRecords": globalVariables.zeroRecords,
                "paginate": {
                    "first": globalVariables.first,
                    "last": globalVariables.last,
                    "next": globalVariables.next,
                    "previous": globalVariables.previous
                },
                "aria": {
                    "sortAscending": globalVariables.sortAscending,
                    "sortDescending": globalVariables.sortDescending
                }
            }
        });

        // Add this event handler to update the search value before each AJAX request
        table.on('preXhr.dt', function (e, settings, data) {
            let searchInput = document.querySelector('input[type="search"]');
            if (searchInput) {
                data.search = searchInput.value;
            }
        });
    });
}