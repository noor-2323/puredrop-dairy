<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PureDrop Dairy - Leads Dashboard</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #263238;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        h1 {
            margin-bottom: 8px;
            color: #176b52;
        }

        .subtitle {
            color: #607d8b;
            margin-bottom: 25px;
        }

        .toolbar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        input, select, button {
            padding: 11px;
            border: 1px solid #ccd5df;
            border-radius: 6px;
            font-size: 14px;
        }

        #search {
            flex: 1;
            min-width: 200px;
        }

        button {
            background: #176b52;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #10513e;
        }

        .table-wrapper {
            overflow-x: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 12px #0000000d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #e8edf2;
            text-align: left;
        }

        th {
            background: #e5f3ed;
            color: #176b52;
        }

        .status {
            padding: 5px 8px;
            border-radius: 5px;
            background: #eef2f5;
            display: inline-block;
        }

        .actions {
            display: flex;
            gap: 6px;
        }

        .delete-button {
            background: #c0392b;
        }

        .delete-button:hover {
            background: #922b21;
        }

        #message {
            margin: 15px 0;
            color: #176b52;
        }

        #pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        #pageInfo {
            font-size: 14px;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>PureDrop Dairy</h1>
        <p class="subtitle">Leads Management Dashboard</p>

        <div class="toolbar">
            <input
                type="search"
                id="search"
                placeholder="Search by name or email..."
                aria-label="Search leads"
            >

            <button id="searchButton" type="button">Search</button>
            <button id="addButton" type="button">+ Add Lead</button>
<div id="leadFormContainer" style="display: none; margin: 20px 0; padding: 20px; background: white; border-radius: 10px;">
    <h2>Add New Lead</h2>

    <form id="leadForm">
        <p>
            <label for="leadName">Name</label><br>
            <input type="text" id="leadName" required>
        </p>

        <p>
            <label for="leadEmail">Email</label><br>
            <input type="email" id="leadEmail" required>
        </p>

        <p>
            <label for="leadPhone">Phone</label><br>
            <input type="text" id="leadPhone">
        </p>

        <p>
            <label for="leadSource">Source</label><br>
            <select id="leadSource">
                <option value="">Select source</option>
                <option value="Website">Website</option>
                <option value="Facebook">Facebook</option>
                <option value="Referral">Referral</option>
                <option value="Advertisement">Advertisement</option>
            </select>
        </p>

        <p>
            <label for="leadStatus">Status</label><br>
            <select id="leadStatus" required>
                <option value="new">New</option>
                <option value="contacted">Contacted</option>
                <option value="qualified">Qualified</option>
                <option value="converted">Converted</option>
            </select>
        </p>

        <button type="submit">Save Lead</button>
        <button type="button" id="cancelButton">Cancel</button>
    </form>
</div>
         <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Source</th>
                        <th>Status</th </div>

        <p id="message" role="status"></p>

       <div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Source</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="leadsTable">
            <tr>
                <td colspan="6">Loading leads...</td>
            </tr>
        </tbody>
    </table>
</div>

<div id="pagination">
    <button id="previousButton" type="button">Previous</button>
    <span id="pageInfo">Page 1</span>
    <button id="nextButton" type="button">Next</button>
</div>
       
    </div>
</body>

