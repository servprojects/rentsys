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
    
    const response = await fetch(`/api/assets/all?page=${page}`, {
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

function populateTable(assets) {
    const tbody = document.getElementById('items-tbody');
    tbody.innerHTML = ''; // Clear existing rows
   

    if (assets.data.length === 0) {
        tbody.innerHTML = tableNoData();
        return;
    }

    assets.data.forEach(asset => {
        const tr = document.createElement('tr');

        const tdId = document.createElement('td');
        tdId.textContent = asset.code;
        tr.appendChild(tdId);

       

        const tdSn = document.createElement('td');
        tdSn.textContent = asset.serial_number;
        tr.appendChild(tdSn);

        const tdItem = document.createElement('td');
        tdItem.textContent = asset.item? asset.item.description : '';
        tr.appendChild(tdItem);

        const tdAction = document.createElement('td');

        var actionData = {
            viewClick: `openUrl('/assets/${asset.id}')`,
            editClick: `openUrl('/assets/${asset.id}/edit')`,
            idSuffix: `asset-${asset.id}`,
            id: asset.id,
            deleteClick: `removeItem('/api/assets/remove/${asset.id}', ${asset.id})`
        }

        tdAction.innerHTML = rowActions(actionData);

        tr.appendChild(tdAction);

        tbody.appendChild(tr);

       
    });
}

