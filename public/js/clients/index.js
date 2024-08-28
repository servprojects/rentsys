$(document).ready(function() {
    $('.selectpicker').selectpicker();
});

fetchAllItems('', 1);
document.getElementById('search-button').addEventListener('click', function() {
    fetchAllItems(document.getElementById('search-input').value, 1)
});

document.getElementById("search-input").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        var inputValue = event.target.value;
        fetchAllItems(inputValue, 1);   
    }
});

async function fetchAllItems(searchValue,page = 1) {
    
    const response = await fetch(`/api/clients/all?page=${page}`, {
        method: 'POST',
        credentials: 'include', 
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ search: searchValue })
    });

    if (response.ok) {
        const data = await response.json();
        populateTable(data);
        populatePagination(data, fetchAllItems);
        return data;
    } else {
        console.error('Failed to fetch asset');
        return null;
    }
}

function populateTable(clients) {
    console.log(clients);
    const tbody = document.getElementById('items-tbody');
    tbody.innerHTML = ''; // Clear existing rows
   

    if (clients.data.length === 0) {
        tbody.innerHTML = tableNoData();
        return;
    }

    clients.data.forEach(client => {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const tr = document.createElement('tr');

        const regDate = new Date( client.registration_date);
        const formattedRegDate = regDate.toLocaleDateString('en-US', options);

        const tdId = document.createElement('td');
        tdId.textContent = formattedRegDate;
        tr.appendChild(tdId);

        const tdSn = document.createElement('td');
        tdSn.textContent = client.person.first_name + " " + client.person.last_name;
        tr.appendChild(tdSn);

        const tdCn = document.createElement('td');
        tdCn.textContent = client.person.contact_number;
        tr.appendChild(tdCn);

      

        const tdAction = document.createElement('td');

        var actionData = {
            viewClick: `openUrl('/clients/${client.id}')`,
            editClick: `openUrl('/clients/${client.id}/edit')`,
            idSuffix: `client-${client.id}`,
            id: client.id,
            deleteClick: `removeItem('/api/client/remove/${client.id}', ${client.id})`
        }

        tdAction.innerHTML = rowActions(actionData);

        tr.appendChild(tdAction);

        tbody.appendChild(tr);

       
    });
}

