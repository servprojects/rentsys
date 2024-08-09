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

const assetSelect = document.getElementById('asset_id');
assetSelect.addEventListener('change',
    function(event) {
    fetchAllItems(document.getElementById('search-input').value, 1)});

async function fetchAllItems(searchValue,page = 1) {
    const assetSelect =document.getElementById('asset_id');
    var payload = { search: searchValue, asset_id: null };
    if(assetSelect.value != '0'){
        payload.asset_id = assetSelect.value;
    }
    
    const response = await fetch(`/api/rentals/all?page=${page}`, {
        method: 'POST',
        credentials: 'include', 
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
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

function populateTable(rentals) {
    const tbody = document.getElementById('items-tbody');
    tbody.innerHTML = ''; // Clear existing rows
   
    const today = new Date();
    const tomorrow = new Date();
    tomorrow.setDate(today.getDate() + 1);
    const todayOnly = today.toISOString().split('T')[0];
    const tomorrowOnly = tomorrow.toISOString().split('T')[0];
    var tomorrowBGColor = '#f67280';
    var todayBGColor = '#355c7d';
    var colorTextWBG = '#ffffff';

    if (rentals.data.length === 0) {
        tbody.innerHTML = tableNoData(5);
        return;
    }

    rentals.data.forEach(rental => {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const timeOptions = { hour: 'numeric', minute: 'numeric', hour12: true };

        const tr = document.createElement('tr');

        const tdId = document.createElement('td');
        tdId.textContent = rental.id;
        tr.appendChild(tdId);

        const tdSn = document.createElement('td');

        // Pick up date
        const pickupdate = new Date(rental.expected_pickup_datetime);
        const formattedDate = pickupdate.toLocaleDateString('en-US', options);
        const formattedTime = pickupdate.toLocaleTimeString('en-US', timeOptions);
        tdSn.textContent = `${formattedDate} - ${formattedTime}`;
        const pickupDateOnly = pickupdate.toISOString().split('T')[0];
        if (pickupDateOnly === todayOnly) {
            tdSn.style.backgroundColor = todayBGColor;
            tdSn.style.color = colorTextWBG;
        } else if (pickupDateOnly === tomorrowOnly) {
            tdSn.style.backgroundColor = tomorrowBGColor;
            tdSn.style.color = colorTextWBG;
        }        
        tr.appendChild(tdSn);
        // Pick up date

        // Return date
        const tdRn = document.createElement('td');
        const returndate = new Date(rental.expected_return_datetime);
        const returnformattedDate = returndate.toLocaleDateString('en-US', options);
        const returnformattedTime = returndate.toLocaleTimeString('en-US', timeOptions);
        tdRn.textContent = `${returnformattedDate} - ${returnformattedTime}`;
        const returnDateOnly = pickupdate.toISOString().split('T')[0];
        if (returnDateOnly === todayOnly) {
            tdRn.style.backgroundColor = todayBGColor;
            tdRn.style.color = colorTextWBG;
        } else if (returnDateOnly === tomorrowOnly) {
            tdRn.style.backgroundColor = tomorrowBGColor;
            tdRn.style.color = colorTextWBG;
        }        
        tr.appendChild(tdRn);
        // Return date

        const tdItem = document.createElement('td');
        tdItem.textContent = rental.asset? rental.asset.item.description : '';
        tr.appendChild(tdItem);

        const tdC = document.createElement('td');
        tdC.textContent = rental.client;
        tr.appendChild(tdC);

        const tdAction = document.createElement('td');

        var actionData = {
            viewClick: `openUrl('/rentals/${rental.id}')`,
            editClick: `openUrl('/rentals/${rental.id}/edit')`,
            idSuffix: `rental-${rental.id}`,
            id: rental.id,
            deleteClick: `removeItem('/api/rentals/remove/${rental.id}', ${rental.id})`
        }

        tdAction.innerHTML = rowActions(actionData);

        tr.appendChild(tdAction);

        tbody.appendChild(tr);

       
    });
}

