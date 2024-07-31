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
    
    console.log('Search value:', searchValue);
    const response = await fetch(`/api/items/all?page=${page}`, {
        method: 'POST',
        credentials: 'include', // Include credentials (session cookies) if necessary
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ search: searchValue })
    });

    if (response.ok) {
        const data = await response.json();
        populateTable(data);
        console.log('All items:', data);

        // Handle pagination links
        populatePagination(data);
        return data;
    } else {
        console.error('Failed to fetch items');
        return null;
    }
}

function openUrl(url) {
    
    window.location.replace(url);
}

function populateTable(items) {
    const tbody = document.getElementById('items-tbody');
    tbody.innerHTML = ''; // Clear existing rows

    if (items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4">There are no data.</td></tr>';
        return;
    }

    items.data.forEach(item => {
        const tr = document.createElement('tr');

        const tdId = document.createElement('td');
        tdId.textContent = item.id;
        tr.appendChild(tdId);

        const tdItemName = document.createElement('td');
        tdItemName.textContent = item.item_category.name;
        tr.appendChild(tdItemName);

        const tdDescription = document.createElement('td');
        tdDescription.textContent = `${item.item_generic_name.name} ${item.item_brand.name} ${item.model}`;
        tr.appendChild(tdDescription);

        const tdAction = document.createElement('td');

        const htmlContent = `
        <div class="text-center">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
            
            <label class="btn btn-secondary " onclick="openUrl('/items/${item.id}')">
                <input type="radio" name="options" id="option1" autocomplete="off" > <i class="bi bi-eye-fill"></i>
            </label>
           
            <label class="btn btn-secondary" onclick="openUrl('/items/${item.id}/edit')">
                <input type="radio" name="options" id="option2" autocomplete="off"> <i class="bi bi-pencil-square"></i>
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option3" autocomplete="off"> <i class="bi bi-archive-fill"></i>
            </label>
            </div>
            </div>
            `;

// Append the HTML content to tdAction
tdAction.innerHTML = htmlContent;

        // Assuming actions buttons are added here
        tr.appendChild(tdAction);

        tbody.appendChild(tr);
    });
}


function populatePagination(data) {
    const pagination = document.querySelector('.pagination');
    pagination.innerHTML = '';

    if (data.prev_page_url) {
        const prevItem = document.createElement('li');
        prevItem.classList.add('page-item');
        const prevLink = document.createElement('a');
        prevLink.classList.add('page-link');
        prevLink.href = '#';
        prevLink.innerText = 'Previous';
        prevLink.onclick = (event) => {
            event.preventDefault();
            fetchAllItems(document.getElementById('search-input').value, data.current_page - 1);
        };
        prevItem.appendChild(prevLink);
        pagination.appendChild(prevItem);
    } else {
        const prevItem = document.createElement('li');
        prevItem.classList.add('page-item', 'disabled');
        const prevLink = document.createElement('a');
        prevLink.classList.add('page-link');
        prevLink.href = '#';
        prevLink.innerText = 'Previous';
        prevItem.appendChild(prevLink);
        pagination.appendChild(prevItem);
    }

    for (let page = 1; page <= data.last_page; page++) {
        const pageItem = document.createElement('li');
        pageItem.classList.add('page-item');
        if (page === data.current_page) {
            pageItem.classList.add('active');
        }
        const pageLink = document.createElement('a');
        pageLink.classList.add('page-link');
        pageLink.href = '#';
        pageLink.innerText = page;
        pageLink.onclick = (event) => {
            event.preventDefault();
            fetchAllItems(document.getElementById('search-input').value, page);
        };
        pageItem.appendChild(pageLink);
        pagination.appendChild(pageItem);
    }

    if (data.next_page_url) {
        const nextItem = document.createElement('li');
        nextItem.classList.add('page-item');
        const nextLink = document.createElement('a');
        nextLink.classList.add('page-link');
        nextLink.href = '#';
        nextLink.innerText = 'Next';
        nextLink.onclick = (event) => {
            event.preventDefault();
            fetchAllItems(document.getElementById('search-input').value, data.current_page + 1);
        };
        nextItem.appendChild(nextLink);
        pagination.appendChild(nextItem);
    } else {
        const nextItem = document.createElement('li');
        nextItem.classList.add('page-item', 'disabled');
        const nextLink = document.createElement('a');
        nextLink.classList.add('page-link');
        nextLink.href = '#';
        nextLink.innerText = 'Next';
        nextItem.appendChild(nextLink);
        pagination.appendChild(nextItem);
    }
}