<script>
    const API_URL = '/api/leads';

    let currentPage = 1;
    let lastPage = 1;
    let currentSearch = '';
    let editingLeadId = null;

    async function loadLeads(page = 1) {
        const tableBody = document.getElementById('leadsTable');
        const message = document.getElementById('message');
        const pageInfo = document.getElementById('pageInfo');

        tableBody.replaceChildren();
        message.textContent = 'Loading leads...';

        try {
            const params = new URLSearchParams({
                page: page,
                search: currentSearch
            });

            const response = await fetch(API_URL + '?' + params.toString(), {
                headers: {
                    'Accept': 'application/json',
                    'X-API-Token': 'PureDropLocalToken2026Secure'
                }
            });

            if (!response.ok) {
                throw new Error('Failed to load leads. Status: ' + response.status);
            }

            const result = await response.json();

            currentPage = result.current_page;
            lastPage = result.last_page;

            if (result.data.length === 0) {
                const row = document.createElement('tr');
                const cell = document.createElement('td');

                cell.colSpan = 6;
                cell.textContent = 'No leads found.';
                row.appendChild(cell);
                tableBody.appendChild(row);
            } else {
                result.data.forEach(function (lead) {
                    const row = document.createElement('tr');

                    [
                        lead.name,
                        lead.email,
                        lead.phone || 'N/A',
                        lead.source || 'N/A',
                        lead.status
                    ].forEach(function (value) {
                        const cell = document.createElement('td');
                        cell.textContent = value;
                        row.appendChild(cell);
                    });

const actionsCell = document.createElement('td');
actionsCell.className = 'actions';

const editButton = document.createElement('button');
editButton.type = 'button';
editButton.textContent = 'Edit';

editButton.addEventListener('click', function () {
  editingLeadId = lead.id;
    document.getElementById('leadName').value = lead.name;
    document.getElementById('leadEmail').value = lead.email;
    document.getElementById('leadPhone').value = lead.phone || '';
    document.getElementById('leadSource').value = lead.source || '';
    document.getElementById('leadStatus').value = lead.status;

    document.getElementById('leadFormContainer').style.display = 'block';
    document.querySelector('#leadFormContainer h2').textContent = 'Edit Lead';
    document.querySelector('#leadForm button[type="submit"]').textContent = 'Update Lead';
});

const deleteButton = document.createElement('button');
deleteButton.type = 'button';
deleteButton.textContent = 'Delete';
deleteButton.className = 'delete-button';
deleteButton.addEventListener('click', async function () {
    const confirmed = confirm('Are you sure you want to delete this lead?');

    if (!confirmed) {
        return;
    }

    try {
        const response = await fetch(`${API_URL}/${lead.id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-API-Token': 'PureDropLocalToken2026Secure'
            }
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Unable to delete lead.');
        }

        document.getElementById('message').textContent = 'Lead deleted successfully!';
        await loadLeads(currentPage);
    } catch (error) {
        document.getElementById('message').textContent = 'Error: ' + error.message;
    }
});

actionsCell.appendChild(editButton);
actionsCell.appendChild(deleteButton);
row.appendChild(actionsCell);

                    tableBody.appendChild(row);
                });
            }

            pageInfo.textContent =
                'Page ' + currentPage + ' of ' + lastPage;

            document.getElementById('previousButton').disabled =
                currentPage <= 1;

            document.getElementById('nextButton').disabled =
                currentPage >= lastPage;

            message.textContent = 'Leads loaded successfully.';

        } catch (error) {
            message.textContent = error.message;
        }
    }

    document.getElementById('searchButton').addEventListener('click', function () {
        currentSearch = document.getElementById('search').value.trim();
        loadLeads(1);
    });

    document.getElementById('search').addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            currentSearch = this.value.trim();
            loadLeads(1);
        }
});
document.getElementById('addButton').addEventListener('click', function () {
    editingLeadId = null;

    document.getElementById('leadForm').reset();

    document.querySelector('#leadFormContainer h2').textContent = 'Add New Lead';
    document.querySelector('#leadForm button[type="submit"]').textContent = 'Save Lead';

    document.getElementById('leadFormContainer').style.display = 'block';
});


   document.getElementById('cancelButton').addEventListener('click', function () {
    editingLeadId = null;
    document.getElementById('leadFormContainer').style.display = 'none';
    document.getElementById('leadForm').reset();

    document.querySelector('#leadFormContainer h2').textContent = 'Add New Lead';
    document.querySelector('#leadForm button[type="submit"]').textContent = 'Save Lead';
});

document.getElementById('leadForm').addEventListener('submit', async function (event) {
    event.preventDefault();

    const message = document.getElementById('message');

    const leadData = {
        name: document.getElementById('leadName').value.trim(),
        email: document.getElementById('leadEmail').value.trim(),
        phone: document.getElementById('leadPhone').value.trim() || null,
        source: document.getElementById('leadSource').value || null,
        status: document.getElementById('leadStatus').value
    };
    
    const wasEditing = editingLeadId !== null;
    message.textContent = 'Saving lead...';

    try{
       const url = editingLeadId
    ? `${API_URL}/${editingLeadId}`
    : API_URL;

const method = editingLeadId ? 'PUT' : 'POST';

const response = await fetch(url, {
    method: method,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-API-Token': 'PureDropLocalToken2026Secure'
    },
    body: JSON.stringify(leadData)
});

        const result = await response.json();

        if (!response.ok) {
            const details = result.errors
                ? Object.values(result.errors).flat().join(' ')
                : (result.message || 'Unable to save lead.');

            throw new Error(details);
        }

       document.getElementById('leadForm').reset();

editingLeadId = null;

document.querySelector('#leadFormContainer h2').textContent = 'Add New Lead';
document.querySelector('#leadForm button[type="submit"]').textContent = 'Save Lead';

document.getElementById('leadFormContainer').style.display = 'none';
        currentSearch = '';
        document.getElementById('search').value = '';

        await loadLeads(1);

message.textContent = wasEditing
    ? 'Lead updated successfully!'
    : 'Lead added successfully!';

    } catch (error) {
        message.textContent = 'Error: ' + error.message;
    }
});


    document.getElementById('previousButton').addEventListener('click', function () {
        if (currentPage > 1) {
            loadLeads(currentPage - 1);
        }
    });

    document.getElementById('nextButton').addEventListener('click', function () {
        if (currentPage < lastPage) {
            loadLeads(currentPage + 1);
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        loadLeads(1);
    });
</script>


</html>
