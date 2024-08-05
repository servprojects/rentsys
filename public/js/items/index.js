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
    
    const response = await fetch(`/api/items/all?page=${page}`, {
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
        console.error('Failed to fetch items');
        return null;
    }
}

function populateTable(items) {
    const tbody = document.getElementById('items-tbody');
    tbody.innerHTML = ''; // Clear existing rows

    if (items.data.length === 0) {
        tbody.innerHTML = tableNoData();
        return;
    }

    items.data.forEach(item => {
        const tr = document.createElement('tr');

        const tdId = document.createElement('td');
        tdId.textContent = item.id;
        tr.appendChild(tdId);

        const tdItemName = document.createElement('td');
        tdItemName.textContent = item.item_category ? item.item_category.name : "";
        tr.appendChild(tdItemName);

        const tdDescription = document.createElement('td');
        tdDescription.textContent = `${item.item_generic_name ? item.item_generic_name.name : ''} ${item.item_brand ? item.item_brand.name: ''} ${item.model}`;
        tr.appendChild(tdDescription);

        const tdAction = document.createElement('td');

        var actionData = {
            viewClick: `openUrl('/items/${item.id}')`,
            editClick: `openUrl('/items/${item.id}/edit')`,
            idSuffix: `item-${item.id}`,
            id: item.id,
            deleteClick: `removeItem('/api/items/remove/${item.id}', ${item.id})`
        }

        tdAction.innerHTML = rowActions(actionData);

        tr.appendChild(tdAction);

        tbody.appendChild(tr);

       
    });
}

