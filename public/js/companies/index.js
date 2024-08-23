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
    
    const response = await fetch(`/api/companies/all?page=${page}`, {
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
        console.error('Failed to fetch company');
        return null;
    }
}

function populateTable(companies) {
    console.log(companies);
    const tbody = document.getElementById('items-tbody');
    tbody.innerHTML = ''; // Clear existing rows
   

    if (companies.data.length === 0) {
        tbody.innerHTML = tableNoData();
        return;
    }

    companies.data.forEach(company => {
        const tr = document.createElement('tr');

        const tdId = document.createElement('td');
        tdId.textContent = company.code;
        tr.appendChild(tdId);

       

        const tdSn = document.createElement('td');
        tdSn.textContent = company.name;
        tr.appendChild(tdSn);

        const tdItem = document.createElement('td');
        tdItem.textContent = company.email;
        tr.appendChild(tdItem);

        const tdAction = document.createElement('td');

        var actionData = {
            viewClick: `openUrl('/companies/${company.id}')`,
            editClick: `openUrl('/companies/${company.id}/edit')`,
            idSuffix: `company-${company.id}`,
            id: company.id,
            deleteClick: `removeItem('/api/companies/remove/${company.id}', ${company.id})`
        }

        tdAction.innerHTML = rowActions(actionData);

        tr.appendChild(tdAction);

        tbody.appendChild(tr);

       
    });
}

